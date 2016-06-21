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
        $this->db->query('ALTER TABLE public.masjid RENAME name TO masjid_name');
        $this->db->query('ALTER TABLE public.school RENAME name TO school_name');
        //ganti length bbrp kolom
        $this->db->query('ALTER TABLE public.latihan ALTER COLUMN materi TYPE character varying(755)');
        $this->db->query('ALTER TABLE public.latsen ALTER COLUMN materi TYPE character varying(755)');
        $this->db->query('ALTER TABLE public.nonteror ALTER COLUMN pidana TYPE character varying(755)');
        $this->db->query('ALTER TABLE public.teror ALTER COLUMN serangan TYPE character varying(755)');
    }

    public function down() {
        $this->db->query('ALTER TABLE public.masjid RENAME masjid_name TO name');
        $this->db->query('ALTER TABLE public.school RENAME school_name TO name');
        //ganti length bbrp kolom
        $this->db->query('ALTER TABLE public.latihan ALTER COLUMN materi TYPE character varying(255)');
        $this->db->query('ALTER TABLE public.latsen ALTER COLUMN materi TYPE character varying(255)');
        $this->db->query('ALTER TABLE public.nonteror ALTER COLUMN pidana TYPE character varying(255)');
        $this->db->query('ALTER TABLE public.teror ALTER COLUMN serangan TYPE character varying(255)');
    }

}
