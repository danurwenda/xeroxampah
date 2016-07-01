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
                    'name' => $nama,
                    'label' => $label,
                    'address' => $address,
                    'kotakab_id' => $kotakab
                        ), [$this->primary_key => $id]
        );
    }

    public function create($label, $nama, $address, $kotakab) {
        $this->db->insert(
                $this->table, array(
            'name' => $nama,
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
        $prop = "name:'" . addslashes($x->name) . "',";
        $prop.= "label:'" . addslashes($x->label) . "',";
        $prop.= "kotakab:'" . addslashes($x->kotakab_id) . "',";
        $prop.= "address:'" . addslashes($x->address) . "',";
        $prop.="lapas_id:" . $id;
        return "MERGE(Lapas_$id:Lapas { $prop } )";
    }

    public function neo4j_delete_query($id) {
        return "match(n:Lapas{lapas_id:$id})detach delete n";
    }

    public function neo4j_update_query($id, $label,$nama, $address, $kotakab) {
        return "match(n:Lapas{lapas_id:$id})set n.name='" . addslashes($nama) . "',n.label='" . addslashes($label) . "',n.address='" . addslashes($address) . "',n.kotakab='" . addslashes($kotakab) . "' return n";
    }

}
