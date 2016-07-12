<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Organisasi
 *
 * @author Slurp
 */
class Organisasi extends Member_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('organisasi_model');
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
            $this->db->or_where('UPPER(name) LIKE', '%' . strtoupper($term) . '%');
            $this->db->or_where('UPPER(daerah) LIKE', '%' . strtoupper($term) . '%');
        }
        $r = $this->db
                ->get('organisasi')
                ->result_array();
        $ret = [];
        foreach ($r as $i) {
            //craft return
            $i['id'] = $i['organisasi_id'] + 0;
            $ret[] = $i;
        }
        echo json_encode($ret);
    }

    function add() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(2);
        $data['title'] = 'Tambah Organisasi';
        $this->template->display('organisasi/add_view', $data);
    }

    function index() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(2);
        $data['title'] = 'tr.db | Organisasi';
        $this->template->display('organisasi/table_view', $data);
    }

    function edit($id) {
        //load form and populate
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(2);
        $data['title'] = 'Ubah Organisasi';
        $data['edit_id'] = $id;
        $this->template->display('organisasi/add_view', $data);
    }

    function merge() {
        $success = true;
        //array of merged id
        $keep = $this->input->post('keep');
        $discard = $this->input->post('discard');
        //fields
        $nama = $this->input->post('name');
        $label = $this->input->post('label');
        $daerah = $this->input->post('daerah');
        $q = [];
        if ($keep) {
            //edit
            if ($this->organisasi_model->update($keep, $label, $nama, $daerah)) {
                //update to neo4j
                $q[] = $this->organisasi_model->neo4j_update_query($keep, $label, $nama, $daerah);
            } else {
                $success = false;
            }
        }
        //sejauh ini baru ada referensi incoming edge dari Individu
        $this->load->model('edge_model');
        $refs = $this->db
                ->join('edge_weight', 'edge_weight.weight_id=edge.weight_id')
                ->get_where('edge', ['target_id' => $discard,'type'=>2])
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
        if ($this->organisasi_model->delete($discard)) {
            $q[] = $this->organisasi_model->neo4j_delete_query($discard);
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
                    ->select('name,daerah,organisasi_id')
                    ->add_column('DT_RowId', 'row_$1', 'organisasi_id')
                    ->from('organisasi');
            echo $this->datatables->generate();
        }
    }

    //REST-like
    function submit() {
        $id = $this->input->post('organisasi_id');
        $nama = $this->input->post('name');
        $label = $this->input->post('label');
        $daerah = $this->input->post('daerah');
        $city = $this->input->post('city');
        if ($id) {
            //edit
            if ($this->organisasi_model->update($id, $label, $nama, $daerah)) {
                //update to neo4j
                postNeoQuery($this->organisasi_model->neo4j_update_query($id, $label, $nama, $daerah));
                if ($this->input->is_ajax_request()) {
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    //back to table
                    redirect('organisasi');
                }
            } else {
                echo 0;
            }
        } else {
            //add
            //insert to db
            if ($new_id = $this->organisasi_model->create($label, $nama, $daerah)) {
                //insert to neo4j
                postNeoQuery($this->organisasi_model->neo4j_insert_query($new_id));
                if ($this->input->is_ajax_request()) {
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    //back to table
                    redirect('organisasi');
                }
            } else {
                echo 0;
            }
        }
    }

    function get($id) {
        echo json_encode($this->organisasi_model->get($id));
    }

    function delete($id) {
        if ($this->organisasi_model->delete($id)) {
            postNeoQuery($this->organisasi_model->neo4j_delete_query($id));
            echo 1;
        } else {
            echo 0;
        }
    }

}
