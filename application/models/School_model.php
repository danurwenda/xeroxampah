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

    public function get_all() {
        return $this->db->get($this->table)->result();
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

    public function update($id, $label, $nama, $address, $kotakab) {
        return $this->db->update(
                        $this->table, array(
                    'school_name' => $nama,
                    'label' => $label,
                    'kotakab_id' => $kotakab,
                    'address' => $address
                        ), [$this->primary_key => $id]
        );
    }

    public function create($label, $nama, $address, $kotakab) {
        $this->db->insert(
                $this->table, array(
            'school_name' => $nama,
            'label' => $label,
            'address' => $address,
            'kotakab_id' => $kotakab
                )
        );
        return $this->last_id();
    }

    private function last_id() {
        return $this->db->insert_id($this->sequence);
    }

    public function neo4j_insert_query($id) {
        $x = $this->get($id);
        $prop = "school_name:'" . addslashes($x->school_name) . "',";
        $prop .= "kotakab_id:'" . addslashes($x->kotakab_id) . "',";
        $prop .= "label:'" . addslashes($x->label) . "',";
        $prop .= "address:'" . addslashes($x->address) . "',";
        $prop.="school_id:" . $id;
        return "MERGE(School_$id:School { $prop } )";
    }

    public function neo4j_delete_query($id) {
        return "match(n:School{school_id:$id})detach delete n";
    }

    public function neo4j_update_query($id, $label, $nama, $address, $kotakab) {
        return "match(n:School{school_id:$id})set n.school_name='" . addslashes($nama) . "',n.label='" . addslashes($label) . "',n.address='" . addslashes($address) . "',n.kotakab_id='" . addslashes($kotakab) . "' return n";
    }

}
