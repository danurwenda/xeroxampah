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

    public function update($id, $nama, $alias, $born_date, $born_place, $nationality, $detention_history, $detention_status, $education, $affiliation, $family_conn, $source_id) {
        return $this->db->update(
                        $this->table, array(
                    'name' => $nama,
                    'alias' => $alias,
                    'born_date' => $born_date,
                    'born_place' => $born_place,
                    'nationality' => $nationality,
                    'detention_history' => $detention_history,
                    'detention_status' => $detention_status,
                    'education' => $education,
                    'family_conn' => $family_conn,
                    'affiliation' => $affiliation,
                    'source_id' => $source_id,
                        ), [$this->primary_key => $id]
        );
    }

    public function create($nama, $alias, $born_date, $born_place, $nationality, $detention_history, $detention_status, $education, $affiliation, $family_conn, $source_id) {
        return $this->db->insert(
                        $this->table, array(
                    'name' => $nama,
                    'alias' => $alias,
                    'born_date' => $born_date,
                    'born_place' => $born_place,
                    'nationality' => $nationality,
                    'detention_history' => $detention_history,
                    'detention_status' => $detention_status,
                    'education' => $education,
                    'family_conn' => $family_conn,
                    'affiliation' => $affiliation,
                    'source_id' => $source_id,
                        )
        );
    }

}
