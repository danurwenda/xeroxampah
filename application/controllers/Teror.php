<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Organization
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
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(2);
        $data['title'] = 'Tambah Organisasi';
        $data['css_assets'] = [
            ['module' => 'ace', 'asset' => 'datepicker.css'],
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.js']
        ];
        $data['sources'] = $this->source_model->get_all();
        $this->template->display('organisasi/add_view', $data);
    }

    function index() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(2);
        $data['title'] = 'tr.db | Organisasi';
        $data['css_assets'] = array(
            ['module' => 'ace', 'asset' => 'chosen.css']
        );
        $data['sources'] = $this->source_model->get_all();
        $this->template->display('organisasi/table_view', $data);
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
                    ->from('organization');
            echo $this->datatables->generate();
        }
    }

    //REST-like
    function post() {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('teror_id');
            $tanggal = $this->input->post('date');
            if (empty($tanggal)) {
                $tanggal = null;
            } else {
                //convert to SQL-compliant format
                $tanggal = date_format(date_create_from_format('d/m/Y', $tanggal), 'Y-m-d');
            }
            $waktu = $this->input->post('time');
            $serangan = $this->input->post('serangan');
            $sasaran = $this->input->post('sasaran');
            
            $tempat = $this->input->post('tempat');
            $motif = $this->input->post('motif');
            if ($id) {
                //edit
                if ($this->teror_model->update($id, $tempat, $tanggal, $waktu, $serangan, $sasaran, $motif)) {
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    echo 0;
                }
            } else {
                //add
                //insert to db
                if ($new_id=$this->teror_model->create($tempat, $tanggal, $waktu, $serangan, $sasaran, $motif)) {
                   //insert to neo4j
                   postNeoQuery($this->teror_model->neo4j_insert_query($new_id));
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    echo 0;
                }
            }
        }
    }

    function get($id) {
        echo json_encode($this->organization_model->get($id));
    }

    function delete($id) {
        if ($this->organization_model->delete($id)) {
            echo 1;
        } else {
            echo 0;
        }
    }

}
