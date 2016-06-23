<?php

defined('BASEPATH')OR
        exit('No direct script access allowed');

/**
 * Model terkait table menu.
 *
 * @author Administrator
 */
class Teror_model extends CI_Model {

    public $table = 'teror';
    public $primary_key = 'teror_id';
    private $sequence = 'teror_teror_id_seq';

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

    public function update($id, $tempat, $kotakab, $tanggal, $waktu, $serangan, $sasaran, $motif) {
        return $this->db->update(
                        $this->table, array(
                    'tempat' => $tempat,
                    'kotakab_id' => $kotakab,
                    'tanggal' => $tanggal,
                    'waktu' => $waktu,
                    'serangan' => $serangan,
                    'sasaran' => $sasaran,
                    'motif' => $motif
                        ), [$this->primary_key => $id]
        );
    }

    public function create($tempat, $kotakab, $tanggal, $waktu, $serangan, $sasaran, $motif) {
        $this->db->insert(
                $this->table, array(
            'tempat' => $tempat,
            'tanggal' => $tanggal,
            'kotakab_id' => $kotakab,
            'waktu' => $waktu,
            'serangan' => $serangan,
            'sasaran' => $sasaran,
            'motif' => $motif
                )
        );
        return $this->last_id();
    }

    private function last_id() {
        return $this->db->insert_id($this->sequence);
    }

    public function neo4j_insert_query($id) {
        $teror = $this->get($id);
        $prop = "tempat:'" . addslashes($teror->tempat) . "',";
        $prop .= "serangan:'" . addslashes($teror->serangan) . "',";
        $prop .= "sasaran:'" . addslashes($teror->sasaran) . "',";
        $prop .= "tanggal:'" . $teror->tanggal . "',";
        $prop .= "waktu:'" . $teror->waktu . "',";
        $prop.="teror_id:" . $id;
        return "MERGE(Teror_$id:Teror { $prop } )";
    }

    public function neo4j_delete_query($id) {
        return "match(n:Teror{teror_id:$id})detach delete n";
    }

    public function neo4j_update_query($id, $tempat, $tanggal, $waktu, $serangan, $sasaran) {
        return "match(n:Teror{teror_id:$id})set n.name='" . addslashes($nama)
                . "',n.tempat='" . addslashes($tempat)
                . "',n.sasaran='" . addslashes($sasaran)
                . "',n.serangan='" . addslashes($serangan)
                . "',n.tanggal='" . addslashes($tanggal)
                . "',n.waktu='" . addslashes($waktu)
                . "' return n";
    }

}
