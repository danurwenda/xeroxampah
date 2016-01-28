<?php

defined('BASEPATH')OR
        exit('No direct script access allowed');

/**
 * Model terkait table indikator.
 *
 * @author Administrator
 */
class Data_model extends CI_Model {

    public $table = 'data';
    public $primary_key = 'data_id';
    private $recentDataByFreq = [
        '', //our table id starts from 1 not 0
        14, //D
        12, //W
        12, //M
        12, //Y-Q
        12, //Q-Y
        12, //Y-M
        10, //Y
        10//S
    ];

    public function __construct() {
        parent::__construct();
    }

    //rarely used
    public function get($data_id) {
        $q = $this->db->get_where($this->table, [$this->primary_key => $data_id]);
        if ($q->num_rows() > 0) {
            return $q->row();
        } else {
            return null;
        }
    }

    /**
     * Return latest data of selected indikator
     * @param type $indikator_id
     */
    public function get_latest($indikator_id) {
        $q = $this->db
                ->order_by('date', 'desc')//latest on top
                ->limit(1)
                ->get_where($this->table, ['indikator_id' => $indikator_id]);
        if ($q->num_rows() > 0) {
            return $q->row();
        } else {
            return null;
        }
    }

    /**
     * Sebenarnya ini buat kebutuhan charting. Jadi misalnya untuk data harian,
     * hanya diambil 14 data terakhir.
     * @param type $indikator_id
     * @see $recentDataByFreq
     */
    public function get_recent_data($indikator_id) {
        $freqId = $this->db
                        ->select('frekuensi')
                        ->where('indikator_id', $indikator_id)
                        ->get('indikator')
                        ->row()
                ->frekuensi;
        $fetchNum = isset($freqId) ? $this->recentDataByFreq[$freqId] : 10;
        return array_reverse($this->db
                        ->select('date, val')
                        ->where('indikator_id', $indikator_id)
                        ->order_by('date', 'desc')
                        ->limit($fetchNum)
                        ->get($this->table)
                        ->result());
    }

    public function get_all_data($indikator_id, $as_array_of_value = true) {
        $result = $this->db->order_by('date', 'asc')->get_where($this->table, ['indikator_id' => $indikator_id])->result();
        if ($as_array_of_value) {
            $ret = [];
            foreach ($result as $row) {
                $ret[] = $row->val;
            }
            return $ret;
        } else {
            return $result;
        }
    }

    public function get_month_avg($indikator_id, $date, $month_diff = 0, $year_diff = 0) {
        $sql = "select avg(val) rerata from data where data.indikator_id= ? and date_trunc('month',data.date)=timestamp ? ";
//        $date = date_create('2000-01-01');
//        date_add($date, date_interval_create_from_date_string('10 days'));
//        echo date_format($date, 'Y-m-d');
        $dateF = date('Y-m-01', strtotime("$year_diff year $month_diff month", $date));
        return $this->db->query($sql, array($indikator_id, $dateF))->row()->rerata;
    }

    /**
     * 
     * @param type $batch array of array of (field->value)
     */
    public function insert_or_update($batch) {
        $insert = [];
        $update = [];
        foreach ($batch as $q) {
            //cek apakah ada data dengan indikator itu di date itu
            $query = $this->db->get_where('data', ['indikator_id' => $q['indikator_id'], 'date' => $q['date']]);
            if ($query->num_rows() > 0) {
                //ada, berarti update
                $row = $query->row();
                $q['data_id'] = $row->data_id;
                $q['edit_by'] = $q['insert_by'];
                unset($q['insert_by']);
                $update[] = $q;
            } else {
                //ga ada, berarti insert
                $insert[] = $q;
            }
        }

        if (!empty($insert)) {
            $this->db->insert_batch('data', $insert);
        }

        if (!empty($update)) {
            $this->db->update_batch('data', $update, 'data_id');
        }
    }

}
