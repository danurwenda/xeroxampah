<?php

defined('BASEPATH')OR
        exit('No direct script access allowed');

/**
 * Model terkait table menu.
 *
 * @author Administrator
 */
class Organisasi_model extends CI_Model {

    public $table = 'organisasi';
    public $primary_key = 'organisasi_id';
    private $sequence = 'organisasi_organisasi_id_seq';

    public function get_all() {
        return $this->db->get($this->table)->result();
    }

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

    public function update($id, $label, $nama, $daerah) {
        return $this->db->update(
                        $this->table, array(
                    'label' => $label,
                    'name' => $nama,
                    'daerah' => $daerah
                        ), [$this->primary_key => $id]
        );
    }

    public function create($label, $nama, $daerah) {
        $this->db->insert(
                $this->table, array(
            'label' => $label,
            'name' => $nama,
            'daerah' => $daerah
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
        $prop.= "daerah:'" . addslashes($x->daerah) . "',";
        $prop.="organisasi_id:" . $id;
        return "MERGE(Organisasi_$id:Organisasi { $prop } )";
    }

    public function neo4j_delete_query($id) {
        return "match(n:Organisasi{organisasi_id:$id})detach delete n";
    }

    public function neo4j_update_query($id, $label, $nama, $daerah) {
        return "match(n:Organisasi{organisasi_id:$id})set n.name='" . addslashes($nama) . "',n.label='" . addslashes($label) . "',n.daerah='" . addslashes($daerah) . "' return n";
    }

}
