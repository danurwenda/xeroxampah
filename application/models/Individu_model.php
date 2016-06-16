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
    private $sequence = 'individu_individu_id_seq';

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
            //file BAP
            $bap = [];
            foreach ($this->db->get_where('bap',['individu_id'=>$id])->result() as $baps) {
                $bap[] = $baps->filename;
            }
            $individu->bap = $bap;
            //add relation
            //FAMILY
            //ayah & ibu
            //edge 46 & edge 47
            $ayah = $this->db
                    ->get_where('edge', ['target_id' => $id, 'weight_id' => 46]);
            if ($ayah->num_rows() > 0) {
                $individu->father = $ayah->row()->source_id;
            }
            $ibu = $this->db
                    ->get_where('edge', ['target_id' => $id, 'weight_id' => 47]);
            if ($ibu->num_rows() > 0) {
                $individu->mother = $ibu->row()->source_id;
            }
            //saudara
            $saudara = [];
            foreach ($this->db
                    ->get_where('edge', ['source_id' => $id, 'weight_id' => 48])
                    ->result() as $saudaras) {
                $saudara[] = $saudaras->target_id;
            }
            foreach ($this->db
                    ->get_where('edge', ['target_id' => $id, 'weight_id' => 48])
                    ->result() as $saudaras) {
                $saudara[] = $saudaras->source_id;
            }
            $individu->saudara = $saudara;
            //pasangan
            $pasangan = [];
            foreach ($this->db
                    ->get_where('edge', ['source_id' => $id, 'weight_id' => 49])
                    ->result() as $pasangans) {
                $pasangan[] = ['pasangan' => $pasangans->target_id, 'prop' => $pasangans->properties];
            }
            $individu->pasangan = $pasangan;
            //anak
            $anak = [];
            foreach ($this->db
                    ->get_where('edge', ['source_id' => $id, 'weight_id' => 50])
                    ->result() as $anaks) {
                $anak[] = $anaks->target_id;
            }
            $individu->anak = $anak;
            //LEMBAGA PENDIDIKAN
            $pendidikan = [];
            foreach ($this->db
                    ->join('edge_weight', 'edge_weight.weight_id=edge.weight_id')
                    ->get_where('edge', ['source_id' => $id, 'type' => 3])
                    ->result() as $anaks) {
                $pendidikan[] = ['prop' => $anaks->properties, 'target' => $anaks->target_id, 'weight' => $anaks->weight_id];
            }
            $individu->pendidikan = $pendidikan;
            //ORGANISASI
            $organisasi = [];
            foreach ($this->db
                    ->join('edge_weight', 'edge_weight.weight_id=edge.weight_id')
                    ->get_where('edge', ['source_id' => $id, 'type' => 2])
                    ->result() as $anaks) {
                $organisasi[] = ['prop' => $anaks->properties, 'target' => $anaks->target_id, 'weight' => $anaks->weight_id];
            }
            $individu->organisasi = $organisasi;
            //LAPAS
            $lapas = [];
            foreach ($this->db
                    ->join('edge_weight', 'edge_weight.weight_id=edge.weight_id')
                    ->get_where('edge', ['source_id' => $id, 'type' => 12])
                    ->result() as $anaks) {
                $lapas[] = ['prop' => $anaks->properties, 'target' => $anaks->target_id, 'weight' => $anaks->weight_id];
            }
            $individu->lapas = $lapas;
            //LATSEN
            $latsen = [];
            foreach ($this->db
                    ->join('edge_weight', 'edge_weight.weight_id=edge.weight_id')
                    ->get_where('edge', ['source_id' => $id, 'type' => 8])
                    ->result() as $anaks) {
                $latsen[] = ['prop' => $anaks->properties, 'target' => $anaks->target_id, 'weight' => $anaks->weight_id];
            }
            $individu->latsen = $latsen;
            //LATIHAN
            $latihan = [];
            foreach ($this->db
                    ->join('edge_weight', 'edge_weight.weight_id=edge.weight_id')
                    ->get_where('edge', ['source_id' => $id, 'type' => 11])
                    ->result() as $anaks) {
                $latihan[] = ['prop' => $anaks->properties, 'target' => $anaks->target_id, 'weight' => $anaks->weight_id];
            }
            $individu->latihan = $latihan;
            //TEROR
            $teror = [];
            foreach ($this->db
                    ->join('edge_weight', 'edge_weight.weight_id=edge.weight_id')
                    ->get_where('edge', ['source_id' => $id, 'type' => 6])
                    ->result() as $anaks) {
                $teror[] = ['prop' => $anaks->properties, 'target' => $anaks->target_id, 'weight' => $anaks->weight_id];
            }
            $individu->teror = $teror;
            //NONTEROR
            $nonteror = [];
            foreach ($this->db
                    ->join('edge_weight', 'edge_weight.weight_id=edge.weight_id')
                    ->get_where('edge', ['source_id' => $id, 'type' => 7])
                    ->result() as $anaks) {
                $nonteror[] = ['prop' => $anaks->properties, 'target' => $anaks->target_id, 'weight' => $anaks->weight_id];
            }
            $individu->nonteror = $nonteror;
            //PENGAJIAN
            $pengajian = [];
            foreach ($this->db
                    ->join('edge_weight', 'edge_weight.weight_id=edge.weight_id')
                    ->get_where('edge', ['source_id' => $id, 'type' => 9])
                    ->result() as $anaks) {
                $pengajian[] = ['prop' => $anaks->properties, 'target' => $anaks->target_id, 'weight' => $anaks->weight_id];
            }
            $individu->pengajian = $pengajian;


            return $individu;
        } else {
            return null;
        }
    }

    public function delete($id) {
        return $this->db->delete($this->table, [$this->primary_key => $id]);
    }

    public function update($id, $data) {
        return $this->db->update(
                        $this->table, $data, [$this->primary_key => $id]
        );
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->last_id();
    }

    private function last_id() {
        return $this->db->insert_id($this->sequence);
    }

    public function neo4j_insert_query($id) {
        $prop = "individu_name:'" . addslashes($this->get($id)->individu_name) . "',";
        $prop.="individu_id:" . $id;
        return "MERGE(Individu$id:Individu { $prop } )";
    }

    public function neo4j_delete_query($id) {
        return "match(n:Individu{individu_id:$id})detach delete n";
    }

    public function neo4j_update_query($id, $nama) {
        return "match(n:Individu{individu_id:$id})set n.individu_name='" . addslashes($nama)
                . "' return n";
    }

}
