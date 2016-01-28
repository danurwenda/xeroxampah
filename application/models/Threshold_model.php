<?php

defined('BASEPATH')OR
        exit('No direct script access allowed');

/**
 * Model terkait table indikator.
 *
 * @author Administrator
 */
class Threshold_model extends CI_Model {

    public $table = 'triggered_threshold';
    public $primary_key = 'indikator_id';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Special handling di sini karena perlu convert dari array nya postgre ke array php
     * @param type $indikator_id
     * @return type
     */
    public function get($indikator_id) {
        $q = $this->db
                ->select("indikator_id, forecast, array_to_json(threshold_vals) as threshold_vals, time_triggered, last_data_date")
                ->where($this->primary_key, $indikator_id)
                ->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        } else {
            return null;
        }
    }
    
    /**
     * Given an array of indikator_id, select latest data and threshold. 
     * Indikator without existing threshold will be omitted.
     * indikator_id | latest_value | latest_date | forecast | threshold_vals
     * @param type $arr_id
     */
    public function get_threshold_data($arr_id) {
        // select a.indikator_id, a.date latest_date, a.val latest_val, forecast, threshold_vals from data a 
        // inner join
        // triggered_threshold tt
        // on tt.indikator_id = a.indikator_id
        // join
        // (select indikator_id bindikator_id, max(date) maxDate
        // from data group by indikator_id) b
        // on a.indikator_id = bindikator_id and a.date = b.maxDate
        // where a.indikator_id in $arr_id;
        //create subquery to find latest data
        $this->db
                ->select('indikator_id')
                ->select_max('date', 'maxDate')
                ->group_by('indikator_id');
        $maxDateQuery = $this->db->get_compiled_select('data');
        //main query
        $q = $this->db
                ->select('i.is_strategic, a.indikator_id, i.indikator_name, a.date as latest_date, a.val as latest_val, forecast, array_to_json(threshold_vals) as threshold_vals')
                ->from('data a')
                ->join('indikator i','i.indikator_id = a.indikator_id')
                ->join('triggered_threshold tt', 'tt.indikator_id = a.indikator_id')
                ->join(" ( $maxDateQuery ) b", 'a.indikator_id=b.indikator_id and a.date = b.maxDate')
                ->where_in('a.indikator_id', $arr_id)
                ->get();
        if ($q->num_rows() > 0) {
            return $q->result();
        } else {
            return []; //empty array
        }
    }

}
