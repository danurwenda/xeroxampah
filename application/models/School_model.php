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
        $prop = "name:'" . addslashes($this->get($id)->name) . "',";
        $prop .= "city:'" . addslashes($this->get($id)->city) . "',";
        $prop .= "address:'" . addslashes($this->get($id)->address) . "',";
        $prop.="school_id:" . $id;
        return "MERGE(School_$id:School { $prop } )";
    }

    public function neo4j_delete_query($id) {
        return "match(n:School{school_id:$id})detach delete n";
    }

    public function neo4j_update_query($id, $nama, $address, $city) {
        return "match(n:School{school_id:$id})set n.name='" . addslashes($nama) . "',n.address='" . addslashes($address) . "',n.city='" . addslashes($city) . "' return n";
    }

}
