<?php

defined('BASEPATH')OR
        exit('No direct script access allowed');

/**
 * Model terkait table indikator.
 *
 * @author Administrator
 */
class Chart_model extends CI_Model {

    public $table = 'chart';
    public $primary_key = 'chart_id';

    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @param type $indikator_id
     */
    public function get_chart($indikator_id, $is_strategic = false) {
        $q = $this->db
                ->select('title,chart.source,chart_id,position,title_indikator')
                ->join('indikator', 'indikator.indikator_id=chart.parent_indikator_id')
                ->order_by('position')
                ->get_where(
                $this->table, [
            'parent_indikator_id' => $indikator_id,
            'chart.is_strategic' => $is_strategic
        ]);
        if ($q->num_rows() > 0) {
            if ($is_strategic) {
                //ambil satu aja
                $r = $q->row();
                //ada chart nya, mari kita buat daftar series nya
                $this->assign_series($r);
                return [$r];
            } else {
                //ambil semua
                $ret = $q->result();
                foreach ($ret as $chart_row) {
                    $this->assign_series($chart_row);
                }
                return $ret;
            }
        } else {
            return [];
        }
    }

    private function assign_series($chart_row) {
        $chart_row->series = $this->db
                        ->join('indikator', 'indikator.indikator_id=chart_serie.indikator_id')
                        ->get_where('chart_serie', ['chart_id' => $chart_row->chart_id])->result();
        return $chart_row;
    }

}
