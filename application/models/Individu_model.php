<?php

defined('BASEPATH')OR
        exit('No direct script access allowed');

/**
 * Model terkait table menu.
 *
 * @author Administrator
 */
class Individu_model extends CI_Model {

    public $table = 'individu';
    public $primary_key = 'individu_id';
    private $sequence = 'individu_individu_id_seq';

    public function __construct() {
        parent::__construct();
    }

    public function get($id) {
        $q = $this->db
                ->get_where($this->table, [$this->primary_key => $id]);
        if ($q->num_rows() > 0) {
            return $q->row();
        } else {
            return null;
        }
    }

    public function get_cascade($id) {
        $q = $this->db
                ->get_where($this->table, [$this->primary_key => $id]);
        if ($q->num_rows() > 0) {
            $individu = $q->row();
            //add relation
            //ayah & ibu
            //edge 46 & edge 47
            $ayah = $this->db
                    ->get_where('edge', ['target_id' => $id,'weight_id'=>46]);
            if ($ayah->num_rows() > 0) {
                $individu->father = $ayah->row();
            }
            $ibu = $this->db
                    ->get_where('edge', ['target_id' => $id,'weight_id'=>47]);
            if ($ibu->num_rows() > 0) {
                $individu->mother = $ibu->row();
            }
            return $individu;
        } else {
            return null;
        }
    }

    public function delete($id) {
        return $this->db->delete($this->table, [$this->primary_key => $id]);
    }

    public function update($id, $nama, $alias, $born_date, $born_place, $nationality, $detention_history, $detention_status, $education, $affiliation, $family_conn, $source_id) {
        return $this->db->update(
                        $this->table, array(
                    'name' => $nama,
                    'alias' => $alias,
                    'born_date' => $born_date,
                    'born_place' => $born_place,
                    'nationality' => $nationality,
                    'detention_history' => $detention_history,
                    'detention_status' => $detention_status,
                    'education' => $education,
                    'family_conn' => $family_conn,
                    'affiliation' => $affiliation,
                    'source_id' => $source_id,
                        ), [$this->primary_key => $id]
        );
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->last_id();
    }

    private function last_id() {
        return $this->db->insert_id($this->sequence);
    }

    public function neo4j_insert_query($id) {        
        $prop="individu_name:'".addslashes($this->get($id)->individu_name)."',";
        $prop.="individu_id:".$id;
        return "MERGE(Individu$id:Individu { $prop } )";
    }

}
