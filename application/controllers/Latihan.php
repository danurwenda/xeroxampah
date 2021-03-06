<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Latihan
 *
 * @author Slurp
 */
class Latihan extends Member_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('latihan_model');
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
            $this->db->or_where('UPPER(tempat) LIKE', '%' . strtoupper($term) . '%');
            $this->db->or_where('UPPER(materi) LIKE', '%' . strtoupper($term) . '%');
        }
        $r = $this->db
                ->get('latihan')
                ->result_array();
        $ret = [];
        foreach ($r as $i) {
            //craft return
            $i['id'] = $i['latihan_id'] + 0;
            $ret[] = $i;
        }
        echo json_encode($ret);
    }

    function add() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(11);
        $data['css_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'polkam', 'asset' => 'combodate.js']
            , ['module' => 'polkam', 'asset' => 'moment.js']
            , ['module' => 'polkam', 'asset' => 'select2.min.js']
            , ['module' => 'polkam', 'asset' => 'latihan/config.js']
        ];
        $data['title'] = 'Tambah Latihan';
        $this->template->display('latihan/add_view', $data);
    }

    function index() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(11);
        $data['title'] = 'tr.db | Latihan';
        $data['css_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [ ['module' => 'polkam', 'asset' => 'moment.js']
            , ['module' => 'polkam', 'asset' => 'combodate.js']
            , ['module' => 'polkam', 'asset' => 'select2.min.js']
            , ['module' => 'polkam', 'asset' => 'latihan/config.js']
        ];
        $this->template->display('latihan/table_view', $data);
    }

    function edit($id) {
        //load form and populate
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(11);
        $data['css_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'polkam', 'asset' => 'combodate.js']
            , ['module' => 'polkam', 'asset' => 'select2.min.js']
            , ['module' => 'polkam', 'asset' => 'latihan/config.js']
            , ['module' => 'polkam', 'asset' => 'moment.js']
        ];
        $data['title'] = 'Ubah Latihan';
        $data['edit_id'] = $id;
        $this->template->display('latihan/add_view', $data);
    }

    function merge() {
        $success = true;
        //array of merged id
        $keep = $this->input->post('keep');
        $discard = $this->input->post('discard');
        //fields
        $tempat = $this->input->post('tempat');
        $label = $this->input->post('label');
        $kotakab = $this->input->post('kotakab');
        $sejak = $this->input->post('sejak');
        $hingga = $this->input->post('hingga');
        $materi = $this->input->post('materi');
        $motif = $this->input->post('motif');
        $q = [];
        if ($keep) {
            //edit
            if ($this->latihan_model->update($keep, $label, $tempat, $kotakab, $sejak, $hingga, $materi, $motif)) {
                //update to neo4j
                $q[] = $this->latihan_model->neo4j_update_query($keep, $label, $tempat, $materi);
            } else {
                $success = false;
            }
        }
        //sejauh ini baru ada referensi incoming edge dari Individu
        $this->load->model('edge_model');
        $refs = $this->db
                ->join('edge_weight', 'edge_weight.weight_id=edge.weight_id')
                ->get_where('edge', ['target_id' => $discard, 'type' => 11])
                ->result();
        foreach ($refs as $ref) {
            //ubah target_id ke $keep
            if ($this->edge_model->update($ref->edge_id, $ref->source_id, $keep, $ref->properties)) {
                //update neo to reflect these changes
                $q[] = $this->edge_model->neo4j_update_query($ref->edge_id);
            } else {
                $success = false;
            }
        }
        if ($this->latihan_model->delete($discard)) {
            $q[] = $this->latihan_model->neo4j_delete_query($discard);
        } else {
            $success = false;
        }
        if ($success) {
            postNeoQuery($q);
        }
        echo json_encode(['success' => $success]);
    }

    /**
     * Server-side processing for datatables
     */
    function dt() {
        if ($this->input->is_ajax_request()) {
            //ajax only
            $this->datatables
                    ->select('tempat,materi,sejak,hingga,latihan_id')
                    ->add_column('DT_RowId', 'row_$1', 'latihan_id')
                    ->from('latihan');
            echo $this->datatables->generate();
        }
    }

    //REST-like
    function submit() {
        $id = $this->input->post('latihan_id');
        $kotakab = $this->input->post('kotakab');
        $tempat = $this->input->post('tempat');
        $materi = $this->input->post('materi');
        $motif = $this->input->post('motif');
        $label = $this->input->post('label');
        $sejak = $this->input->post('sejak');
        if (empty($sejak)) {
            $sejak = null;
        }
        $hingga = $this->input->post('hingga');
        if (empty($hingga)) {
            $hingga = null;
        }
        if ($id) {
            //edit
            if ($this->latihan_model->update($id, $label, $tempat, $kotakab, $sejak, $hingga, $materi, $motif)) {
                //update to neo4j
                postNeoQuery($this->latihan_model->neo4j_update_query($id, $label, $tempat, $materi));
                if ($this->input->is_ajax_request()) {
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    //back to table
                    redirect('latihan');
                }
            } else {
                echo 0;
            }
        } else {
            //add
            //insert to db
            if ($new_id = $this->latihan_model->create($label, $tempat, $kotakab, $sejak, $hingga, $materi, $motif)) {
                //insert to neo4j
                postNeoQuery($this->latihan_model->neo4j_insert_query($new_id));
                if ($this->input->is_ajax_request()) {
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    //back to table
                    redirect('latihan');
                }
            } else {
                echo 0;
            }
        }
    }

    function get($id) {
        echo json_encode($this->latihan_model->get($id));
    }

    function delete($id) {
        if ($this->latihan_model->delete($id)) {
            postNeoQuery($this->latihan_model->neo4j_delete_query($id));
            echo 1;
        } else {
            echo 0;
        }
    }

}
