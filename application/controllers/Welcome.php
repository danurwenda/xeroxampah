<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function index() {
        echo 'hello';
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function migrate() {
        //connect to old db
        $config['hostname'] = 'localhost';
        $config['username'] = 'root';
        $config['password'] = 'sam4r1nda';
        $config['database'] = 'bakekonupd';
        $config['dbdriver'] = 'mysqli';
        $config['dbprefix'] = '';
        $config['pconnect'] = FALSE;
        $config['db_debug'] = TRUE;
        $config['cache_on'] = FALSE;
        $config['cachedir'] = '';
        $config['char_set'] = 'utf8';
        $config['dbcollat'] = 'utf8_general_ci';
        $mysql = $this->load->database($config, true);

        //connect to new db
        $pg = $this->load->database('default', true);

        $this->update5Juni10Juni($mysql, $pg);

//        echo 'all data with triggered threshold';
    }

    function update5Juni10Juni($mysql, $pg) {
        $inserted = [];
        foreach ($mysql->where('date >', '2015-06-05')->get('harian')->result() as $u) {
            $v = $this->parse_data($u, $pg);
            $inserted[] = $v;
        }
        $pg->insert_batch('data', $inserted);
    }

    public function dummy() {
        $this->load->model('threshold_model');
        $this->threshold_model->get_threshold_data([]);
    }

    private function load_data($o, $n) {
        //kita load data dari harian, mingguan, bulanan, semesteran, tahunan, triwulanan
        //semuanya kita kumpulkan ke tabel data
        $this->load_harian($o, $n);
//        $this->load_mingguan($o, $n);
//        $this->load_bulanan($o, $n);
//        $this->load_triwulanan($o, $n);
//        $this->load_semesteran($o, $n);
//        $this->load_tahunan($o, $n);
    }

    private function load_semesteran($o, $n) {
        //load dari tabel harian di db lama
        $harians = $o->get('semesteran')->result();
        $inserted = [];
        foreach ($harians as $h) {
            $inserted[] = $this->parse_data($h, $n);
        }
        $n->insert_batch('data', $inserted);
    }

    private function load_tahunan($o, $n) {
        //load dari tabel harian di db lama
        $harians = $o->get('tahunan')->result();
        $inserted = [];
        foreach ($harians as $h) {
            $inserted[] = $this->parse_data($h, $n);
        }
        $n->insert_batch('data', $inserted);
    }

    private function load_triwulanan($o, $n) {
        //load dari tabel harian di db lama
        $harians = $o->get('triwulanan')->result();
        $inserted = [];
        foreach ($harians as $h) {
            $inserted[] = $this->parse_data($h, $n);
        }
        $n->insert_batch('data', $inserted);
    }

    private function load_harian($o, $n) {
        //load dari tabel harian di db lama
        $harians = $o->get('harian')->result();
        $inserted = [];
        foreach ($harians as $h) {
//            $inserted[] = $this->parse_data($h, $n);
            $n->insert('data', $this->parse_data($h, $n));
        }
//        $n->insert_batch('data', $inserted);
    }

    private function load_mingguan($o, $n) {
        //load dari tabel harian di db lama
        $harians = $o->get('mingguan')->result();
        $inserted = [];
        foreach ($harians as $h) {
            $inserted[] = $this->parse_data($h, $n);
        }
        $n->insert_batch('data', $inserted);
    }

    private function load_bulanan($o, $n) {
        //load dari tabel harian di db lama
        $harians = $o->get('bulanan')->result();
        $inserted = [];
        foreach ($harians as $h) {
            $inserted[] = $this->parse_data($h, $n);
        }
        $n->insert_batch('data', $inserted);
    }

    private function parse_data($h, $n) {
        //ternyata ada data yang salah masuk harusnya masuk bulanan malah masuk ke harian
        //jadi kita cek format date nya kan formatnya Y-m-d
        //kalau sampai d=='00' itu berarti buat bulanan
        //kalau sampai m=='00' itu berarti buat tahunan
        list($y, $m, $d) = explode('-', $h->date);
        if ($d === '00') {
            $d = '01';
        }
        if ($m === '00') {
            $m = '01';
        }
        return [
            'indikator_id' => $n->get_where('indikator', array('code' => $h->desc_id))->row()->indikator_id,
            'date' => $y . '-' . $m . '-' . $d,
            'val' => $h->value
        ];
    }

    private function load_indikator($mysql, $pg) {
        //prefetch frekuensi
        $fs = [];
        foreach ($pg->get('frekuensi')->result() as $f) {
            $fs[$f->name] = $f->frekuensi_id;
        }
        //map indikator.code to indikator.indikator_id
        $indikators = array();
        //migrate mysql.description into pg.indikator
        //columns are mapped as follows
        //  mysql       |       pg
        //  id          |       code
        //  indikator   |       indikator_name
        //  satuan      |       unit
        //  sumber      |       source
        //  frekuensi   |       frekuensi
        //  imgname     |       imgname
        //  parent_id   |       parent_id
        $mysqldescriptions = $mysql->get('description')->result();
        $helddesc = [];
        set_time_limit(40000);
        while (count($mysqldescriptions) > 0) {
            foreach ($mysqldescriptions as $desc) {
                $held = false;
                //look for indikator_id of parent_id
                if (!empty($desc->parent_id)) {
                    //try to lookup
                    if (array_key_exists($desc->parent_id, $indikators)) {
                        $candidate_id = $indikators[$desc->parent_id];
                    } else {
                        //held
                        $held = true;
                        $helddesc[] = $desc;
                    }
                } else {
                    $candidate_id = null;
                }
                if (!$held) {
                    $pgindikator = ['code' => $desc->id,
                        'indikator_name' => $desc->indikator,
                        'unit' => (empty($desc->satuan) ? null : $desc->satuan),
                        'source' => (empty($desc->sumber) ? null : $desc->sumber),
                        'frekuensi' => (empty($desc->frekuensi) ? null : $fs[$desc->frekuensi]),
                        'imgname' => (empty($desc->imgname) ? null : $desc->imgname),
                        'parent_id' => $candidate_id
                    ];
                    //insert to db and to lookup array
                    $pg->insert('indikator', $pgindikator);
                    $indikators[$desc->id] = $pg->insert_id();
                }
            }
            $mysqldescriptions = $helddesc;
            $helddesc = [];
        }
    }

}
