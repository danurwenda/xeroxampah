<?php

defined('BASEPATH')OR
        exit('No direct script access allowed');

/**
 * Model terkait table menu.
 *
 * @author Administrator
 */
class Lapas_model extends CI_Model {

    public $table = 'lapas';
    public $primary_key = 'lapas_id';
    private $sequence = 'lapas_lapas_id_seq';

    public function __construct() {
        parent::__construct();
    }

    public function insert_or_lookup($org_id) {
        $oid = null;
        if (is_numeric($org_id)) {
            //lookup
            //check db
            $org = $this->db->get_where('lapas', ['lapas_id' => $org_id]);
            if ($org->num_rows() > 0) {
                //ada
                $oid = $org->row()->org_id;
            }
        } else {
            //raw name, insert into lapas
            $this->db->insert('lapas', ['name' => $org_id]);
            $oid = $this->db->insert_id($this->sequence);
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

    public function update($id, $name, $address) {
        return $this->db->update(
                        $this->table, array(
                    'name' => $name,
                    'address' => $address
                        ), [$this->primary_key => $id]
        );
    }

    public function create($name, $address) {
        $this->db->insert(
                $this->table, array(
            'name' => $name,
            'address' => $address
                )
        );
        return $this->last_id();
    }

    private function last_id() {
        return $this->db->insert_id($this->sequence);
    }

    public function neo4j_insert_query($id) {
        $prop = "name:'" . $this->get($id)->name . "',";
        $prop.="org_id:" . $id;
        return "MERGE(Lapas_$id:Lapas { $prop } )";
    }

}
