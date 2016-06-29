<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importer extends CI_Controller {

    function get_string() {
        $json = $this->statements(["MATCH (:Individu{individu_id:335})-[k*1..2]-()WITH LAST(k) AS lk RETURN labels(startnode(lk)) as t1, startnode(lk) as a, type(lk) as b, lk, labels(endnode(lk)) as t2, endnode(lk) as c"]);
        $json = $this->setup_json($json);
    }

    /**
     * Mengubah struktur json dari bentuk standar kembalian dari Neo4J menjadi bentuk yang siap diolah visualisasi (i.e d3.js)
     * @param type $json
     */
    function setup_json($json) {
        $obj = json_decode($json);
        if ($obj->errors) {
            print_r($obj->errors);
        } else {
            $nodes = [];
            $relations = [];
            $res = $obj->results;
            $res = $res[0];
            foreach ($res->data as $rel) {
                $row = $rel->row;
                //node 1
                $node1 = new stdClass();
                $node1->type = $row[0][0];
                $id_attr = strtolower( $node1->type).'_id';
                $node1_id= $row[1];
                $node1->id = $node1_id->$id_attr;
                $node1->
                //node 2
                $node2 = new stdClass();
                $node2->type = $row[4][0];
                $id_attr = strtolower( $node2->type).'_id';
                $node2_id= $row[5];
                $node2->id = $node2_id->$id_attr;
                
                
            }
        }
    }

    function statements($arr) {
        $ss = [];
        foreach ($arr as $string) {
            $ss[] = ['statement' => $string];
        }
        $statements = [ 'statements' => $ss];
        $data_string = json_encode($statements);
        $ci = & get_instance();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ci->config->item('NEO_URL'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json; charset=UTF-8', 'Content-Type: application/json', 'Content-Length: ' . strlen($data_string), 'X-Stream: true'));
//curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//execute post
        $result = curl_exec($ch);
//close connection
        curl_close($ch);
//echo
        return $result;
    }

    public function bulk() {
        $statements = [];
        $this->load->model('individu_model');
        $individus = $this->individu_model->get_all();
        foreach ($individus as $individu) {
            set_time_limit(5);
            $statements[] = $this->individu_model->neo4j_insert_query($individu->individu_id);
        }
        echo 'Individu';
        $this->load->model('organisasi_model');
        $orgs = $this->organisasi_model->get_all();
        foreach ($orgs as $org) {
            set_time_limit(5);
            $statements[] = $this->organisasi_model->neo4j_insert_query($org->organisasi_id);
        }
        echo 'Organisasi';
        $this->load->model('lapas_model');
        $individus = $this->lapas_model->get_all();
        foreach ($individus as $individu) {
            set_time_limit(5);
            $statements[] = $this->lapas_model->neo4j_insert_query($individu->lapas_id);
        }
        echo 'Lapas';
        $this->load->model('masjid_model');
        $individus = $this->masjid_model->get_all();
        foreach ($individus as $individu) {
            set_time_limit(5);
            $statements[] = $this->masjid_model->neo4j_insert_query($individu->masjid_id);
        }
        echo 'Masjid';
        $this->load->model('school_model');
        $individus = $this->school_model->get_all();
        foreach ($individus as $individu) {
            set_time_limit(5);
            $statements[] = $this->school_model->neo4j_insert_query($individu->school_id);
        }
        echo 'School';
        $this->load->model('teror_model');
        $individus = $this->teror_model->get_all();
        foreach ($individus as $individu) {
            set_time_limit(5);
            $statements[] = $this->teror_model->neo4j_insert_query($individu->teror_id);
        }
        echo 'Teror';
        $this->load->model('nonteror_model');
        $individus = $this->nonteror_model->get_all();
        foreach ($individus as $individu) {
            set_time_limit(5);
            $statements[] = $this->nonteror_model->neo4j_insert_query($individu->nonteror_id);
        }
        echo 'Nonteror';
        $this->load->model('latsen_model');
        $individus = $this->latsen_model->get_all();
        foreach ($individus as $individu) {
            set_time_limit(5);
            $statements[] = $this->latsen_model->neo4j_insert_query($individu->latsen_id);
        }
        echo 'Latsen';
        $this->load->model('latihan_model');
        $individus = $this->latihan_model->get_all();
        foreach ($individus as $individu) {
            set_time_limit(5);
            $statements[] = $this->latihan_model->neo4j_insert_query($individu->latihan_id);
        }
        echo 'Latihan';
        $this->load->model('pengajian_model');
        $individus = $this->pengajian_model->get_all();
        foreach ($individus as $individu) {
            set_time_limit(5);
            $statements[] = $this->pengajian_model->neo4j_insert_query($individu->pengajian_id);
        }
        echo 'Pengajian';
        $this->load->model('edge_model');
        $individus = $this->edge_model->get_all();
        foreach ($individus as $individu) {
            set_time_limit(5);
            $statements[] = $this->edge_model->neo4j_insert_query($individu->edge_id);
        }
        echo 'Edge';
        set_time_limit(500);
        $this->statements($statements);
    }

    public function check_edge() {
        $this->load->model('individu_model');
        $this->load->model('edge_model');
        $this->load->model('pengajian_model');
        $this->load->model('latihan_model');
        $this->load->model('nonteror_model');
        $this->load->model('teror_model');
        $this->load->model('school_model');
        $this->load->model('organisasi_model');
        $this->load->model('lapas_model');
        $this->load->model('latsen_model');
        $this->load->model('masjid_model');
        foreach ($this->db->join('edge_weight', 'edge_weight.weight_id=edge.weight_id')->get('edge')->result() as $edge) {
            switch ($edge->type) {
                case 1:
                    //individu-individu
                    $source = $this->individu_model->get($edge->source_id);
                    $target = $this->individu_model->get($edge->target_id);
                    if (!isset($source)) {
                        echo '<br/>Error : edge_id ' . $edge->edge_id . ' pada source individu_id ' . $edge->source_id;
                    } else if (!isset($target)) {
                        echo '<br/>Error : edge_id ' . $edge->edge_id . ' pada target individu_id ' . $edge->source_id;
                    }
                    break;
                case 2:
                    //individu-organisasi
                    $source = $this->individu_model->get($edge->source_id);
                    $target = $this->organisasi_model->get($edge->target_id);
                    if (!isset($source)) {
                        echo '<br/>Error : edge_id ' . $edge->edge_id . ' pada source individu_id ' . $edge->source_id;
                    } else if (!isset($target)) {
                        echo '<br/>Error : edge_id ' . $edge->edge_id . ' pada target organisasi ' . $edge->source_id;
                    }
                    break;
                case 3:
                    //individu-school
                    $source = $this->individu_model->get($edge->source_id);
                    $target = $this->school_model->get($edge->target_id);
                    if (!isset($source)) {
                        echo '<br/>Error : edge_id ' . $edge->edge_id . ' pada source individu_id ' . $edge->source_id;
                    } else if (!isset($target)) {
                        echo '<br/>Error : edge_id ' . $edge->edge_id . ' pada target school ' . $edge->source_id;
                    }
                    break;
                case 6:
                    //individu-teror
                    $source = $this->individu_model->get($edge->source_id);
                    $target = $this->teror_model->get($edge->target_id);
                    if (!isset($source)) {
                        echo '<br/>Error : edge_id ' . $edge->edge_id . ' pada source individu_id ' . $edge->source_id;
                    } else if (!isset($target)) {
                        echo '<br/>Error : edge_id ' . $edge->edge_id . ' pada target teror ' . $edge->source_id;
                    }
                    break;
                case 7:
                    //individu-nonteror
                    $source = $this->individu_model->get($edge->source_id);
                    $target = $this->nonteror_model->get($edge->target_id);
                    if (!isset($source)) {
                        echo '<br/>Error : edge_id ' . $edge->edge_id . ' pada source individu_id ' . $edge->source_id;
                    } else if (!isset($target)) {
                        echo '<br/>Error : edge_id ' . $edge->edge_id . ' pada target nonteror ' . $edge->source_id;
                    }
                    break;
                case 9:
                    //individu-pengajian
                    $source = $this->individu_model->get($edge->source_id);
                    $target = $this->pengajian_model->get($edge->target_id);
                    if (!isset($source)) {
                        echo '<br/>Error : edge_id ' . $edge->edge_id . ' pada source individu_id ' . $edge->source_id;
                    } else if (!isset($target)) {
                        echo '<br/>Error : edge_id ' . $edge->edge_id . ' pada target pengajian ' . $edge->source_id;
                    }
                    break;
                case 12:
                    //individu-lapas
                    $source = $this->individu_model->get($edge->source_id);
                    $target = $this->lapas_model->get($edge->target_id);
                    if (!isset($source)) {
                        echo '<br/>Error : edge_id ' . $edge->edge_id . ' pada source individu_id ' . $edge->source_id;
                    } else if (!isset($target)) {
                        echo '<br/>Error : edge_id ' . $edge->edge_id . ' pada target lapas ' . $edge->source_id;
                    }
                    break;
                case 8:
                    //individu-latihan militer senjata
                    $source = $this->individu_model->get($edge->source_id);
                    $target = $this->latsen_model->get($edge->target_id);
                    if (!isset($source)) {
                        echo '<br/>Error : edge_id ' . $edge->edge_id . ' pada source individu_id ' . $edge->source_id;
                    } else if (!isset($target)) {
                        echo '<br/>Error : edge_id ' . $edge->edge_id . ' pada target latsen ' . $edge->source_id;
                    }
                    break;
                case 11:
                    //individu-latihan militer non senjata
                    $source = $this->individu_model->get($edge->source_id);
                    $target = $this->latihan_model->get($edge->target_id);
                    if (!isset($source)) {
                        echo '<br/>Error : edge_id ' . $edge->edge_id . ' pada source individu_id ' . $edge->source_id;
                    } else if (!isset($target)) {
                        echo '<br/>Error : edge_id ' . $edge->edge_id . ' pada target latihan ' . $edge->source_id;
                    }
                    break;
                default:
                    break;
            }
        }
    }

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
