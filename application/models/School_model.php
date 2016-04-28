<?php

defined('BASEPATH')OR
        exit('No direct script access allowed');

/**
 * Model terkait table menu.
 *
 * @author Administrator
 */
class School_model extends CI_Model {

    public $table = 'school';
    public $primary_key = 'school_id';
    private $sequence = 'school_school_id_seq';

    public function __construct() {
        parent::__construct();
    }

    public function insert_or_lookup($school_id) {
        $oid = null;
        if (is_numeric($school_id)) {
            //lookup
            //check db
            $school = $this->db->get_where('school', ['school_id' => $school_id]);
            if ($school->num_rows() > 0) {
                //ada
                $oid = $school->row()->school_id;
            }
        } else {
            //raw name, insert into school
            $this->db->insert('school', ['school_name' => $school_id]);
            $oid = $this->db->insert_id('school_school_id_seq');
        }
        return $oid;
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

    public function delete($id) {
        return $this->db->delete($this->table, [$this->primary_key => $id]);
    }

    public function update($id, $nama, $address, $city) {
        return $this->db->update(
                        $this->table, array(
                    'name' => $nama,
                    'address' => $address,
                    'city' => $city
                        ), [$this->primary_key => $id]
        );
    }

    public function create($nama, $address, $city) {
        $this->db->insert(
                $this->table, array(
            'name' => $nama,
            'address' => $address,
            'city' => $city
                )
        );
        return $this->last_id();
    }

    private function last_id() {
        return $this->db->insert_id($this->sequence);
    }

    public function neo4j_insert_query($id) {
        $prop = "name:'" . $this->get($id)->name . "',";
        $prop.="school_id:" . $id;
        return "MERGE(School_$id:School { $prop } )";
    }

}
