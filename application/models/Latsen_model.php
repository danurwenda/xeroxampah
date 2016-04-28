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

    public function insert_or_lookup($org_id) {
        $oid = null;
        if (is_numeric($org_id)) {
            //lookup
            //check db
            $org = $this->db->get_where('organization', ['org_id' => $org_id]);
            if ($org->num_rows() > 0) {
                //ada
                $oid = $org->row()->org_id;
            }
        } else {
            //raw name, insert into organization
            $this->db->insert('organization', ['org_name' => $org_id]);
            $oid = $this->db->insert_id('organization_org_id_seq');
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
        $latsen = $this->get($id);
        $prop = "tempat:'" . addslashes($latsen->tempat) . "',";
        $prop .= "materi:'" . addslashes($latsen->materi) . "',";
        $prop .= "motif:'" . addslashes($latsen->motif) . "',";
        $prop .= "sejak:'" . $latsen->sejak . "',";
        $prop .= "hingga:'" . $latsen->hingga . "',";
        $prop.="latsen_id:" . $id;
        return "MERGE(Latsen_$id:Latsen { $prop } )";
    }

}
