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

    public function update($id, $nama, $daerah) {
        return $this->db->update(
                        $this->table, array(
                    'name' => $nama,
                    'daerah' => $daerah
                        ), [$this->primary_key => $id]
        );
    }

    public function create($nama, $daerah) {
        $this->db->insert(
                $this->table, array(
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
        $prop = "name:'" . addslashes($this->get($id)->name) . "',";
        $prop.= "daerah:'" . addslashes($this->get($id)->daerah) . "',";
        $prop.="organisasi_id:" . $id;
        return "MERGE(Organisasi_$id:Organisasi { $prop } )";
    }

    public function neo4j_delete_query($id) {
        return "match(n:Organisasi{organisasi_id:$id})detach delete n";
    }

    public function neo4j_update_query($id, $nama, $daerah) {
        return "match(n:Organisasi{organisasi_id:$id})set n.name='" . addslashes($nama) . "',n.daerah='" . addslashes($daerah) . "' return n";
    }

}
