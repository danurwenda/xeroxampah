<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importer extends CI_Controller {

    public function index() {
        echo 'hello';
    }

    public function import() {
        $this->individu();
        $this->organisasi();
        $this->lapas();
        $this->masjid();
        $this->school();
        $this->nonteror();
        $this->teror();
        $this->latihan();
        $this->latsen();
        $this->edge();
    }

    /**
     * Jadi kalau kita import db dari dump db, neo4j nya kan ga terbentuk. Panggil fungsi ini buat import semua data di sql ke neo4j.
     */
    public function individu() {
        //pertama-tama bikin semua Individu
        $this->load->model('individu_model');
        $individus = $this->individu_model->get_all();
        foreach ($individus as $individu) {
            set_time_limit(5);
            postNeoQuery($this->individu_model->neo4j_insert_query($individu->individu_id));
        }
        echo 'Individu';
    }

    public function organisasi() {
        //pertama-tama bikin semua Individu
        $this->load->model('organisasi_model');
        $individus = $this->organisasi_model->get_all();
        foreach ($individus as $individu) {
            set_time_limit(5);
            postNeoQuery($this->organisasi_model->neo4j_insert_query($individu->organisasi_id));
        }
        echo 'Organisasi';
    }

    public function school() {
        //pertama-tama bikin semua Individu
        $this->load->model('school_model');
        $individus = $this->school_model->get_all();
        foreach ($individus as $individu) {
            set_time_limit(5);
            postNeoQuery($this->school_model->neo4j_insert_query($individu->school_id));
        }
        echo 'School';
    }

    public function lapas() {
        //pertama-tama bikin semua Individu
        $this->load->model('lapas_model');
        $individus = $this->lapas_model->get_all();
        foreach ($individus as $individu) {
            set_time_limit(5);
            postNeoQuery($this->lapas_model->neo4j_insert_query($individu->lapas_id));
        }
        echo 'Lapas';
    }

    public function masjid() {
        //pertama-tama bikin semua Individu
        $this->load->model('masjid_model');
        $individus = $this->masjid_model->get_all();
        foreach ($individus as $individu) {
            set_time_limit(5);
            postNeoQuery($this->masjid_model->neo4j_insert_query($individu->masjid_id));
        }
        echo 'Masjid';
    }

    public function pengajian() {
        //pertama-tama bikin semua Individu
        $this->load->model('pengajian_model');
        $individus = $this->pengajian_model->get_all();
        foreach ($individus as $individu) {
            set_time_limit(5);
            postNeoQuery($this->pengajian_model->neo4j_insert_query($individu->pengajian_id));
        }
        echo 'Pengajian';
    }

    public function teror() {
        //pertama-tama bikin semua Individu
        $this->load->model('teror_model');
        $individus = $this->teror_model->get_all();
        foreach ($individus as $individu) {
            set_time_limit(5);
            postNeoQuery($this->teror_model->neo4j_insert_query($individu->teror_id));
        }
        echo 'Teror';
    }

    public function nonteror() {
        //pertama-tama bikin semua Individu
        $this->load->model('nonteror_model');
        $individus = $this->nonteror_model->get_all();
        foreach ($individus as $individu) {
            set_time_limit(5);
            postNeoQuery($this->nonteror_model->neo4j_insert_query($individu->nonteror_id));
        }
        echo 'Nonteror';
    }

    public function latsen() {
        //pertama-tama bikin semua Individu
        $this->load->model('latsen_model');
        $individus = $this->latsen_model->get_all();
        foreach ($individus as $individu) {
            set_time_limit(5);
            postNeoQuery($this->latsen_model->neo4j_insert_query($individu->latsen_id));
        }
        echo 'Latsen';
    }

    public function latihan() {
        //pertama-tama bikin semua Individu
        $this->load->model('latihan_model');
        $individus = $this->latihan_model->get_all();
        foreach ($individus as $individu) {
            set_time_limit(5);
            postNeoQuery($this->latihan_model->neo4j_insert_query($individu->latihan_id));
        }
        echo 'Latihan';
    }

    public function edge() {
        //pertama-tama bikin semua Individu
        $this->load->model('edge_model');
        $individus = $this->edge_model->get_all();
        foreach ($individus as $individu) {
            set_time_limit(5);
            postNeoQuery($this->edge_model->neo4j_insert_query($individu->edge_id));
        }
        echo 'Edge';
    }

}
