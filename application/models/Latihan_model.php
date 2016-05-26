<?php

defined('BASEPATH')OR
        exit('No direct script access allowed');

/**
 * Model terkait table menu.
 *
 * @author Administrator
 */
class Latihan_model extends CI_Model {

    public $table = 'latihan';
    public $primary_key = 'latihan_id';
    private $sequence = 'latihan_latihan_id_seq';

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

    public function update($id, $tempat, $sejak, $hingga, $materi, $motif) {
        return $this->db->update(
                        $this->table, array(
                    'tempat' => $tempat,
                    'sejak' => $sejak,
                    'hingga' => $hingga,
                    'materi' => $materi,
                    'motif' => $motif
                        ), [$this->primary_key => $id]
        );
    }

    public function create($tempat, $sejak, $hingga, $materi, $motif) {
        $this->db->insert(
                $this->table, array(
            'tempat' => $tempat,
            'sejak' => $sejak,
            'hingga' => $hingga,
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
        $latihan = $this->get($id);
        $prop = "tempat:'" . $latihan->tempat . "',";
        $prop .= "materi:'" . $latihan->materi . "',";
        $prop.="latihan_id:" . $id;
        return "MERGE(Latihan_$id:Latihan { $prop } )";
    }

    public function neo4j_delete_query($id) {
        return "match(n:Latihan{latihan_id:$id})detach delete n";
    }

    public function neo4j_update_query($id, $tempat, $materi) {
        return "match(n:Latihan{latihan_id:$id})set "
                . "n.tempat='" . addslashes($tempat)
                . "',n.materi='" . addslashes($materi)
                . "' return n";
    }

}
