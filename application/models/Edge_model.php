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

    public function insert($source, $target, $edge, $json) {
        $this->db->insert($this->table, [
            'source_id' => $source,
            'target_id' => $target,
            'weight_id' => $edge,
            'properties' => $json
        ]);
        return $this->last_id();
    }

    private function last_id() {
        return $this->db->insert_id($this->sequence);
    }

    public function neo4j_insert_query($id) {
        $edge = $this->get($id);
        //pertama2 kita cek apa tipe edge ini
        $edge_weight = $this->db->get_where('edge_weight', ['edge_id' => $edge->weight_id])->row();
        $label_edge = preg_replace('/\s+/', '', $edge_weight->desc);
        $label_edge = preg_replace('/[.,\/#!$%\^&\*;:{}=\-_`~()]/', '', $label_edge);
        //convert edge->prop yang tipe JSON ke format key:value mapping
        $json = $edge->properties;
        if (!empty($json))
            $label_prop = jsonToNeo4J($json);
        else
            $label_prop = '';
        $create_clause="create (a)-[:$label_edge { $label_prop }]->(b)";
        switch ($edge_weight->type) {
            case 1:
                //individu-individu
                return "match (a:Individu{individu_id:$edge->source_id}),(b:Individu{individu_id:$edge->target_id}) $create_clause";
                break;
            case 2:
                //individu-organisasi
                return "match (a:Individu{individu_id:$edge->source_id}),(b:Organisasi{org_id:$edge->target_id}) $create_clause";
            default:
            case 3:
                //individu-sekolah
                return "match (a:Individu{individu_id:$edge->source_id}),(b:Sekolah{school_id:$edge->target_id}) $create_clause";
            default:
            case 6:
                //individu-teror
                return "match (a:Individu{individu_id:$edge->source_id}),(b:Teror{teror_id:$edge->target_id}) $create_clause";
            default:
            case 7:
                //individu-nonteror
                return "match (a:Individu{individu_id:$edge->source_id}),(b:Nonteror{nonteror_id:$edge->target_id}) $create_clause";
            default:
                break;
        }
    }

    public function insert_or_lookup($org_id) {
        $oid = null;
        if (is_numeric($org_id)) {
            //lookup
            //check db
            $org = $this->db->get_where('organization', ['org_id' => $org_id]);
            if ($org->num_rows() > 0) {
                //ada
                $oid = $org->row()->org_id;
            }
        } else {
            //raw name, insert into organization
            $this->db->insert('organization', ['org_name' => $org_id]);
            $oid = $this->db->insert_id('organization_org_id_seq');
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

    public function update($id, $org_name, $address, $website, $email, $phone, $description, $source) {
        return $this->db->update(
                        $this->table, array(
                    'org_name' => $org_name,
                    'address' => $address,
                    'website' => $website,
                    'email' => $email,
                    'phone' => $phone,
                    'description' => $description,
                    'source_id' => $source
                        ), [$this->primary_key => $id]
        );
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
