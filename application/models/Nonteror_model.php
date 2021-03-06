<?php

defined('BASEPATH')OR
        exit('No direct script access allowed');

/**
 * Model terkait table menu.
 *
 * @author Administrator
 */
class Nonteror_model extends CI_Model {

    public $table = 'nonteror';
    public $primary_key = 'nonteror_id';
    private $sequence = 'nonteror_nonteror_id_seq';

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

    public function update($id, $label, $tempat, $kotakab, $tanggal, $waktu, $pidana, $korban, $motif) {
        return $this->db->update(
                        $this->table, array(
                    'tempat' => $tempat,
                    'label' => $label,
                    'tanggal' => $tanggal,
                    'kotakab_id' => $kotakab,
                    'waktu' => $waktu,
                    'korban' => $korban,
                    'pidana' => $pidana,
                    'motif' => $motif
                        ), [$this->primary_key => $id]
        );
    }

    public function create($label, $tempat, $kotakab, $tanggal, $waktu, $pidana, $korban, $motif) {
        $this->db->insert(
                $this->table, array(
            'kotakab_id' => $kotakab,
            'tempat' => $tempat,
            'label' => $label,
            'tanggal' => $tanggal,
            'waktu' => $waktu,
            'korban' => $korban,
            'pidana' => $pidana,
            'motif' => $motif
                )
        );
        return $this->last_id();
    }

    private function last_id() {
        return $this->db->insert_id($this->sequence);
    }

    public function neo4j_insert_query($id) {
        $nonteror = $this->get($id);
        $prop = "tempat:'" . addslashes($nonteror->tempat) . "',";
        $prop .= "korban:'" . addslashes($nonteror->korban) . "',";
        $prop .= "label:'" . addslashes($nonteror->label) . "',";
        $prop .= "pidana:'" . addslashes($nonteror->pidana) . "',";
        $prop .= "nilai:'" . addslashes($nonteror->nilai) . "',";
        $prop .= "tanggal:'" . $nonteror->tanggal . "',";
        $prop .= "waktu:'" . $nonteror->waktu . "',";
        $prop.="nonteror_id:" . $id;
        return "MERGE(Nonteror_$id:Nonteror { $prop } )";
    }

    public function neo4j_delete_query($id) {
        return "match(n:Nonteror{nonteror_id:$id})detach delete n";
    }

    public function neo4j_update_query($id, $label, $tempat, $tanggal, $waktu, $korban, $pidana, $nilai) {
        return "match(n:Nonteror{nonteror_id:$id})set n.name='" . addslashes($nama)
                . "',n.tempat='" . addslashes($tempat)
                . "',n.label='" . addslashes($label)
                . "',n.pidana='" . addslashes($pidana)
                . "',n.korban='" . addslashes($korban)
                . "',n.nilai='" . addslashes($nilai)
                . "',n.tanggal='" . addslashes($tanggal)
                . "',n.waktu='" . addslashes($waktu)
                . "' return n";
    }

}
