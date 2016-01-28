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
class Individu extends Member_Controller {

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
        $data['css_assets'] = array(
            ['module' => 'ace', 'asset' => 'chosen.css'],
            ['module' => 'ace', 'asset' => 'datepicker.css'],
        );
        $data['sources'] = $this->source_model->get_all();
        $this->template->display('individu/table_view', $data);
    }

    /**
     * Server-side processing for datatables
     */
    function dt() {
        $this->datatables
                ->select('name,affiliation,born_date,born_place,detention_status,individu_id')
                ->add_column('DT_RowId', 'row_$1', 'individu_id')
                ->from('individu');
        echo $this->datatables->generate();
    }

    //REST-like
    function post() {
        $id = $this->input->post('individu_id');
        $nama = $this->input->post('name');
        $alias = $this->input->post('alias');
        $born_date = $this->input->post('born_date');
        $born_place = $this->input->post('born_place');
        $nationality = $this->input->post('nationality');
        $detention_history = $this->input->post('detention_history');
        $detention_status = $this->input->post('detention_status');
        $education = $this->input->post('education');
        $affiliation = $this->input->post('affiliation');
        $source_id = $this->input->post('source_id');
        if ($id) {
            //edit
            if ($this->individu_model->update(
                            $id, $nama, $alias, $born_date, $born_place, $nationality, $detention_history, $detention_status, $education, $affiliation, $source_id)) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            //add
            if ($this->individu_model->create(
                            $nama, $alias, $born_date, $born_place, $nationality, $detention_history, $detention_status, $education, $affiliation, $source_id)) {
                echo 1;
            } else {
                echo 0;
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
