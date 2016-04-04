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
        $this->load->model('source_model');
        $this->load->model('menu_model');
        $this->load->library('Datatables');
    }

    function add() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(2);
        $data['title'] = 'Tambah Lapas';
        $data['css_assets'] = [
            ['module' => 'ace', 'asset' => 'datepicker.css'],
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.js']
        ];
        $data['sources'] = $this->source_model->get_all();
        $this->template->display('lapas/add_view', $data);
    }

    function index() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(2);
        $data['title'] = 'tr.db | Lapas';
        $data['css_assets'] = array(
            ['module' => 'ace', 'asset' => 'chosen.css']
        );
        $data['sources'] = $this->source_model->get_all();
        $this->template->display('lapas/table_view', $data);
    }

    /**
     * Server-side processing for datatables
     */
    function dt() {
        if ($this->input->is_ajax_request()) {
            //ajax only
            $this->datatables
                    ->select('org_name,address,description,org_id')
                    ->add_column('DT_RowId', 'row_$1', 'org_id')
                    ->from('lapas');
            echo $this->datatables->generate();
        }
    }

    function search() {
        $r = $this->db
                ->or_where('UPPER(name) LIKE', '%' . strtoupper($this->input->get('term', true)) . '%')
                ->or_where('UPPER(address) LIKE', '%' . strtoupper($this->input->get('term', true)) . '%')
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

    //REST-like
    function post() {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('lapas_id');
            $nama = $this->input->post('name');
            $address = $this->input->post('address');
            if ($id) {
                //edit
                if ($this->lapas_model->update($id, $nama, $address)) {
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    echo 0;
                }
            } else {
                //add
                //insert to db
                if ($new_id = $this->lapas_model->create($nama, $address)) {
                    //insert to neo4j
                    postNeoQuery($this->lapas_model->neo4j_insert_query($new_id));
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    echo 0;
                }
            }
        }
    }

    function get($id) {
        echo json_encode($this->lapas_model->get($id));
    }

    function delete($id) {
        if ($this->lapas_model->delete($id)) {
            echo 1;
        } else {
            echo 0;
        }
    }

}
