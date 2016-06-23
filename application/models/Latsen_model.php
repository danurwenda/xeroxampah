<?php

defined('BASEPATH')OR
        exit('No direct script access allowed');

/**
 * Model terkait table menu.
 *
 * @author Administrator
 */
class Latsen_model extends CI_Model {

    public $table = 'latsen';
    public $primary_key = 'latsen_id';
    private $sequence = 'latsen_latsen_id_seq';

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

    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    public function delete($id) {
        return $this->db->delete($this->table, [$this->primary_key => $id]);
    }

    public function update($id, $tempat, $kotakab, $sejak, $hingga, $materi, $motif) {
        return $this->db->update(
                        $this->table, array(
                    'tempat' => $tempat,
                    'sejak' => $sejak,
                    'hingga' => $hingga,
                    'kotakab_id' => $kotakab,
                    'materi' => $materi,
                    'motif' => $motif
                        ), [$this->primary_key => $id]
        );
    }

    public function create($tempat, $kotakab, $sejak, $hingga, $materi, $motif) {
        $this->db->insert(
                $this->table, array(
            'tempat' => $tempat,
            'sejak' => $sejak,
            'hingga' => $hingga,
            'kotakab_id' => $kotakab,
            'materi' => $materi,
            'motif' => $motif
                )
        );
        return $this->last_id();
    }

    private function last_id() {
        return $this->db->insert_id($this->sequence);
    }

    public function neo4j_insert_query($id) {
        $latsen = $this->get($id);
        $prop = "tempat:'" . addslashes($latsen->tempat) . "',";
        $prop .= "materi:'" . addslashes($latsen->materi) . "',";
        $prop.="latsen_id:" . $id;
        return "MERGE(Latsen_$id:Latsen { $prop } )";
    }

    public function neo4j_delete_query($id) {
        return "match(n:Latsen{latsen_id:$id})detach delete n";
    }

    public function neo4j_update_query($id, $tempat, $materi) {
        return "match(n:Latsen{latsen_id:$id})set "
                . "n.tempat='" . addslashes($tempat)
                . "',n.materi='" . addslashes($materi)
                . "' return n";
    }

}
