<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class App_model extends CI_Model {

    function __construct() {
        parent :: __construct();
    }
	function insert($table, $data) {

        if ($this->db->insert($table, $data)) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    function getResultById($table, $where, $orderby = false, $limit = false) {
        if ($orderby) {
            $this->db->order_by($orderby, 'desc');
        }
        if ($limit) {
            $this->db->limit($limit);
        }
        $query = $this->db->get_where($table, $where);

        return $query->result_array();
    }

    function getRowById($table, $where , $join = false) {
        if($join) {
            $this->db->join('tbl_product_category' , 'tbl_product_category.category_id = '.$table.'.inventory_category','inner');
        }
        $query = $this->db->get_where($table, $where);
        return $query->row_array();
    }

    function update($table, $data, $where) {
        
        $this->db->update($table, $data, $where);
        $count = $this->db->affected_rows();
        return true;
        if ($count > 0) {
            return true;
        }
        return false;
    }

    function get_data($table, $join = false  , $orderby = false, $limit = false) {
        
        if ($orderby) {
            $this->db->order_by($orderby, 'desc');
        }
        if ($limit) {
            $this->db->limit($limit);
        }
        if ($join) {
            $this->db->join('tbl_product_category' , 'tbl_product_category.category_id = '.$table.'.inventory_category','left');
        }
        $query = $this->db->get($table);
        return $query->result_array();
    }

    function delete_row($table, $where) {
        $this->db->delete($table, $where);
        return true;
    }

    

    public function getLimitData($table, $limit) {
        $data = $this->db->get($table, $limit,0);
        return $data->result();
    }
}

?>