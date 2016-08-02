<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Lapas
 *
 * @author Slurp
 */
class Lapas extends Member_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('lapas_model');
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
            $this->db->or_where('UPPER(name) LIKE', '%' . strtoupper($term) . '%');
            $this->db->or_where('UPPER(address) LIKE', '%' . strtoupper($term) . '%');
        }
        $r = $this->db
                ->join('kotakab', 'kotakab.kotakab_id=lapas.kotakab_id', 'left')
                ->get('lapas')
                ->result_array();
        $ret = [];
        foreach ($r as $i) {
            //craft return
            $i['id'] = $i['lapas_id'] + 0;
            $ret[] = $i;
        }
        echo json_encode($ret);
    }

    function add() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(5);
        $data['title'] = 'Tambah Lapas';
        $data['css_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.js'],
            ['module' => 'polkam', 'asset' => 'lapas/config.js']
        ];
        $this->template->display('lapas/add_view', $data);
    }

    function index() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(5);
        $data['title'] = 'tr.db | Lapas';
        $data['css_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.js'],
            ['module' => 'polkam', 'asset' => 'lapas/config.js']
        ];
        $this->template->display('lapas/table_view', $data);
    }

    function edit($id) {
        //load form and populate
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(5);
        $data['title'] = 'Ubah Lapas';
        $data['css_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.js'],
            ['module' => 'polkam', 'asset' => 'lapas/config.js']
        ];
        $data['edit_id'] = $id;
        $this->template->display('lapas/add_view', $data);
    }

    function merge() {
        $success = true;
        //array of merged id
        $keep = $this->input->post('keep');
        $discard = $this->input->post('discard');
        //fields
        $nama = $this->input->post('name');
        $label = $this->input->post('label');
        $alamat = $this->input->post('address');
        $kotakab = $this->input->post('kotakab');
        $q = [];
        if ($keep) {
            //edit
            if ($this->lapas_model->update($keep, $label, $nama, $alamat,$kotakab)) {
                //update to neo4j
                $q[] = $this->lapas_model->neo4j_update_query($keep, $label, $nama, $alamat,$kotakab);
            } else {
                $success = false;
            }
        }
        //sejauh ini baru ada referensi incoming edge dari Individu
        $this->load->model('edge_model');
        $refs = $this->db
                ->join('edge_weight', 'edge_weight.weight_id=edge.weight_id')
                ->get_where('edge', ['target_id' => $discard, 'type' => 12])
                ->result();
        foreach ($refs as $ref) {
            //ubah target_id ke $keep
            if ($this->edge_model->update($ref->edge_id, $ref->source_id, $keep, $ref->properties)) {
                //update neo to reflect these changes
                $q[] = $this->edge_model->neo4j_update_query($ref->edge_id);
            } else {
                $success = false;
            }
        }
        if ($this->lapas_model->delete($discard)) {
            $q[] = $this->lapas_model->neo4j_delete_query($discard);
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
                    ->select('name,address,kotakab,lapas_id')
                    ->join('kotakab', 'kotakab.kotakab_id=lapas.kotakab_id', 'left')
                    ->add_column('DT_RowId', 'row_$1', 'lapas_id')
                    ->from('lapas');
            echo $this->datatables->generate();
        }
    }

    //REST-like
    function submit() {
        $id = $this->input->post('lapas_id');
        $nama = $this->input->post('name');
        $label = $this->input->post('label');
        $address = $this->input->post('address');
        $kotakab = $this->input->post('kotakab');
        if ($id) {
            //edit
            if ($this->lapas_model->update($id, $label, $nama, $address, $kotakab)) {
                //update to neo4j
                postNeoQuery($this->lapas_model->neo4j_update_query($id, $label, $nama, $address, $kotakab));
                if ($this->input->is_ajax_request()) {
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    //back to table
                    redirect('lapas');
                }
            } else {
                echo 0;
            }
        } else {
            //add
            //insert to db
            if ($new_id = $this->lapas_model->create($label, $nama, $address, $kotakab)) {
                //insert to neo4j
                postNeoQuery($this->lapas_model->neo4j_insert_query($new_id));
                if ($this->input->is_ajax_request()) {
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    //back to table
                    redirect('lapas');
                }
            } else {
                echo 0;
            }
        }
    }

    function get($id) {
        echo json_encode($this->lapas_model->get($id));
    }

    function delete($id) {
        if ($this->lapas_model->delete($id)) {
            postNeoQuery($this->lapas_model->neo4j_delete_query($id));
            echo 1;
        } else {
            echo 0;
        }
    }

}
