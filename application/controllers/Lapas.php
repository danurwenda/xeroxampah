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
class Lapas extends Member_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('individu_model');
        $this->load->model('source_model');
        $this->load->model('menu_model');
        $this->load->library('Datatables');
    }

    function index() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(3);
        $data['title'] = 'tr.db | Individu';

        $this->template->display('individu/table_view', $data);
    }

    function add() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(3);
        $data['title'] = 'Tambah Individu';
        $data['css_assets'] = [
            ['module' => 'ace', 'asset' => 'datepicker.css'],
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.js']
        ];
        $data['sources'] = $this->source_model->get_all();
        $this->template->display('individu/add_view', $data);
    }

    function submit() {
        //list all column on db
        //simple
        $name = $this->input->post('name');
        $alias = $this->input->post('alias');
        $born_date = $this->input->post('born_date');
        $born_place = $this->input->post('born_place');
        $nationality = $this->input->post('nationality');
        $edu_formal = $this->input->post('formaledu');
        $edu_non_formal = $this->input->post('formaledu');
        $edu_military;
        $relation;
        $majlis;
        $address;
        $religion;
        $recent_job;
        $recent_edu;
        $organization_history;
        $job_history;
        $radicalized;
        $peristiwa;
        $perbuatan;
        $network;
        $strata;
        $is_cooperative;


        //array
        $masjids;
        $saudaras;
        $anaks;
        $pesantrens;


        $job = $this->input->post('job');
        //back to table
        redirect('individu');
    }

    /**
     * Server-side processing for datatables
     */
    function dt() {
        if ($this->input->is_ajax_request()) {
            $this->datatables
                    ->select('name,network,born_date,born_place,alias,individu_id')
                    ->add_column('DT_RowId', 'row_$1', 'individu_id')
                    ->from('individu');
            echo $this->datatables->generate();
        }
    }

    /**
     * serves autocomplete 
     */
    function search() {
        $r = $this->db
                ->where('UPPER(name) LIKE', '%' . strtoupper($this->input->get('term', true)) . '%')
                ->get('lapas')
                ->result();
        $ret = [];
        foreach ($r as $i) {
            //craft return
            $ret[] = [
                'label' => $i->name,
                'value' => $i->name,
                'id' => $i->lapas_id
            ];
        }
        echo json_encode($ret);
    }

    //REST-like
    function post() {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('individu_id');
            $nama = $this->input->post('name');
            $alias = $this->input->post('alias');
            $affiliation = $this->input->post('affiliation');
            $nationality = $this->input->post('nationality');
            $family_conn = $this->input->post('family_conn');
            $d = $this->input->post('born_date');
            $born_date = empty($d) ? null : date_format(date_create_from_format('d/m/Y', $d), 'Y-m-d');
            $born_place = $this->input->post('born_place');
            $detention_history = $this->input->post('detention_history');
            $detention_status = $this->input->post('detention_status');
            $education = $this->input->post('education');
            $source_id = $this->input->post('source_id');
            if ($id) {
//                //edit
                if ($this->individu_model->update(
                                $id, $nama, $alias, $born_date, $born_place, $nationality, $detention_history, $detention_status, $education, $affiliation, $family_conn, $source_id)) {
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    echo 0;
                }
            } else {
//                //add
                if ($this->individu_model->create(
                                $nama, $alias, $born_date, $born_place, $nationality, $detention_history, $detention_status, $education, $affiliation, $family_conn, $source_id)) {
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    echo 0;
                }
            }
        }
    }

    function get($id) {
        echo json_encode($this->individu_model->get($id));
    }

    function delete($id) {
        if ($this->individu_model->delete($id)) {
            echo 1;
        } else {
            echo 0;
        }
    }

}
