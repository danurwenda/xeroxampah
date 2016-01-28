<?php

defined('BASEPATH')OR
        exit('No direct script access allowed');

/**
 * Model terkait table menu.
 *
 * @author Administrator
 */
class Menu_model extends CI_Model {

    public $table = 'menus';
    public $primary_key = 'menu_id';

    public function __construct() {
        parent::__construct();
    }

    public function get($menu_id) {
        $q = $this->db
                ->get_where($this->table, [$this->primary_key => $menu_id]);
        if ($q->num_rows() > 0) {
            return $q->row();
        } else {
            return null;
        }
    }

    /**
     * Return array of menus comprising all leaf indicator under this root.
     * @param type $root_id
     */
    public function get_leaves($root_id) {
        $children = $this->db
                ->select('menu_id')
                ->get_where($this->table, ['parent_menu' => $root_id]);
        if ($children->num_rows() == 0) {
            //recursion base
            return [$root_id];
        } else {
            //merge leaves from all children
            $ret = [];
            foreach ($children->result() as $c) {
                $ret = array_merge($ret, $this->get_leaves($c->menu_id));
            }
            return $ret;
        }
    }

    /**
     * TODO : ini kenapa ada di model? ini harusnya kan urusan view.
     * tapi kalau ini dihandle di view, pasti butuh akses ke model.
     * @param type $id, bisa menu_id atau an instance of Indikator object
     */
    public function create_breadcrumb($id, $is_strategic = false) {
        $bc = '';
        if (isset($id) && ($menu = is_object($id) ? $id : $this->get($id))) {
            //cek parent
            if (isset($menu->parent_menu) && ($parent = $this->get($menu->parent_menu))) {
                if (isset($parent->parent_menu) && ($gparent = $this->get($parent->parent_menu))) {
                    $bc .= $this->create_breadcrumb_li(anchor(empty($gparent->alias)?'dashboard/show/' . $gparent->menu_id:$gparent->alias, $gparent->display_name));
                }
                $bc .= $this->create_breadcrumb_li(anchor(empty($parent->alias)?'dashboard/show/' . $parent->menu_id:$parent->alias, $parent->display_name));
            }
            $bc.=$this->create_breadcrumb_li($menu->display_name);
        }
        return $bc;
    }

    public function create_breadcrumb_li($str) {
        return "<li>$str</li>";
    }

    /**
     * Returns hierarchical level of an indicator.
     * @param type $id
     */
    public function get_level($id) {
        $parent = $this->get($id)->parent_menu;
        if ($parent == null) {
            return 1;
        } else {
            return 1 + $this->get_level($parent);
        }
    }

    public function get_children($parent) {
        return $this->db
                        ->where('parent_menu', $parent)
                        ->order_by('menu_id')
                        ->get($this->table)
                        ->result();
    }

    /**
     * Dari dashboard yang lama, setiap menu punya code unik
     * @param type $code misalnya HP.0.1
     */
    public function get_by_code($code) {
        $res = $this->db->where('code', $code)->get($this->table);
        if ($res->num_rows() > 0) {
            return $res->row();
        } else
            return null;
    }

}
