<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Latsen
 *
 * @author Slurp
 */
class Latsen extends Member_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('latsen_model');
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
            $this->db->or_where('UPPER(tempat) LIKE', '%' . strtoupper($term) . '%');
            $this->db->or_where('UPPER(materi) LIKE', '%' . strtoupper($term) . '%');
            $this->db->or_where('UPPER(motif) LIKE', '%' . strtoupper($term) . '%');
        }
        $r = $this->db
                ->get('latsen')
                ->result_array();
        $ret = [];
        foreach ($r as $i) {
            //craft return
            $i['id'] = $i['latsen_id'] + 0;
            $ret[] = $i;
        }
        echo json_encode($ret);
    }

    function add() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(2);
        $data['title'] = 'Tambah Latsen';
        $data['css_assets'] = [
            ['module' => 'ace', 'asset' => 'datepicker.css'],
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.js']
        ];
        $data['sources'] = $this->source_model->get_all();
        $this->template->display('latsen/add_view', $data);
    }

    function index() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(2);
        $data['title'] = 'tr.db | Latsen';
        $data['css_assets'] = array(
            ['module' => 'ace', 'asset' => 'chosen.css']
        );
        $data['sources'] = $this->source_model->get_all();
        $this->template->display('latsen/table_view', $data);
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
                    ->from('latsen');
            echo $this->datatables->generate();
        }
    }

    //REST-like
    function post() {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('latsen_id');
            $sejak = $this->input->post('sejak');
            if (empty($sejak)) {
                $sejak = null;
            }
            $hingga = $this->input->post('hingga');
            if (empty($hingga)) {
                $hingga = null;
            }
            $materi = $this->input->post('materi');

            $tempat = $this->input->post('tempat');
            $motif = $this->input->post('motif');
            if ($id) {
                //edit
                if ($this->latsen_model->update($id, $tempat, $sejak, $hingga, $materi, $motif)) {
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    echo 0;
                }
            } else {
                //add
                //insert to db
                if ($new_id = $this->latsen_model->create($tempat, $sejak, $hingga, $materi, $motif)) {
                    //insert to neo4j
                    postNeoQuery($this->latsen_model->neo4j_insert_query($new_id));
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    echo 0;
                }
            }
        }
    }

    function get($id) {
        echo json_encode($this->latsen_model->get($id));
    }

    function delete($id) {
        if ($this->latsen_model->delete($id)) {
            echo 1;
        } else {
            echo 0;
        }
    }

}
