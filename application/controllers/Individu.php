<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Organization
 *
 * @author Slurp
 */
class Individu extends Member_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('individu_model');
        $this->load->model('source_model');
        $this->load->model('menu_model');
        $this->load->library('Datatables');
    }

    function index() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(3);
        $data['title'] = 'tr.db | Individu';

        $this->template->display('individu/table_view', $data);
    }

    function add() {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(3);
        $data['title'] = 'Tambah Individu';
        $data['css_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.js']
        ];
        $data['sources'] = $this->source_model->get_all();
        $this->template->display('individu/add_view_dynamic', $data);
    }

    function tes() {
        $q = "merge(Individu_2:Individu{individu_id:2,individu_name:'Yusuf'})";
        postNeoQuery($q);
        echo 'dor';
    }

    function submit() {
        //list all column on db
        //simple
        $individu_name = $this->input->post('individu_name');
        $alias = $this->input->post('alias');
        $born_date = $this->input->post('born_date');
        //SQL doesn't accept empty string as a valid date
        if (empty($born_date)) {
            $born_date = null;
        } else {
            //convert to SQL-compliant format
            $born_date = date_format(date_create_from_format('d/m/Y', $born_date), 'Y-m-d');
        }
        $born_place = $this->input->post('born_place');
        $nationality = $this->input->post('nationality');
        $source_id = $this->input->post('source_id');
        $address = $this->input->post('address');
        $religion = $this->input->post('religion');
        $recent_job = $this->input->post('recent_job');
        $recent_edu = $this->input->post('recent_edu');
        $lokasi_penangkapan_terakhir = $this->input->post('lokasi_tangkap');
        $waktu_penangkapan_terakhir = $this->input->post('tangkap_date');
        if (empty($waktu_penangkapan_terakhir)) {
            $waktu_penangkapan_terakhir = null;
        } else {
            //convert to SQL-compliant format
            $waktu_penangkapan_terakhir = date_format(date_create_from_format('d/m/Y', $waktu_penangkapan_terakhir), 'Y-m-d');
        }
        //field field ga jelas simpan sebagai json
        $properties = [];
        //jobs ini simpan sebagai json aja
        $job_history = [];
        $jobs = $this->input->post('job_place');
        $job_starts = $this->input->post('job_start');
        $job_ends = $this->input->post('job_end');
        for ($i = 0; $i < count($jobs); $i++) {
            //masukin hanya jika jobs tidak kosong
            if (!empty($jobs[$i])) {
                $job['job'] = $jobs[$i];

                $end = $job_ends[$i];
                if (!empty($end)) {
                    //convert to SQL-compliant format
                    $job['until'] = date_format(date_create_from_format('d-m-Y', '01-' . $end), 'Y-m-d');
                }
                $start = $job_starts[$i];
                if (!empty($start)) {
                    //convert to SQL-compliant format
                    $job['from'] = date_format(date_create_from_format('d-m-Y', '01-' . $start), 'Y-m-d');
                }
                //add to array
                $job_history[] = $job;
            }
        }
        //only add to properties if the array is not empty
        if (!empty($job_history)) {
            $properties['jobs'] = $job_history;
        }

        //process properties as json only if it's not empty
        if (!empty($properties)) {
            $properties = json_encode($properties);
        } else {
            $properties = null;
        }
        //insert into DB
        //TODO : move to model
        $fields = [
            'individu_name',
            'alias',
            'born_date',
            'born_place',
            'nationality',
            'source_id',
            'address',
            'religion',
            'recent_job',
            'recent_edu',
            'lokasi_penangkapan_terakhir',
            'waktu_penangkapan_terakhir',
            'properties'
        ];
        $data = [];
        foreach ($fields as $field) {
            $data[$field] = $$field;
        }

        //START TRANSACTION
        //preparing Neo4J Query
        $n4jq = [];
        $this->db->trans_start();

        $new_id = $this->individu_model->insert($data);
        $n4jq[] = $this->individu_model->neo4j_insert_query($new_id);

        // ADD EDGES
        $this->load->model('edge_model');
        // HUBUNGAN KEKELUARGAAN
        $father = $this->input->post('father');
        if (is_numeric($father)) {
            //check db
            $father = $this->db->get_where('individu', ['individu_id' => $father]);
            if ($father->num_rows() > 0) {
                //ada
                $father_id = $father->row()->individu_id;
            } else {
                $father_id = null;
            }
        }
        if (!empty($father_id)) {
            $eid = $this->edge_model->insert($father_id, $new_id, 46, null);
            $n4jq[] = $this->edge_model->neo4j_insert_query($eid);
        }
        $mother = $this->input->post('mother');
        if (is_numeric($mother)) {
            //check db
            $mother = $this->db->get_where('individu', ['individu_id' => $mother]);
            if ($mother->num_rows() > 0) {
                //ada
                $mother_id = $mother->row()->individu_id;
            } else {
                $mother_id = null;
            }
        }
        if (!empty($mother_id)) {
            $eid = $this->edge_model->insert($mother_id, $new_id, 47, null);
            $n4jq[] = $this->edge_model->neo4j_insert_query($eid);
        }

        $saudaras = $this->input->post('relation_48');
        if (!empty($saudaras)) {
            foreach ($saudaras as $saudara) {
                if (is_numeric($saudara)) {
                    //check db
                    $saudara = $this->db->get_where('individu', ['individu_id' => $saudara]);
                    if ($saudara->num_rows() > 0) {
                        //ada
                        $saudara_id = $saudara->row()->individu_id;
                    } else {
                        $saudara_id = null;
                    }
                }
                if (!empty($saudara_id)) {
                    $eid = $this->edge_model->insert($new_id, $saudara_id, 48, null);
                    $n4jq[] = $this->edge_model->neo4j_insert_query($eid);
                }
            }
        }
        $pasangans = $this->input->post('relation_49');
        $kawins = $this->input->post('married_date');
        for ($i = 0; $i < count($pasangans); $i++) {
            $pasangan = $pasangans[$i];
            if (is_numeric($pasangan)) {
                //check db
                $pasangan = $this->db->get_where('individu', ['individu_id' => $pasangan]);
                if ($pasangan->num_rows() > 0) {
                    //ada
                    $pasangan_id = $pasangan->row()->individu_id;
                } else {
                    $pasangan_id = null;
                }
            }
            if (!empty($pasangan_id)) {
                $mar = null;
                //barangkali ada tanggal 
                $marriage_date = $kawins[$i];
                if (!empty($marriage_date)) {
                    //convert to SQL-compliant format
                    $mar['from'] = date_format(date_create_from_format('d/m/Y', $marriage_date), 'Y-m-d');
                    $mar = json_encode($mar);
                }
                $eid = $this->edge_model->insert($new_id, $pasangan_id, 49, $mar);
                $n4jq[] = $this->edge_model->neo4j_insert_query($eid);
            }
        }
        $anaks = $this->input->post('relation_50');
        if (!empty($anaks)) {
            foreach ($anaks as $anak) {
                if (is_numeric($anak)) {
                    //check db
                    $anak = $this->db->get_where('individu', ['individu_id' => $anak]);
                    if ($anak->num_rows() > 0) {
                        //ada
                        $anak_id = $anak->row()->individu_id;
                    } else {
                        $anak_id = null;
                    }
                }
                if (!empty($anak_id)) {
                    $eid = $this->edge_model->insert($new_id, $anak_id, 50, null);
                    $n4jq[] = $this->edge_model->neo4j_insert_query($eid);
                }
            }
        }
        // SEKOLAH
        $sch_edges = $this->input->post('edu_edge');
        $sch_ids = $this->input->post('school_id');
        $sch_starts = $this->input->post('edu_start');
        $sch_ends = $this->input->post('edu_end');
        $this->load->model('sekolah_model');
        for ($i = 0; $i < count($sch_edges); $i++) {
            $sch_edge = $sch_edges[$i];
            $sch_id = $sch_ids[$i];
            if (!empty($sch_id)) {
                //insert ke table relasi (edge)
                $attr = [];
                $end = $sch_ends[$i];
                if (!empty($end)) {
                    //convert to SQL-compliant format
                    $attr['until'] = date_format(date_create_from_format('d-m-Y', '01-' . $end), 'Y-m-d');
                }
                $start = $sch_starts[$i];
                if (!empty($start)) {
                    //convert to SQL-compliant format
                    $attr['from'] = date_format(date_create_from_format('d-m-Y', '01-' . $start), 'Y-m-d');
                }
                $eid = $this->edge_model->insert($new_id, $sch_id, $sch_edge, json_encode($attr));
                $n4jq[] = $this->edge_model->neo4j_insert_query($eid);
            }
        }
        // LAPAS
        $lapas_edge = 56;
        $lapas_ids = $this->input->post('lapas_id');
        $lapas_starts = $this->input->post('lapas_start');
        $lapas_ends = $this->input->post('lapas_end');
        for ($i = 0; $i < count($lapas_ids); $i++) {
            $lapas_id = $lapas_ids[$i];
            if (!empty($lapas_id)) {

                //insert ke table relasi (edge)
                $attr = [];
                $end = $lapas_ends[$i];
                if (!empty($end)) {
                    //convert to SQL-compliant format
                    $attr['until'] = date_format(date_create_from_format('d-m-Y', '01-' . $end), 'Y-m-d');
                }
                $start = $lapas_starts[$i];
                if (!empty($start)) {
                    //convert to SQL-compliant format
                    $attr['from'] = date_format(date_create_from_format('d-m-Y', '01-' . $start), 'Y-m-d');
                }
                $eid = $this->edge_model->insert($new_id, $lapas_id, $lapas_edge, json_encode($attr));
                $n4jq[] = $this->edge_model->neo4j_insert_query($eid);
            }
        }
        // ORGANISASI
        $org_edges = $this->input->post('org_edge');
        $org_ids = $this->input->post('org_id');
        $org_starts = $this->input->post('org_start');
        $org_ends = $this->input->post('org_end');
        $this->load->model('organization_model');
        for ($i = 0; $i < count($org_edges); $i++) {
            $org_edge = $org_edges[$i];
            $org_id = $org_ids[$i];
            if (!empty($org_id)) {

                //insert ke table relasi (edge)
                $attr = [];
                $end = $org_ends[$i];
                if (!empty($end)) {
                    //convert to SQL-compliant format
                    $attr['until'] = date_format(date_create_from_format('d-m-Y', '01-' . $end), 'Y-m-d');
                }
                $start = $org_starts[$i];
                if (!empty($start)) {
                    //convert to SQL-compliant format
                    $attr['from'] = date_format(date_create_from_format('d-m-Y', '01-' . $start), 'Y-m-d');
                }
                $eid = $this->edge_model->insert($new_id, $org_id, $org_edge, json_encode($attr));
                $n4jq[] = $this->edge_model->neo4j_insert_query($eid);
            }
        }
        //NON TEROR
        $nteror_edges = $this->input->post('nonteror_edge');
        $nterors = $this->input->post('nonteror'); //may be null
        for ($i = 0; $i < count($nteror_edges); $i++) {
            if (!empty($nterors[$i])) {
                //insert ke table relasi
                $this->edge_model->insert($new_id, $nterors[$i], $nteror_edges[$i], null);
            }
        }
        // TEROR
        $teror_edges = $this->input->post('teror_edge');
        $terors = $this->input->post('teror'); //may be null
        for ($i = 0; $i < count($teror_edges); $i++) {
            if (!empty($terors[$i])) {
                //insert ke table relasi
                $eid = $this->edge_model->insert($new_id, $terors[$i], $teror_edges[$i], null);
                $n4jq[] = $this->edge_model->neo4j_insert_query($eid);
            }
        }
        // RIWAYAT PENGGUNAAN NAMA
        $old_names = $this->input->post('old_name');
        $old_names = $this->input->post('lokasi_nama');
        $old_names = $this->input->post('nama_date');
        $this->db->trans_complete();

        // SQL DATABASE DONE
        //================POST TO NEO4J=============================
        //dengan harapan fungsi ini synchronous
        //karena memang harus dieksekusi sesuai urutan
        //query pertama harus dieksekusi pertama, karena itu bikin node
        //query yang lain mau async juga gpp

        if ($this->input->is_ajax_request()) {
            echo json_encode(
                    [
                        $this->security->get_csrf_token_name() => $this->security->get_csrf_hash()
            ]);
            foreach ($n4jq as $q) {
                postNeoQuery($q);
            }
        } else {
            foreach ($n4jq as $q) {
                echo $q;
                echo "<br/>";
                postNeoQuery($q);
            }
            //back to table
            redirect('individu');
        }
    }

    /**
     * Server-side processing for datatables
     */
    function dt() {
        if ($this->input->is_ajax_request()) {
            $this->datatables
                    ->select('individu_name,born_date,born_place,alias,individu_id')
                    ->add_column('DT_RowId', 'row_$1', 'individu_id')
                    ->from('individu');
            echo $this->datatables->generate();
        }
    }

    /**
     * serves autocomplete 
     */
    function search() {
        $r = $this->db
                ->where('UPPER(individu_name) LIKE', '%' . strtoupper($this->input->get('term', true)) . '%')
                ->get('individu')
                ->result_array();
        $ret = [];
        foreach ($r as $i) {
            //craft return
            $i['label'] = $i['individu_name'];
            $i['value'] = $i['individu_name'];
            $i['id'] = 0 + $i['individu_id'];
            $ret[] = $i;
        }
        echo json_encode($ret);
    }

    function edit($id) {
        $data['breadcrumb'] = $this->menu_model->create_breadcrumb(3);
        $data['title'] = 'Tambah Individu';
        $data['css_assets'] = [
            ['module' => 'ace', 'asset' => 'datepicker.css'],
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'polkam', 'asset' => 'select2.min.js']
        ];
        $data['sources'] = $this->source_model->get_all();
        $data['edit_id'] = $id;
        $this->template->display('individu/add_view_dynamic', $data);
    }

    function get($id) {
        echo json_encode($this->individu_model->get($id));
    }

    function get_cascade($id) {
        echo json_encode($this->individu_model->get_cascade($id));
    }

    function delete($id) {
        if ($this->individu_model->delete($id)) {
            echo 1;
        } else {
            echo 0;
        }
    }

}
