<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Nonteror
 *
 * @author Slurp
 */
class Nonteror extends Member_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('nonteror_model');
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
            $this->db->or_where('UPPER(korban) LIKE', '%' . strtoupper($term) . '%');
            $this->db->or_where('UPPER(pidana) LIKE', '%' . strtoupper($term) . '%');
            $this->db->or_where('UPPER(tempat) LIKE', '%' . strtoupper($term) . '%');
        }
        $r = $this->db
                ->get('nonteror')
                ->result_array();
        $ret = [];
        foreach ($r as $i) {
            //craft return
            $i['id'] = $i['nonteror_id'] + 0;
            $ret[] = $i;
        }
        echo json_encode($ret);
    }

    function add() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(9);
        $data['title'] = 'Tambah Nonteror';
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
        $data['sources'] = $this->source_model->get_all();
        $this->template->display('nonteror/add_view', $data);
    }

    function index() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(9);
        $data['title'] = 'tr.db | Nonteror';
        $data['sources'] = $this->source_model->get_all();
        $this->template->display('nonteror/table_view', $data);
    }

    function edit($id) {
        //load form and populate
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(9);
        $data['title'] = 'Ubah Nonteror';
        $data['css_assets'] = [
            ['module' => 'ace', 'asset' => 'bootstrap-timepicker.css']
            , ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'polkam', 'asset' => 'combodate.js']
            , ['module' => 'polkam', 'asset' => 'select2.min.js']
            , ['module' => 'polkam', 'asset' => 'moment.js']
            , ['module' => 'ace', 'asset' => 'date-time/bootstrap-timepicker.js']
        ];
        $data['edit_id'] = $id;
        $this->template->display('nonteror/add_view', $data);
    }

    /**
     * Server-side processing for datatables
     */
    function dt() {
        if ($this->input->is_ajax_request()) {
            //ajax only
            $this->datatables
                    ->select('tempat,tanggal,korban,nonteror_id')
                    ->add_column('DT_RowId', 'row_$1', 'nonteror_id')
                    ->from('nonteror');
            echo $this->datatables->generate();
        }
    }

    //REST-like
    function submit() {
        $id = $this->input->post('nonteror_id');
        $tempat = $this->input->post('tempat');
        $pidana = $this->input->post('pidana');
        $kotakab = $this->input->post('kotakab');
        $korban = $this->input->post('korban');
        $tanggal = $this->input->post('tanggal');
        $waktu = $this->input->post('waktu');
        $motif = $this->input->post('motif');
        if ($id) {
            //edit
            if ($this->nonteror_model->update($id, $tempat, $kotakab, $tanggal, $waktu, $pidana, $korban, $motif)) {
                //update to neo4j
                postNeoQuery($this->nonteror_model->neo4j_update_query($id, $tempat, $tanggal, $waktu, $pidana, $korban));
                if ($this->input->is_ajax_request()) {
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    //back to table
                    redirect('nonteror');
                }
            } else {
                echo 0;
            }
        } else {
            //add
            //insert to db
            if ($new_id = $this->nonteror_model->create($tempat, $kotakab, $tanggal, $waktu, $pidana, $korban, $motif)) {
                //insert to neo4j
                postNeoQuery($this->nonteror_model->neo4j_insert_query($new_id));
                if ($this->input->is_ajax_request()) {
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    //back to table
                    redirect('nonteror');
                }
            } else {
                echo 0;
            }
        }
    }

    function get($id) {
        echo json_encode($this->nonteror_model->get($id));
    }

    function delete($id) {
        if ($this->nonteror_model->delete($id)) {
            postNeoQuery($this->nonteror_model->neo4j_delete_query($id));
            echo 1;
        } else {
            echo 0;
        }
    }

}
