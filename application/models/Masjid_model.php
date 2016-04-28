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

    public function insert_or_lookup($masjid_id) {
        $oid = null;
        if (is_numeric($masjid_id)) {
            //lookup
            //check db
            $masjid = $this->db->get_where('masjid', ['masjid_id' => $masjid_id]);
            if ($masjid->num_rows() > 0) {
                //ada
                $oid = $masjid->row()->masjid_id;
            }
        } else {
            //raw name, insert into masjid
            $this->db->insert('masjid', ['name' => $masjid_id]);
            $oid = $this->db->insert_id('masjid_masjid_id_seq');
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
        $prop.="masjid_id:" . $id;
        return "MERGE(Masjid_$id:Masjid { $prop } )";
    }

}
