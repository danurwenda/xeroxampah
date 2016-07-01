<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Teror
 *
 * @author Slurp
 */
class Teror extends Member_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('teror_model');
        $this->load->model('source_model');
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
            $this->db->or_where('UPPER(sasaran) LIKE', '%' . strtoupper($term) . '%');
            $this->db->or_where('UPPER(serangan) LIKE', '%' . strtoupper($term) . '%');
            $this->db->or_where('UPPER(tempat) LIKE', '%' . strtoupper($term) . '%');
        }
        $r = $this->db
                ->get('teror')
                ->result_array();
        $ret = [];
        foreach ($r as $i) {
            //craft return
            $i['id'] = $i['teror_id'] + 0;
            $ret[] = $i;
        }
        echo json_encode($ret);
    }

    function add() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(8);
        $data['title'] = 'Tambah Teror';
        $data['css_assets'] = [
            ['module' => 'ace', 'asset' => 'bootstrap-timepicker.css']
            , ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'polkam', 'asset' => 'combodate.js']
            , ['module' => 'ace', 'asset' => 'date-time/bootstrap-timepicker.js']
            , ['module' => 'polkam', 'asset' => 'moment.js']
            , ['module' => 'polkam', 'asset' => 'select2.min.js']
        ];
        $this->template->display('teror/add_view', $data);
    }

    function index() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(8);
        $data['title'] = 'tr.db | Teror';
        $this->template->display('teror/table_view', $data);
    }

    function edit($id) {
        //load form and populate
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(8);
        $data['title'] = 'Ubah Teror';
        $data['css_assets'] = [
            ['module' => 'ace', 'asset' => 'bootstrap-timepicker.css']
            , ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'polkam', 'asset' => 'combodate.js']
            , ['module' => 'polkam', 'asset' => 'moment.js']
            , ['module' => 'ace', 'asset' => 'date-time/bootstrap-timepicker.js']
            , ['module' => 'polkam', 'asset' => 'select2.min.js']
        ];
        $data['edit_id'] = $id;
        $this->template->display('teror/add_view', $data);
    }

    /**
     * Server-side processing for datatables
     */
    function dt() {
        if ($this->input->is_ajax_request()) {
            //ajax only
            $this->datatables
                    ->select('tempat,tanggal,sasaran,serangan,teror_id')
                    ->add_column('DT_RowId', 'row_$1', 'teror_id')
                    ->from('teror');
            echo $this->datatables->generate();
        }
    }

    //REST-like
    function submit() {
        $id = $this->input->post('teror_id');
        $tempat = $this->input->post('tempat');
        $serangan = $this->input->post('serangan');
        $kotakab = $this->input->post('kotakab');
        $sasaran = $this->input->post('sasaran');
        $label = $this->input->post('label');
        $tanggal = $this->input->post('tanggal');
        if (empty($tanggal)) {
            $tanggal = null;
        }
        $waktu = $this->input->post('waktu');
        $motif = $this->input->post('motif');
        if ($id) {
            //edit
            if ($this->teror_model->update($id, $label,$tempat, $kotakab, $tanggal, $waktu, $serangan, $sasaran, $motif)) {
                //update to neo4j
                postNeoQuery($this->teror_model->neo4j_update_query($id,$label, $tempat, $tanggal, $waktu, $serangan, $sasaran));
                if ($this->input->is_ajax_request()) {
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    //back to table
                    redirect('teror');
                }
            } else {
                echo 0;
            }
        } else {
            //add
            //insert to db
            if ($new_id = $this->teror_model->create($label,$tempat, $kotakab, $tanggal, $waktu, $serangan, $sasaran, $motif)) {
                //insert to neo4j
                postNeoQuery($this->teror_model->neo4j_insert_query($new_id));
                if ($this->input->is_ajax_request()) {
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    //back to table
                    redirect('teror');
                }
            } else {
                echo 0;
            }
        }
    }

    function get($id) {
        echo json_encode($this->teror_model->get($id));
    }

    function delete($id) {
        if ($this->teror_model->delete($id)) {
            postNeoQuery($this->teror_model->neo4j_delete_query($id));
            echo 1;
        } else {
            echo 0;
        }
    }

}
