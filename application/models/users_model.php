<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class users_model extends CI_Model {

    //get all user form user list
    function get_users($param) {
        if ($param['limit'] != '') {
            $this->db->limit($param['limit'], $param['offset']);
        }
        if ($param['search'] != '') {
            $this->db->like('username', $param['search']);
        }
        $this->db->order_by($param['sorting'], $param['sorting_dir']);
        $query = $this->db->get('users');
        $result_data = $query->result_array();
        if ($param['search'] != '') {
            $this->db->like('username', $param['search']);
        }
        $query_count = $this->db->get("users");
        $total_rows = $query_count->num_rows();
        $result = array('total_rows' => $total_rows, 'problems_data' => $result_data);
        return $result;
    }


}
