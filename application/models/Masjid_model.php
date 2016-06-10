<?php

defined('BASEPATH')OR
        exit('No direct script access allowed');

/**
 * Model terkait table menu.
 *
 * @author Administrator
 */
class Masjid_model extends CI_Model {

    public $table = 'masjid';
    public $primary_key = 'masjid_id';
    private $sequence = 'masjid_masjid_id_seq';

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

    public function update($id, $nama, $address, $kotakab) {
        return $this->db->update(
                        $this->table, array(
                    'name' => $nama,
                    'address' => $address,
                    'kotakab_id' => $kotakab
                        ), [$this->primary_key => $id]
        );
    }

    public function create($nama, $address, $kotakab) {
        $this->db->insert(
                $this->table, array(
            'name' => $nama,
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
        $prop = "name:'" . addslashes($this->get($id)->name) . "',";
        $prop.= "kotakab:'" . addslashes($this->get($id)->kotakab_id) . "',";
        $prop.= "address:'" . addslashes($this->get($id)->address) . "',";
        $prop.="masjid_id:" . $id;
        return "MERGE(Masjid_$id:Masjid { $prop } )";
    }

    public function neo4j_delete_query($id) {
        return "match(n:Masjid{masjid_id:$id})detach delete n";
    }

    public function neo4j_update_query($id, $nama, $address, $kotakab) {
        return "match(n:Masjid{masjid_id:$id})set n.name='" . addslashes($nama) . "',n.address='" . addslashes($address) . "',n.kotakab='" . addslashes($kotakab) . "' return n";
    }

}
