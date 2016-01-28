<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* to Change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin extends Admin_Controller {

    function __construct() {
        parent::__construct(0);
        $this->load->model('users_model');
        $this->load->model('indikator_model');
        $this->load->model('threshold_model');
        $this->load->model('data_model');
    }

    /**
     * Returns array of chart from specified parent indicator
     * @param type $parent
     */
    function get_chart($parent) {
        $this->load->model('chart_model');
        $charts = $this->chart_model->get_chart($parent);
        echo json_encode($charts);
    }

    /**
     * Returns array of indicators which has value(s) and are descendant of 
     * given indicator.
     * @param type $indikator
     */
    function get_children_indicators($valued, $indikator) {
        $indikator_obj = is_object($indikator) ? $indikator : $this->indikator_model->get($indikator);
        $latest_data = $this->data_model->get_latest($indikator_obj->indikator_id);
        //hanya add yang pernah punya data
        if ($valued && isset($latest_data)) {
            $indikator_obj->last_value = $latest_data->val;
            $indikator_obj->last_update = $latest_data->date;
            $ret = [$indikator_obj];
        } else if (!$valued && !isset($latest_data)) {
            $ret = [$indikator_obj];
        } else {
            $ret = [];
        }
        //cek ini punya anak apa engga
        foreach ($this->indikator_model->get_children($indikator_obj->indikator_id) as $anak) {
            $ret = array_merge($ret, $this->get_children_indicators($valued, $anak));
        }
        return $ret;
    }

    function get_json_children($has_value, $root) {
        echo json_encode($this->get_children_indicators($has_value, $root));
    }

    /**
     * Dashboard home
     */
    function index() {
        $data['title'] = 'Admin';
        $data['breadcrumb'] = $this->indikator_model->create_breadcrumb_li('Admin');
        //data yang harus dikirim terkait live data
        $this->adtemplate->display('mt', $data);
    }

    function grafik() {
        $data['title'] = 'Admin';
        $data['breadcrumb'] = $this->indikator_model->create_breadcrumb_li('Admin');
        $l1indikator = $this->db->where_in('indikator_id', [44, 53])->get('indikator')->result();
        foreach ($l1indikator as $l1) {
            //tambah anak2nya
            $l1->children = $this->indikator_model->get_children($l1->indikator_id);
        }
        $data['indikators'] = $l1indikator;
        $this->load->helper('form');
        //data yang harus dikirim terkait live data
        $this->adtemplate->display('grafik', $data);
    }

}
