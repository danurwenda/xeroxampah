<?php

defined('BASEPATH')OR
        exit('No direct script access allowed');

/**
 * Model terkait table indikator.
 *
 * @author Administrator
 */
class Event_model extends CI_Model {

    public $table = 'event';
    public $primary_key = 'event_id';
    public function __construct() {
        parent::__construct();
    }

    //rarely used
    public function get_all() {
        return $this->db->order_by('event_date','asc')->get($this->table)->result();
    }
}
