<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pada intinya controller ini sama saja dengan dashboard, namun lebih khusus karena hanya mengurus indikator2
 * dengan mark isu strategis.
 */
class Dashboard extends Member_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('users_model');
        $this->load->model('menu_model');
        $this->load->model('threshold_model');
        $this->load->model('data_model');
    }

    /**
     * Dashboard home
     */
    function index() {
        $data['title'] = 'Tr.db | Dashboard';
        $data['menus'] = $this->get_home_menus();
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb_li('Home');

        $this->template->display('home_view', $data);
    }

    public function show($menu_id) {
        $children = $this->menu_model->get_children($menu_id);
        $data['title'] = 'tr.db | '.$this->menu_model->get($menu_id)->display_name;
        $data['menus'] = $children;
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb($menu_id, true);
        $this->template->display('home_view', $data);
    }

    /**
     * Root strategic adalah indikator strategic yang tidak punya parent atau 
     * yang parent nya tidak strategic.
     * @return type
     */
    private function get_home_menus() {
        $menus = $this->db
                ->query('select * from menus a where parent_menu is null')
                ->result();
        return $menus;
    }

    private function generate_strategic_chart($indikator_id) {
        $this->load->model('chart_model');
        $chart = $this->chart_model->get_chart($indikator_id, true);
        if (count($chart)>0) {
//            print_r($chart);
            $this->load->library('chart');
            return $this->chart->generate($chart[0], ['render-to' => 'strategicChart']);
        } else {
            return '';
        }
    }

}
