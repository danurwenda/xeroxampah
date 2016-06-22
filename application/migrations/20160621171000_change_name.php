<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of 20160620165300_change_name
 *
 * @author danur
 */
class Migration_Change_name extends CI_Migration {

    public function up() {
        /* ganti nama kolom pakai db query bukan pakai dbforge soalnya dbforge->modify_column 
         * selalu menghasilkan column not null 
         */
        $this->db->query('DROP TABLE IF EXISTS arrest CASCADE');
        $this->db->query('DROP TABLE IF EXISTS dakwaan CASCADE');
        $this->db->query('DROP TABLE IF EXISTS detaining CASCADE');
        $this->db->query('DROP TABLE IF EXISTS net CASCADE');
        $this->db->query('DROP TABLE IF EXISTS parents CASCADE');
        $this->db->query('DROP TABLE IF EXISTS source CASCADE');
        $this->db->query('DROP TABLE IF EXISTS tuntutan CASCADE');
        $this->db->query('DROP TABLE IF EXISTS vonis CASCADE');
    }

    public function down() {
        
    }

}
