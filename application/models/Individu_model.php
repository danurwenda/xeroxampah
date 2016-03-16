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

    public function get_cascade($id) {
        $q = $this->db
                ->get_where($this->table, [$this->primary_key => $id]);
        if ($q->num_rows() > 0) {
            $individu = $q->row();
            //add relation
            //ayah & ibu
            $parents = $this->db
                    ->select('father_id,mother_id,marriage.marriage_id')
                    ->join('marriage', 'marriage.marriage_id=parents.marriage_id')
                    ->get_where('parents', ['child_id' => $id]);
            if ($parents->num_rows() > 0) {
                $mar = $parents->row();
                //harusnya seseorang itu hanya terdaftar sebagai anak dari sebuah pasangan
                $individu->father = ['father_id' => $mar->father_id, 'father_name' => $this->get($mar->father_id)->individu_name];
                $individu->mother = ['mother_name' => $this->get($mar->mother_id)->individu_name, 'mother_id' => $mar->mother_id];
                $s = [];
                foreach ($this->db->get_where('parents', ['marriage_id' => $mar->marriage_id, 'child_id !=' => $id])->result() as $sibling) {
                    $s[] = ['sibling_id' => $sibling->child_id, 'sibling_name' => $this->get($sibling->child_id)->individu_name];
                }
                $individu->siblings = $s;
            }
            //istri & anak
            $marriage = $this->db
                    ->where(['father_id' => $individu->individu_id])
                    ->or_where(['mother_id' => $individu->individu_id])
                    ->get('marriage');
            if ($marriage->num_rows() > 0) {
                //asumsi cuma nikah sekali
                $marriage = $marriage->row();
                $children = $this->db
                                ->join('individu', 'individu.individu_id=parents.child_id')
                                ->get_where('parents', ['marriage_id' => $marriage->marriage_id])->result();
                $c = [];
                foreach ($children as $child) {
                    $c[] = ['child_id' => $child->child_id, 'child_name' => $child->individu_name];
                }
                $individu->children = $c;
                if ($marriage->father_id == $id) {
                    $individu->wife = [
                        'wife_id' => $marriage->mother_id,
                        'wife_name' => $this->get($marriage->mother_id)->individu_name
                    ];
                } else {
                    $individu->wife = [
                        'wife_id' => $marriage->father_id,
                        'wife_name' => $this->get($marriage->father_id)->individu_name
                    ];
                }
            }
            //masjids
            $masjids = $this->db
                    ->select('masjid.masjid_id,name')
                    ->join('masjid', 'masjid.masjid_id=individu_masjid.masjid_id')
                    ->get_where('individu_masjid', ['individu_id' => $id]);
            if ($masjids->num_rows() > 0) {
                $m = [];
                foreach ($masjids->result() as $masjid) {
                    $m[] = ['masjid_id' => $masjid->masjid_id, 'name' => $masjid->name];
                }
                $individu->masjids = $m;
            }
            //pesantrens
            $schools = $this->db
                    ->select('school_id,name')
                    ->join('school', 'school.school_id=individu_pesantren.pesantren_id')
                    ->get_where('individu_pesantren', ['individu_id' => $id]);
            if ($schools->num_rows() > 0) {
                $m = [];
                foreach ($schools->result() as $school) {
                    $m[] = ['school_id' => $school->school_id, 'name' => $school->name];
                }
                $individu->schools = $m;
            }
            //network
            if(isset($individu->network)){
                $network = $this->db->get_where('net',['net_id'=>$individu->network])->row();
                $individu->network=[
                    'net_id'=>$network->net_id,
                    'net_name'=>$network->net_name
                ];
            }
            return $individu;
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
