<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of School
 *
 * @author Slurp
 */
class School extends Member_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('school_model');
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
                ->join('kotakab','kotakab.kotakab_id=school.kotakab_id','left')
                ->get('school')
                ->result_array();
        $ret = [];
        foreach ($r as $i) {
            //craft return
            $i['id'] = $i['school_id'] + 0;
            $ret[] = $i;
        }
        echo json_encode($ret);
    }

    function add() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(6);
        $data['title'] = 'Tambah School';
        $data['css_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
             ['module' => 'polkam', 'asset' => 'select2.min.js']
        ];
        $this->template->display('school/add_view', $data);
    }

    function index() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(6);
        $data['title'] = 'tr.db | School';
        $this->template->display('school/table_view', $data);
    }

    function edit($id) {
        //load form and populate
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(6);
        $data['title'] = 'Ubah School';
        $data['edit_id'] = $id;
        $data['css_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
             ['module' => 'polkam', 'asset' => 'select2.min.js']
        ];
        $this->template->display('school/add_view', $data);
    }

    /**
     * Server-side processing for datatables
     */
    function dt() {
        if ($this->input->is_ajax_request()) {
            //ajax only
            $this->datatables
                    ->select('name,address,kotakab,school_id')
                    ->join('kotakab','kotakab.kotakab_id=school.kotakab_id')
                    ->add_column('DT_RowId', 'row_$1', 'school_id')
                    ->from('school');
            echo $this->datatables->generate();
        }
    }

    //REST-like
    function submit() {
        $id = $this->input->post('school_id');
        $nama = $this->input->post('name');
        $address = $this->input->post('address');
        $kotakab = $this->input->post('kotakab');
        if ($id) {
            //edit
            if ($this->school_model->update($id, $nama, $address, $kotakab)) {
                //update to neo4j
                postNeoQuery($this->school_model->neo4j_update_query($id, $nama, $address, $kotakab));
                if ($this->input->is_ajax_request()) {
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    //back to table
                    redirect('school');
                }
            } else {
                echo 0;
            }
        } else {
            //add
            //insert to db
            if ($new_id = $this->school_model->create($nama, $address, $kotakab)) {
                //insert to neo4j
                postNeoQuery($this->school_model->neo4j_insert_query($new_id));
                if ($this->input->is_ajax_request()) {
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    //back to table
                    redirect('school');
                }
            } else {
                echo 0;
            }
        }
    }

    function get($id) {
        echo json_encode($this->school_model->get($id));
    }

    function delete($id) {
        if ($this->school_model->delete($id)) {
            postNeoQuery($this->school_model->neo4j_delete_query($id));
            echo 1;
        } else {
            echo 0;
        }
    }

}
