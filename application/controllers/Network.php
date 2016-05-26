<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Organisasi
 *
 * @author Slurp
 */
class Network extends Member_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('individu_model');
        $this->load->model('source_model');
        $this->load->model('menu_model');
    }

    function index() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(5);
        $data['title'] = 'tr.db | Graph Database';

        $this->template->display('network/view', $data);
    }
    
    /**
     * serves autocomplete 
     */
    function search() {
        $r = $this->db
                ->where('UPPER(net_name) LIKE', '%' . strtoupper($this->input->get('term', true)) . '%')
                ->get('net')
                ->result();
        $ret = [];
        foreach ($r as $i) {
            //craft return
            $ret[] = [
                'label' => $i->net_name,
                'value' => $i->net_name,
                'id' => $i->net_id
            ];
        }
        echo json_encode($ret);
    }

    
}
