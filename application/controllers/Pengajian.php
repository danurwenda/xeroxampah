<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pengajian
 *
 * @author Slurp
 */
class Pengajian extends Member_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('pengajian_model');
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
            $this->db->or_where('UPPER(topik) LIKE', '%' . strtoupper($term) . '%');
            $this->db->or_where('UPPER(masjid.masjid_name) LIKE', '%' . strtoupper($term) . '%');
            $this->db->or_where('UPPER(school.school_name) LIKE', '%' . strtoupper($term) . '%');
        }
        $r = $this->db
                ->select("topik,masjid.masjid_name,pengajian.lokasi, school.school_name ,pengajian_id")
                ->join('masjid', 'masjid.masjid_id=pengajian.masjid', 'left')
                ->join('school', 'school.school_id=pengajian.school', 'left')
                ->get('pengajian')
                ->result_array();
        $ret = [];
        foreach ($r as $i) {
            //craft return
            $i['id'] = $i['pengajian_id'] + 0;
            $lokasi = '';
            if ($i['lokasi']) {
                $lokasi = $i['lokasi'];
            }
            if ($i['masjid_name']) {
                $lokasi.=(strlen($lokasi) ? ',' : '') . $i['masjid_name'];
            }
            if ($i['school_name']) {
                $lokasi.=(strlen($lokasi) ? ',' : '') . $i['school_name'];
            }
            $i['lokasi'] = $lokasi;
            $ret[] = $i;
        }
        echo json_encode($ret);
    }

    function add() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(7);
        $data['title'] = 'Tambah Pengajian';
        $data['css_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.js']
        ];
        $this->template->display('pengajian/add_view', $data);
    }

    function index() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(7);
        $data['css_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.js']
            ,['module' => 'polkam', 'asset' => 'pengajian/configs.js']
        ];
        $data['title'] = 'tr.db | Pengajian';
        $this->template->display('pengajian/table_view', $data);
    }

    function edit($id) {
        //load form and populate
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(7);
        $data['title'] = 'Ubah Pengajian';
        $data['edit_id'] = $id;
        $data['css_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.js']
        ];
        $this->template->display('pengajian/add_view', $data);
    }

    function merge() {
        $success = true;
        //array of merged id
        $keep = $this->input->post('keep');
        $discard = $this->input->post('discard');
        //fields
        $label = $this->input->post('label');
        $topik = $this->input->post('topik');
        $rumah = $this->input->post('rumah');
        $masjid = $this->input->post('masjid');
        $school = $this->input->post('school');
        $lokasi = $this->input->post('lokasi');
        $q = [];
        if ($keep) {
            //edit
            if ($this->pengajian_model->update($keep, $label, $topik, $rumah, $masjid, $school, $lokasi)) {
                //update to neo4j
                $q[] = $this->pengajian_model->neo4j_update_query($keep, $label, $topik, $rumah, $masjid, $school);
            } else {
                $success = false;
            }
        }
        //sejauh ini baru ada referensi incoming edge dari Individu
        $this->load->model('edge_model');
        $refs = $this->db
                ->join('edge_weight', 'edge_weight.weight_id=edge.weight_id')
                ->get_where('edge', ['target_id' => $discard, 'type' => 9])
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
        if ($this->pengajian_model->delete($discard)) {
            $q[] = $this->pengajian_model->neo4j_delete_query($discard);
        } else {
            $success = false;
        }
        if ($success) {
            postNeoQuery($q);
        }
        echo json_encode(['success' => $success, 'q' => $q]);
    }

    /**
     * Server-side processing for datatables
     */
    function dt() {
        if ($this->input->is_ajax_request()) {
            //ajax only
            $this->datatables
                    ->select('topik,lokasi,school_name,masjid_name,individu_name,pengajian_id')
                    ->add_column('DT_RowId', 'row_$1', 'pengajian_id')
                    ->from('pengajian')
                    ->join('individu', 'individu.individu_id=pengajian.rumah', 'left')
                    ->join('masjid', 'masjid.masjid_id=pengajian.masjid', 'left')
                    ->join('school', 'school.school_id=pengajian.school', 'left');
            echo $this->datatables->generate();
        }
    }

    //REST-like
    function submit() {
        $id = $this->input->post('pengajian_id');
        $nama = $this->input->post('topik');
        $label = $this->input->post('label');
        $rumah = $this->input->post('rumah');
        $lokasi = $this->input->post('lokasi');
        $masjid = $this->input->post('masjid');
        $masjid_name = $this->input->post('masjid_name');
        $masjid_address = $this->input->post('masjid_address');
        $masjid_kotakab = $this->input->post('masjid_kotakab');
        $school = $this->input->post('school');
        $school_name = $this->input->post('school_name');
        $school_address = $this->input->post('school_address');
        $school_kotakab = $this->input->post('school_kotakab');
        if ($id) {
            //edit
            if ($this->pengajian_model->update($id, $label, $nama, $rumah, $masjid, $school, $lokasi)) {
                //update to neo4j
                $q = $this->pengajian_model->neo4j_update_query($id, $label, $nama, $rumah, $masjid, $school, $lokasi);
                postNeoQuery($q);
                if ($this->input->is_ajax_request()) {
                    echo json_encode([ $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    //back to table
                    redirect('pengajian');
                }
            } else {
                echo 0;
            }
        } else {
            //add
            //kalo masjid nya kosong, tapi ada masjid_name dan kotakab,
            //add mesjid
            if (!isset($masjid) && (isset($masjid_name) && isset($masjid_kotakab) && isset($masjid_address))) {
                $this->load->model('masjid_model');
                $masjid = $this->masjid_model->create($masjid_name, $masjid_address, $masjid_kotakab);
                $q[] = $this->masjid_model->neo4j_insert_query($masjid);
            }
            if (!isset($school) && (isset($school_name) && isset($school_kotakab) && isset($school_address))) {
                $this->load->model('school_model');
                $school = $this->school_model->create($school_name, $school_address, $school_kotakab);
                $q[] = $this->school_model->neo4j_insert_query($school);
            }
            //insert to db
            if ($new_id = $this->pengajian_model->create($label, $nama, $rumah, $masjid, $school, $lokasi)) {
                //insert to neo4j
                $q[] = $this->pengajian_model->neo4j_insert_query($new_id);
                postNeoQuery($q);
                if ($this->input->is_ajax_request()) {
                    echo json_encode(['q' => $q, $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    //back to table
                    redirect('pengajian');
                }
            } else {
                echo 0;
            }
        }
    }

    function get($id) {
        echo json_encode($this->pengajian_model->get($id));
    }

    function delete($id) {
        if ($this->pengajian_model->delete($id)) {
            postNeoQuery($this->pengajian_model->neo4j_delete_query($id));
            echo 1;
        } else {
            echo 0;
        }
    }

}
