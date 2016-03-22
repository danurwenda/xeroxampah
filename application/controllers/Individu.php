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
            ['module' => 'ace', 'asset' => 'chosen.css'],
            ['module' => 'polkam', 'asset' => 'select2.min.css']
        ];
        $data['js_assets'] = [
            ['module' => 'ace', 'asset' => 'chosen.jquery.js'],
            ['module' => 'polkam', 'asset' => 'select2.min.js']
        ];
        $data['sources'] = $this->source_model->get_all();
        $this->template->display('individu/add_view_dynamic', $data);
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
                    $job['until'] = date_format(date_create_from_format('d/m/Y', $end), 'Y-m-d');
                }
                $start = $job_starts[$i];
                if (!empty($start)) {
                    //convert to SQL-compliant format
                    $job['from'] = date_format(date_create_from_format('d/m/Y', $start), 'Y-m-d');
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
        $this->db->trans_start();
        $this->db->insert('individu', $data);
        $new_id = $this->db->insert_id('individu_individu_id_seq');

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
            $this->edge_model->insert($father_id, $new_id, 46, null);
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
            $this->edge_model->insert($mother_id, $new_id, 47, null);
        }

        $saudaras = $this->input->post('relation_48');
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
                $this->edge_model->insert($new_id, $saudara_id, 48, null);
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
                $this->edge_model->insert($new_id, $pasangan_id, 49, $mar);
            }
        }
        $anaks = $this->input->post('relation_50');
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
                $this->edge_model->insert($new_id, $anak_id, 50, null);
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

                //insert atau lookup
                $org_id = $this->organization_model->insert_or_lookup($org_id);
                if ($org_id != null) {
                    //insert ke table relasi (edge)
                    $attr = [];
                    $end = $org_ends[$i];
                    if (!empty($end)) {
                        //convert to SQL-compliant format
                        $attr['until'] = date_format(date_create_from_format('d/m/Y', $end), 'Y-m-d');
                    }
                    $start = $org_starts[$i];
                    if (!empty($start)) {
                        //convert to SQL-compliant format
                        $attr['from'] = date_format(date_create_from_format('d/m/Y', $start), 'Y-m-d');
                    }
                    $this->edge_model->insert($new_id, $org_id, $org_edge, json_encode($attr));
                }
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
        $this->db->trans_complete();
        /*
          //parental relationship
          $father_id = null;
          $father = $this->input->post('father');
          if (is_numeric($father)) {
          //check db
          $father = $this->db->get_where('individu', ['individu_id' => $father]);
          if ($father->num_rows() > 0) {
          //ada
          $father_id = $father->row()->individu_id;
          }
          } else if (!empty($father)) {
          //raw name, insert into individu
          $this->db->insert('individu', ['individu_name' => $father]);
          $father_id = $this->db->insert_id('individu_individu_id_seq');
          }
          $mother_id = null;
          $mother = $this->input->post('mother');
          if (is_numeric($mother)) {
          //check db
          $mother = $this->db->get_where('individu', ['individu_id' => $mother]);
          if ($mother->num_rows() > 0) {
          //ada
          $mother_id = $mother->row()->individu_id;
          }
          } else if (!empty($mother)) {
          //raw name, insert into individu
          $this->db->insert('individu', ['individu_name' => $mother]);
          $mother_id = $this->db->insert_id('individu_individu_id_seq');
          }
          if (!($mother_id == null && $father_id == null)) {
          //check marriage
          $marriage = $this->db->where(['father_id' => $father_id, 'mother_id' => $mother_id])
          ->or_where(['father_id' => $mother_id, 'mother_id' => $father_id])
          ->get('marriage');
          if ($marriage->num_rows() == 0) {
          //insert new marriage
          $this->db->insert('marriage', ['father_id' => $father_id, 'mother_id' => $mother_id]);
          $marriage_id = $this->db->insert_id('parenthood_marriage_id_seq');
          } else {
          $marriage_id = $marriage->row()->marriage_id;
          }
          //ambil marriage id, pasang anaknya
          $this->db->insert('parents', ['marriage_id' => $marriage_id, 'child_id' => $new_id]);
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
          } else if (!empty($saudara)) {
          //raw name, insert into individu
          $this->db->insert('individu', ['individu_name' => $saudara]);
          $saudara_id = $this->db->insert_id('individu_individu_id_seq');
          }
          if (!empty($saudara_id)) {
          //check parental
          if ($this->db->get_where('parents', ['marriage_id' => $marriage_id, 'child_id' => $saudara_id])->num_rows() == 0) {
          $this->db->insert('parents', ['marriage_id' => $marriage_id, 'child_id' => $saudara_id]);
          }
          }
          }
          }

          // ISTRI & ANAK
          $wife_id = null;
          $wife = $this->input->post('wife');
          if (is_numeric($wife)) {
          //check db
          $wife = $this->db->get_where('individu', ['individu_id' => $wife]);
          if ($wife->num_rows() > 0) {
          //ada
          $wife_id = $wife->row()->individu_id;
          }
          } else if (!empty($wife)) {
          //raw name, insert into individu
          $this->db->insert('individu', ['individu_name' => $wife]);
          $wife_id = $this->db->insert_id('individu_individu_id_seq');
          }

          //cek anak2 dulu
          $children = [];
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
          } else if (!empty($anak)) {
          //raw name, insert into individu
          $this->db->insert('individu', ['individu_name' => $anak]);
          $anak_id = $this->db->insert_id('individu_individu_id_seq');
          }
          if (!empty($anak_id)) {
          $children[] = $anak_id;
          }
          }
          //insert new marriage
          //hanya dibuat jika ada keterangan tentang anak
          //atau ada istri
          if (!empty($children) || !empty($wife_id)) {
          $this->db->insert('marriage', ['father_id' => $new_id, 'mother_id' => $wife_id]);
          $marriage_id = $this->db->insert_id('parenthood_marriage_id_seq');
          //ambil marriage id, pasang anak(2)nya
          foreach ($children as $c) {
          $this->db->insert('parents', ['marriage_id' => $marriage_id, 'child_id' => $c]);
          }
          }
          //MASJID & PESANTREN
          foreach ($masjids as $masjid) {
          if (is_numeric($masjid)) {
          //check db
          $masjid = $this->db->get_where('masjid', ['masjid_id' => $masjid]);
          if ($masjid->num_rows() > 0) {
          //ada
          $masjid_id = $masjid->row()->masjid_id;
          } else {
          $masjid_id = null;
          }
          } else if (!empty($masjid)) {
          //raw name, insert into masjid
          $this->db->insert('masjid', ['name' => $masjid]);
          $masjid_id = $this->db->insert_id('masjid_masjid_id_seq');
          }
          if (!empty($masjid_id)) {
          $this->db->insert('individu_masjid', ['individu_id' => $new_id, 'masjid_id' => $masjid_id]);
          }
          }
          foreach ($pesantrens as $pesantren) {
          if (is_numeric($pesantren)) {
          //check db
          $pesantren = $this->db->get_where('school', ['school_id' => $pesantren]);
          if ($pesantren->num_rows() > 0) {
          //ada
          $pesantren_id = $pesantren->row()->school_id;
          } else {
          $pesantren_id = null;
          }
          } else if (!empty($pesantren)) {
          //raw name, insert into pesantren
          $this->db->insert('school', ['name' => $pesantren]);
          $pesantren_id = $this->db->insert_id('school_school_id_seq');
          }
          if (!empty($pesantren_id)) {
          $this->db->insert('individu_pesantren', ['individu_id' => $new_id, 'pesantren_id' => $pesantren_id]);
          }
          } */
        //back to table
        redirect('individu');
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

    //REST-like
    function post() {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('individu_id');
            $nama = $this->input->post('name');
            $alias = $this->input->post('alias');
            $affiliation = $this->input->post('affiliation');
            $nationality = $this->input->post('nationality');
            $family_conn = $this->input->post('family_conn');
            $d = $this->input->post('born_date');
            $born_date = empty($d) ? null : date_format(date_create_from_format('d/m/Y', $d), 'Y-m-d');
            $born_place = $this->input->post('born_place');
            $detention_history = $this->input->post('detention_history');
            $detention_status = $this->input->post('detention_status');
            $education = $this->input->post('education');
            $source_id = $this->input->post('source_id');
            if ($id) {
//                //edit
                if ($this->individu_model->update(
                                $id, $nama, $alias, $born_date, $born_place, $nationality, $detention_history, $detention_status, $education, $affiliation, $family_conn, $source_id)) {
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    echo 0;
                }
            } else {
//                //add
                if ($this->individu_model->create(
                                $nama, $alias, $born_date, $born_place, $nationality, $detention_history, $detention_status, $education, $affiliation, $family_conn, $source_id)) {
                    echo json_encode([$this->security->get_csrf_token_name() => $this->security->get_csrf_hash()]);
                } else {
                    echo 0;
                }
            }
        }
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
