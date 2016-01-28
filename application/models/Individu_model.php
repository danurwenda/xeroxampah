<?php

defined('BASEPATH')OR
        exit('No direct script access allowed');

/**
 * Model terkait table menu.
 *
 * @author Administrator
 */
class Individu_model extends CI_Model {

    public $table = 'individu';
    public $primary_key = 'individu_id';

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

    public function update($id, $name, $alias, $born_date, $born_place, $nationality, $detention_history, $detention_status, $education, $affiliation, $source_id) {
        return $this->db->update(
                        $this->table, array(
                    'nama' => $name,
                    'alias' => $alias,
                    'born_date' => $born_date,
                    'born_place' => $born_place,
                    'nationality' => $nationality,
                    'detention_history' => $detention_history,
                    'detention_status' => $detention_status,
                    'education' => $education,
                    'affiliation' => $affiliation,
                    'source' => $source_id,
                        ), [$this->primary_key => $id]
        );
    }

    public function create($org_name, $address, $website, $email, $phone, $description, $source) {
        return $this->db->insert(
                        $this->table, array(
                    'org_name' => $org_name,
                    'address' => $address,
                    'website' => $website,
                    'email' => $email,
                    'phone' => $phone,
                    'description' => $description,
                    'source_id' => $source
                        )
        );
    }

}
