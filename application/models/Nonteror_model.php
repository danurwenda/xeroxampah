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

    public function update($id, $org_name, $address, $website, $email, $phone, $description, $source) {
        return $this->db->update(
                        $this->table, array(
                    'org_name' => $org_name,
                    'address' => $address,
                    'website' => $website,
                    'email' => $email,
                    'phone' => $phone,
                    'description' => $description,
                    'source_id' => $source
                        ), [$this->primary_key => $id]
        );
    }

    public function create($tempat, $tanggal, $waktu, $pidana, $korban, $nilai, $motif) {
        return $this->db->insert(
                        $this->table, array(
                    'tempat' => $tempat,
                    'tanggal' => $tanggal,
                    'waktu' => $waktu,
                    'pidana' => $pidana,
                    'korban' => $korban,
                    'nilai' => $nilai,
                    'motif' => $motif
                        )
        );
    }

}
