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
        $this->dbforge->drop_table('arrest');
        $this->dbforge->drop_table('dakwaan');
        $this->dbforge->drop_table('detaining');
        $this->dbforge->drop_table('net');
        $this->dbforge->drop_table('parents');
        $this->dbforge->drop_column('individu', 'individu_source');
        $this->dbforge->drop_table('source');
        $this->dbforge->drop_table('tuntutan');
        $this->dbforge->drop_table('vonis');
    }

    public function down() {
    }

}
