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
    /* tambah kolom "label" di table entities
     */          
        $this->db->query('ALTER TABLE public.organisasi ADD COLUMN label character varying(255)');
        $this->db->query('ALTER TABLE public.individu ADD COLUMN label character varying(255)');
        $this->db->query('ALTER TABLE public.masjid ADD COLUMN label character varying(255)');
        $this->db->query('ALTER TABLE public.lapas ADD COLUMN label character varying(255)');
        $this->db->query('ALTER TABLE public.school ADD COLUMN label character varying(255)');
        $this->db->query('ALTER TABLE public.pengajian ADD COLUMN label character varying(255)');
        $this->db->query('ALTER TABLE public.latsen ADD COLUMN label character varying(255)');
        $this->db->query('ALTER TABLE public.latihan ADD COLUMN label character varying(255)');
        $this->db->query('ALTER TABLE public.nonteror ADD COLUMN label character varying(255)');
        $this->db->query('ALTER TABLE public.teror ADD COLUMN label character varying(255)');
    }

    public function down() {
        $this->db->query('ALTER TABLE public.organisasi drop column label cascade');
        $this->db->query('ALTER TABLE public.individu drop column label cascade');
        $this->db->query('ALTER TABLE public.masjid drop column label cascade');
        $this->db->query('ALTER TABLE public.lapas drop column label cascade');
        $this->db->query('ALTER TABLE public.school drop column label cascade');
        $this->db->query('ALTER TABLE public.pengajian drop column label cascade');
        $this->db->query('ALTER TABLE public.latsen drop column label cascade');
        $this->db->query('ALTER TABLE public.latihan drop column label cascade');
        $this->db->query('ALTER TABLE public.nonteror drop column label cascade');
        $this->db->query('ALTER TABLE public.teror drop column label cascade');
    }

}
