<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* to Change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Analysis extends Module_Controller {

    function __construct() {
        parent::__construct(2);
        $this->load->model('users_model');
        $this->load->model('indikator_model');
        $this->load->model('threshold_model');
        $this->load->model('data_model');
    }

    /**
     * Dashboard home
     */
    function index() {
        $data['title'] = 'Live';
        $data['breadcrumb'] = $this->indikator_model->create_breadcrumb_li('Analysis');
        $this->template->display('danareksa_view',$data);
    }

}
