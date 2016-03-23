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

    public function update($id, $tempat, $tanggal, $waktu, $serangan, $sasaran, $motif) {
        return $this->db->update(
                        $this->table, array(
                    'tempat' => $tempat,
                    'tanggal' => $tanggal,
                    'waktu' => $waktu,
                    'serangan' => $serangan,
                    'sasaran' => $sasaran,
                    'motif' => $motif
                        ), [$this->primary_key => $id]
        );
    }

    public function create($tempat, $tanggal, $waktu, $serangan, $sasaran, $motif) {
        return $this->db->insert(
                        $this->table, array(
                    'tempat' => $tempat,
                    'tanggal' => $tanggal,
                    'waktu' => $waktu,
                    'serangan' => $serangan,
                    'sasaran' => $sasaran,
                    'motif' => $motif
                        )
        );
    }

}
