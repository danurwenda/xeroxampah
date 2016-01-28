<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * This Admin_template library was created specifically to minimize code redundancy
 * in determining modules that can be accessed by the logged in user
 *
 * @author Administrator
 */
class Adtemplate {

    protected $_ci;
    private $user_role;

    /**
     * User role is passed to the constructor since this class determines 
     * what is displayed/not displayed based on current role.
     * @param type $params an array containing logged_user role
     */
    public function __construct($params) {
        $this->_ci = &get_instance();
        $this->_ci->load->model('module_privilege_model', 'mpm');
        $this->user_role = $params['role_id'];
    }

    function display($template, $data = null) {
        $data['_content'] = $this->_ci->load->view('admin/' . $template, $data, true);
        //get top menus from mpm
        //by default, no menus are displayed
        //only logout menu
        $menus = $this->_ci->mpm->get_displayed_modules($this->user_role);

        $data['topmenus'] = $menus;
        $this->_ci->load->view('admin/template.php', $data);
    }

}
