<?php

defined('BASEPATH')OR
        exit('No direct script access allowed');

/**
 * Model terkait table menu.
 *
 * @author Administrator
 */
class Source_model extends CI_Model {

    public $table = 'source';
    public $primary_key = 'source_id';

    public function __construct() {
        parent::__construct();
    }
    
    public function get_all(){
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
    
    public function delete($id){
        return $this->db->delete($this->table,[$this->primary_key => $id]);
    }

    public function update($id, $org_name, $address, $website, $email, $phone, $description) {
        return $this->db->update(
                        $this->table, array(
                    'org_name' => $org_name,
                    'address' => $address,
                    'website' => $website,
                    'email' => $email,
                    'phone' => $phone,
                    'description' => $description
                        ), [$this->primary_key => $id]
        );
    }

    public function create($org_name, $address, $website, $email, $phone, $description) {
        return $this->db->insert(
                        $this->table, array(
                    'org_name' => $org_name,
                    'address' => $address,
                    'website' => $website,
                    'email' => $email,
                    'phone' => $phone,
                    'description' => $description
                        )
        );
    }

}
