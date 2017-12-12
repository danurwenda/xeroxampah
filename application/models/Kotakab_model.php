<?php

defined('BASEPATH')OR
        exit('No direct script access allowed');

/**
 * Model terkait table menu.
 *
 * @author Administrator
 */
class Kotakab_model extends CI_Model {

    public $table = 'kotakab';
    public $primary_key = 'kotakab_id';
    private $sequence = 'kotakab_kotakab_id_seq';

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

    private function last_id() {
        return $this->db->insert_id($this->sequence);
    }

    public function create($kotakab, $prov, $negara) {
        $this->db->insert(
                $this->table, array(
            'kotakab' => $kotakab,
            'provinsi' => $prov,
            'negara' => $negara
                )
        );
        return $this->last_id();
    }

}
