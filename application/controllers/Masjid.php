<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Masjid
 *
 * @author Slurp
 */
class Masjid extends Member_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('masjid_model');
        $this->load->model('menu_model');
        $this->load->library('Datatables');
    }

    /**
     * serves autocomplete 
     */
    function search() {
        //explode term by space
        $terms = explode(' ', $this->input->get('term', true));
        foreach ($terms as $term) {
            $this->db->or_where('UPPER(masjid_name) LIKE', '%' . strtoupper($term) . '%');
            $this->db->or_where('UPPER(address) LIKE', '%' . strtoupper($term) . '%');
        }
        $r = $this->db
                ->join('kotakab', 'kotakab.kotakab_id=masjid.kotakab_id', 'left')
                ->get('masjid')
                ->result_array();
        $ret = [];
        foreach ($r as $i) {
            //craft return
            $i['id'] = $i['masjid_id'] + 0;
            $ret[] = $i;
        }
        echo json_encode($ret);
    }

    function add() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(4);
        $data['title'] = 'Tambah Masjid';
        $data['css_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.js']
            , ['module' => 'polkam', 'asset' => 'masjid/config.js']
        ];
        $this->template->display('masjid/add_view', $data);
    }

    function index() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(4);
        $data['css_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.js']
            , ['module' => 'polkam', 'asset' => 'masjid/config.js']
        ];
        $data['title'] = 'tr.db | Masjid';
        $this->template->display('masjid/table_view', $data);
    }

    function edit($id) {
        //load form and populate
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(4);
        $data['title'] = 'Ubah Masjid';
        $data['edit_id'] = $id;
        $data['css_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.js']
            , ['module' => 'polkam', 'asset' => 'masjid/config.js']
        ];
        $this->template->display('masjid/add_view', $data);
    }

    function merge() {
        $success = true;
        //array of merged id
        $keep = $this->input->post('keep');
        $discard = $this->input->post('discard');
        //fields
        $nama = $this->input->post('masjid_name');
        $label = $this->input->post('label');
        $alamat = $this->input->post('address');
        $kotakab = $this->input->post('kotakab');
        $q = [];
        //step 1 : update sql
        if ($keep) {
            //edit
            if ($this->masjid_model->update($keep, $label, $nama, $alamat, $kotakab)) {
                //update to neo4j
                $q[] = $this->masjid_model->neo4j_update_query($keep, $label, $nama, $alamat, $kotakab);
            } else {
                $success = false;
            }
        }
        //step 2 : move pointers
        $this->load->model('pengajian_model');
        $refs = $this->db
                ->get_where('pengajian', ['masjid' => $discard])
                ->result();
        foreach ($refs as $ref) {
            //ubah masjid dari discard ke keep
            if ($this->pengajian_model->update($ref->pengajian_id, $ref->label, $ref->topik, $ref->rumah, $keep, $ref->school, $ref->lokasi)) {
                //update neo to reflect these changes
                $q[] = $this->pengajian_model->neo4j_update_query($ref->pengajian_id, $ref->label, $ref->topik, $ref->rumah, $keep, $ref->school);
            } else {
                $success = false;
            }
        }
        //step 3 : delete discard
        if ($this->masjid_model->delete($discard)) {
            $q[] = $this->masjid_model->neo4j_delete_query($discard);
        } else {
            $success = false;
        }
        if ($success) {
            postNeoQuery($q);
        }
        echo json_encode(['success' => $success]);
    }

    /**
     * Server-side processing for datatables
     */
    function dt() {
        if ($this->input->is_ajax_request()) {
            //ajax only
            $this->datatables
                    ->select('masjid_name,address,kotakab,masjid_id')
                    ->join('kotakab', 'kotakab.kotakab_id=masjid.kotakab_id', 'left')
                    ->add_column('DT_RowId', 'row_$1', 'masjid_id')
                    ->from('masjid');
            echo $this->datatables->generate();
        }
    }

    //REST-like
    function submit() {
        $id = $this->input->post('masjid_id');
        $nama = $this->input->post('masjid_name');
        $address = $this->input->post('address');
        $label = $this->input->post('label');
        $kotakab = $this->input->post('kotakab');
        if ($id) {
            //edit
            if ($this->masjid_model->update($id, $label, $nama, $address, $kotakab)) {
                //update to neo4j
                postNeoQuery($this->masjid_model->neo4j_update_query($id, $label, $nama, $address, $kotakab));
                if ($this->input->is_ajax_request()) {
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    //back to table
                    redirect('masjid');
                }
            } else {
                echo 0;
            }
        } else {
            //add
            //insert to db
            if ($new_id = $this->masjid_model->create($label, $nama, $address, $kotakab)) {
                //insert to neo4j
                postNeoQuery($this->masjid_model->neo4j_insert_query($new_id));
                if ($this->input->is_ajax_request()) {
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    //back to table
                    redirect('masjid');
                }
            } else {
                echo 0;
            }
        }
    }

    function get($id) {
        echo json_encode($this->masjid_model->get($id));
    }

    function delete($id) {
        if ($this->masjid_model->delete($id)) {
            postNeoQuery($this->masjid_model->neo4j_delete_query($id));
            echo 1;
        } else {
            echo 0;
        }
    }

}
