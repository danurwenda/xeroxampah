<?php

defined('BASEPATH')OR
        exit('No direct script access allowed');

/**
 * Model terkait table menu.
 *
 * @author Administrator
 */
class Edge_model extends CI_Model {

    private $table = 'edge';
    private $primary_key = 'edge_id';
    private $sequence = 'edge_edge_id_seq';

    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    public function insert($source, $target, $edge, $json) {
        $this->db->insert($this->table, [
            'source_id' => $source,
            'target_id' => $target,
            'weight_id' => $edge,
            'properties' => $json
        ]);
        return $this->last_id();
    }

    /**
     * Note that we can't change edge's type (weight_id)
     * @param type $edge_id
     * @param type $source
     * @param type $target
     * @param type $json
     */
    public function update($edge_id, $source, $target, $json) {
        return $this->db->update($this->table, ['source_id' => $source, 'target_id' => $target, 'properties' => $json], ['edge_id' => $edge_id]);
    }

    public function neo4j_update_query($id) {
        //updated state ini bisa berubah di prop nya doank
        //bisa juga berubah di startnode/endnode
        //intinya kita harus hapus di neo dengan $id
        //kemudian bikin relationship baru dengan $id yang sama
        //dengan prosedur seperti ini, update di SQL harus dilakukan
        //SEBELUM memanggil fungsi ini
        return [
            $this->neo4j_delete_query($id),
            $this->neo4j_insert_query($id)
        ];
    }

    private function last_id() {
        return $this->db->insert_id($this->sequence);
    }

    public function neo4j_insert_query($id) {
        $edge = $this->get($id);
        //pertama2 kita cek apa tipe edge ini
        $edge_weight = $this->db->get_where('edge_weight', ['weight_id' => $edge->weight_id])->row();
        $label_edge = preg_replace('/\s+/', '', $edge_weight->desc);
        $label_edge = preg_replace('/[\'\/.,\/#!$%\^&\*;:{}=\-_`~()]/', '', $label_edge);
        //convert edge->prop yang tipe JSON ke format key:value mapping
        $json = $edge->properties;
        if (!empty($json))
            $label_prop = jsonToNeo4J($json);
        else
            $label_prop = '';
        if(!empty($label_prop))$label_prop=','.$label_prop;
        $create_clause = "create (a)-[:$label_edge {edge_id:$id $label_prop }]->(b)";
        switch ($edge_weight->type) {
            case 1:
                //individu-individu
                return "match (a:Individu{individu_id:$edge->source_id}),(b:Individu{individu_id:$edge->target_id}) $create_clause";
                break;
            case 2:
                //individu-organisasi
                return "match (a:Individu{individu_id:$edge->source_id}),(b:Organisasi{organisasi_id:$edge->target_id}) $create_clause";
            case 3:
                //individu-school
                return "match (a:Individu{individu_id:$edge->source_id}),(b:School{school_id:$edge->target_id}) $create_clause";
            case 6:
                //individu-teror
                return "match (a:Individu{individu_id:$edge->source_id}),(b:Teror{teror_id:$edge->target_id}) $create_clause";
            case 7:
                //individu-nonteror
                return "match (a:Individu{individu_id:$edge->source_id}),(b:Nonteror{nonteror_id:$edge->target_id}) $create_clause";
            case 9:
                //individu-pengajian
                return "match (a:Individu{individu_id:$edge->source_id}),(b:Pengajian{pengajian_id:$edge->target_id}) $create_clause";
            case 12:
                //individu-pengajian
                return "match (a:Individu{individu_id:$edge->source_id}),(b:Lapas{lapas_id:$edge->target_id}) $create_clause";
            case 8:
                //individu-latihan militer senjata
                return "match (a:Individu{individu_id:$edge->source_id}),(b:Latsen{latsen_id:$edge->target_id}) $create_clause";
            case 11:
                //individu-latihan militer non senjata
                return "match (a:Individu{individu_id:$edge->source_id}),(b:Latihan{latihan_id:$edge->target_id}) $create_clause";
            default:
                break;
        }
    }

    public function insert_or_lookup($organisasi_id) {
        $oid = null;
        if (is_numeric($organisasi_id)) {
            //lookup
            //check db
            $org = $this->db->get_where('organisasi', ['organisasi_id' => $organisasi_id]);
            if ($org->num_rows() > 0) {
                //ada
                $oid = $org->row()->organisasi_id;
            }
        } else {
            //raw name, insert into organisasi
            $this->db->insert('organisasi', ['org_name' => $organisasi_id]);
            $oid = $this->db->insert_id('organisasi_organisasi_id_seq');
        }
        return $oid;
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

    /**
     * Delete edge ini, match relationship dari node X ke node Y dengan label Z
     * @param type $id
     */
    public function neo4j_delete_query($id) {
        return "match ()-[r{edge_id:$id}]->() delete r";
    }

    public function create($org_name, $address, $website, $email, $phone, $description, $source) {
        return $this->db->insert(
                        $this->table, array(
                    'org_name' => $org_name,
                    'address' => $address,
                    'website' => $website,
                    'email' => $email,
                    'phone' => $phone,
                    'description' => $description,
                    'source_id' => $source
                        )
        );
    }

}
