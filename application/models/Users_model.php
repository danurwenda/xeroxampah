<?php

defined('BASEPATH') OR
        exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users_model
 *
 * @author Administrator
 */
class Users_model extends CI_Model {

    public $table = 'users';
    public $primary_key = 'user_id';

    public function __construct() {
        parent::__construct();
    }

    public function get_login_info($u) {
        $this->db->where('username', $u)->limit(1);
        $q = $this->db->get($this->table);
        return ($q->num_rows() > 0) ? $q->row() : false;
    }

    public function get_user($id) {
        $this->db->where($this->primary_key, $id)->limit(1);
        $q = $this->db->get($this->table);
        return ($q->num_rows() > 0) ? $q->row() : false;
    }

    public function auth($plain_u, $plain_p) {
        $sql = "SELECT password FROM users WHERE username = ? limit 1";
        $query = $this->db->query($sql, array($plain_u));
        if ($query->num_rows() > 0) {
            $hashdb = $query->row()->password;
            $hashinput = crypt($plain_p, $hashdb);
            return hash_equals($hashdb, $hashinput);
        }
        return false;
    }

}
