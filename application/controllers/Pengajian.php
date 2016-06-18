<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pengajian
 *
 * @author Slurp
 */
class Pengajian extends Member_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('pengajian_model');
        $this->load->model('menu_model');
        $this->load->library('Datatables');
    }

    /**
     * serves autocomplete 
     */
    function search() {
        //explode term by space
        $terms = explode(' ', $this->input->get('term', true));
        foreach ($terms as $term) {
            $this->db->or_where('UPPER(topik) LIKE', '%' . strtoupper($term) . '%');
            $this->db->or_where('UPPER(masjid.name) LIKE', '%' . strtoupper($term) . '%');
            $this->db->or_where('UPPER(school.name) LIKE', '%' . strtoupper($term) . '%');
        }
        $r = $this->db
                ->select("topik,masjid.name mname, school.name sname,pengajian_id")
                ->join('masjid', 'masjid.masjid_id=pengajian.masjid', 'left')
                ->join('school', 'school.school_id=pengajian.pesantren', 'left')
                ->get('pengajian')
                ->result_array();
        $ret = [];
        foreach ($r as $i) {
            //craft return
            $i['id'] = $i['pengajian_id'] + 0;
            $lokasi = '';
            if ($i['mname']) {
                $lokasi.=$i['mname'];
            }
            if ($i['sname']) {
                $lokasi.=', ' . $i['sname'];
            }
            $i['lokasi'] = $lokasi;
            $ret[] = $i;
        }
        echo json_encode($ret);
    }

    function add() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(7);
        $data['title'] = 'Tambah Pengajian';
        $data['css_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.js']
        ];
        $this->template->display('pengajian/add_view', $data);
    }

    function index() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(7);
        $data['title'] = 'tr.db | Pengajian';
        $this->template->display('pengajian/table_view', $data);
    }

    function edit($id) {
        //load form and populate
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(7);
        $data['title'] = 'Ubah Pengajian';
        $data['edit_id'] = $id;
        $data['css_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.js']
        ];
        $this->template->display('pengajian/add_view', $data);
    }

    /**
     * Server-side processing for datatables
     */
    function dt() {
        if ($this->input->is_ajax_request()) {
            //ajax only
            $this->datatables
                    ->select('topik,lokasi,school.name sname,masjid.name mname,individu.individu_name iname,pengajian_id')
                    ->add_column('DT_RowId', 'row_$1', 'pengajian_id')
                    ->from('pengajian')
                    ->join('individu', 'individu.individu_id=pengajian.rumah', 'left')
                    ->join('masjid', 'masjid.masjid_id=pengajian.masjid', 'left')
                    ->join('school', 'school.school_id=pengajian.pesantren', 'left');
            echo $this->datatables->generate();
        }
    }

    //REST-like
    function submit() {
        $id = $this->input->post('pengajian_id');
        $nama = $this->input->post('topik');
        $rumah = $this->input->post('rumah');
        $lokasi = $this->input->post('lokasi');
        $masjid = $this->input->post('masjid');
        $masjid_name = $this->input->post('masjid_name');
        $masjid_address = $this->input->post('masjid_address');
        $masjid_kotakab = $this->input->post('masjid_kotakab');
        $pesantren = $this->input->post('pesantren');
        $pesantren_name = $this->input->post('pesantren_name');
        $pesantren_address = $this->input->post('pesantren_address');
        $pesantren_kotakab = $this->input->post('pesantren_kotakab');
        if ($id) {
            //edit
            if ($this->pengajian_model->update($id, $nama, $rumah, $masjid, $pesantren, $lokasi)) {
                //update to neo4j
                $q = $this->pengajian_model->neo4j_update_query($id, $nama, $rumah, $masjid, $pesantren, $lokasi);
                postNeoQuery($q);
                if ($this->input->is_ajax_request()) {
                    echo json_encode([ $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    //back to table
                    redirect('pengajian');
                }
            } else {
                echo 0;
            }
        } else {
            //add
            //kalo masjid nya kosong, tapi ada masjid_name dan kotakab,
            //add mesjid
            if (!isset($masjid) && (isset($masjid_name) && isset($masjid_kotakab) && isset($masjid_address))) {
                $this->load->model('masjid_model');
                $masjid = $this->masjid_model->create($masjid_name, $masjid_address, $masjid_kotakab);
                $q[] = $this->masjid_model->neo4j_insert_query($masjid);
            }
            if (!isset($pesantren) && (isset($pesantren_name) && isset($pesantren_kotakab) && isset($pesantren_address))) {
                $this->load->model('school_model');
                $pesantren = $this->school_model->create($pesantren_name, $pesantren_address, $pesantren_kotakab);
                $q[] = $this->school_model->neo4j_insert_query($pesantren);
            }
            //insert to db
            if ($new_id = $this->pengajian_model->create($nama,$rumah, $masjid, $pesantren,$lokasi)) {
                //insert to neo4j
                $q[] = $this->pengajian_model->neo4j_insert_query($new_id);
                postNeoQuery($q);
                if ($this->input->is_ajax_request()) {
                    echo json_encode(['q' => $q, $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    //back to table
                    redirect('pengajian');
                }
            } else {
                echo 0;
            }
        }
    }

    function get($id) {
        echo json_encode($this->pengajian_model->get($id));
    }

    function delete($id) {
        if ($this->pengajian_model->delete($id)) {
            postNeoQuery($this->pengajian_model->neo4j_delete_query($id));
            echo 1;
        } else {
            echo 0;
        }
    }

}
