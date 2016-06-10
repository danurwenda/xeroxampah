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
            ['module' => 'polkam', 'asset' => 'select2.min.js']
        ];
        $this->template->display('lapas/add_view', $data);
    }

    function index() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(5);
        $data['title'] = 'tr.db | Lapas';
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
            ['module' => 'polkam', 'asset' => 'select2.min.js']
        ];
        $data['edit_id'] = $id;
        $this->template->display('lapas/add_view', $data);
    }

    /**
     * Server-side processing for datatables
     */
    function dt() {
        if ($this->input->is_ajax_request()) {
            //ajax only
            $this->datatables
                    ->select('name,address,kotakab,lapas_id')
                    ->join('kotakab', 'kotakab.kotakab_id=lapas.kotakab_id')
                    ->add_column('DT_RowId', 'row_$1', 'lapas_id')
                    ->from('lapas');
            echo $this->datatables->generate();
        }
    }

    //REST-like
    function submit() {
        $id = $this->input->post('lapas_id');
        $nama = $this->input->post('name');
        $address = $this->input->post('address');
        $kotakab = $this->input->post('kotakab');
        if ($id) {
            //edit
            if ($this->lapas_model->update($id, $nama, $address, $kotakab)) {
                //update to neo4j
                postNeoQuery($this->lapas_model->neo4j_update_query($id, $nama, $address, $kotakab));
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
            if ($new_id = $this->lapas_model->create($nama, $address, $kotakab)) {
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
