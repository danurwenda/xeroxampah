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
class Migration_Pesantren_to_school
extends CI_Migration {
    public function up() {
    /* ganti nama kolom pakai db query bukan pakai dbforge soalnya dbforge->modify_column 
     * selalu menghasilkan column not null 
     */
        $this->db->query('ALTER TABLE public.pengajian RENAME pesantren TO school');
    }

    public function down() {
        $this->db->query('ALTER TABLE public.pengajian RENAME school TO pesantren');
    }

}
