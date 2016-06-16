<?php

defined('BASEPATH')OR
        exit('No direct script access allowed');

/**
 * Model terkait table menu.
 *
 * @author Administrator
 */
class Document_model extends CI_Model {

    public $table = 'bap';
    public $primary_key = 'bap_id';
    private $sequence = 'bap_bap_id_seq';

    public function __construct() {
        parent::__construct();
    }

    public function get_individu_bap($individu_id) {
        return $this->db->get_where($this->table, ['individu_id' => $individu_id])->result();
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

    public function delete_by_name($filename) {
        return $this->db->delete($this->table, ['filename' => $filename]);
    }

    public function insert($filename, $individu_id) {
        $this->db->insert(
                $this->table, array(
            'individu_id' => $individu_id,
            'filename' => $filename
                )
        );
        return $this->last_id();
    }

    private function last_id() {
        return $this->db->insert_id($this->sequence);
    }

}
