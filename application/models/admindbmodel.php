<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class admindbmodel extends CI_Model {
    /*
     * Select with Condition 1 
     * parameter query start
     */

    function fetch_data_con_result($colVal, $colName, $tblName) {
        $this->db->where($colName, $colVal);
        $query = $this->db->get($tblName);
        $result = $query->result();
        return $result;
    }

    /*
     * Select all data
     * parameter query start
     */

    function fetch_all_data_result($tblName) {
        $query = $this->db->get($tblName);
        $result = $query->result();
        return $result;
    }

    /* update data with Condition start */

    function update_data_con($update_data, $colVal, $colName, $tbl_name) {
        $this->db->where($colName, $colVal);
        $result = $this->db->update($tbl_name, $update_data);
        return $result;
    }

    /* update data with no Condition start */

    function update_data($update_data, $tbl_name) {
        $result = $this->db->update($tbl_name, $update_data);
        return $result;
    }

    /*
     * Select with Condition 1 
     * parameter query start
     */

    function fetch_data_con_row($colVal, $colName, $tblName) {
        $this->db->where($colName, $colVal);
        $query = $this->db->get($tblName);
        $result = $query->num_rows();
        return $result;
    }

    /* Select with Condition 2 where status is active
     * parameter query start
     */

    function fetch_data_two_con($firstColVal, $secondColVal, $firstColName, $secondColName, $tblName) {
        $this->db->where($firstColName, $firstColVal);
        $this->db->where($secondColName, $secondColVal);
        $query = $this->db->get($tblName);
        $result = $query->result();
        return $result;
    }

    /* Select with Condition 2 where status is active
     * parameter query start
     */

    function fetch_data_three_con($firstColVal, $secondColVal, $thirdColVal, $firstColName, $secondColName, $thirdColName, $tblName) {
        $this->db->where($firstColName, $firstColVal);
        $this->db->where($secondColName, $secondColVal);
        $this->db->where($thirdColName,$thirdColVal);
        $query = $this->db->get($tblName);
        $result = $query->result();
        return $result;
    }
 //    return last insert id
    function insertReturnLastId($insert_data, $tbl_name) {
        $this->db->insert($tbl_name, $insert_data);
        $result = $this->db->insert_id();
        return $result;
    }
    /*
     * insert query start
     */

    function set_data($insert_data, $tbl_name) {
        $result = $this->db->insert($tbl_name, $insert_data);
        return $result;
    }

    //check when update by title
    function recheckAvailabiltyWithTitleId($firstColVal, $secondColVal, $firstColName, $secondColName, $tbl_name) {
        $this->db->select('id');
        $this->db->where($firstColName, $firstColVal);
        $this->db->where($secondColName, $secondColVal);
        $this->db->from($tbl_name);
        $query = $this->db->get();
        $result = $query->num_rows();
        return $result;
    }

    /* delete data with condition start */

    function deleteDataTwoCon($firstColVal, $secondColVal, $firstColName, $secondColName, $tbl_name) {
        $this->db->where($firstColName, $firstColVal);
        $this->db->where($secondColName, $secondColVal);
        $result = $this->db->delete($tbl_name);
        return $result;
    }

    /* delete data with condition start */

    function deleteDataOneCon($firstColVal, $firstColName, $tbl_name) {
        $this->db->where($firstColName, $firstColVal);
        $result = $this->db->delete($tbl_name);
        return $result;
    }

    //get all all area list from areas table 
    function getAreaData($param) {
        if ($param['limit'] != '') {
            $this->db->limit($param['limit'], $param['offset']);
        }
        if ($param['search'] != '') {
            $this->db->like('area_name_english', $param['search']);
        }
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('areas');
        $result_data = $query->result_array();

        if ($param['search'] != '') {
            $this->db->or_like('area_name_english', $param['search']);
        }
        $this->db->order_by('id', 'DESC');
        $this->db->from('areas');
        $query_count = $this->db->get();
        $total_rows = $query_count->num_rows();
        $result = array('total_rows' => $total_rows, 'result_data' => $result_data);
        return $result;
    }
    //get all  cities list from cities table 
    function getCityData($param) {
        if ($param['limit'] != '') {
            $this->db->limit($param['limit'], $param['offset']);
        }
        if ($param['search'] != '') {
            $this->db->like('city_name_english', $param['search']);
        }
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('cities');
        $result_data = $query->result_array();

        if ($param['search'] != '') {
            $this->db->or_like('city_name_english', $param['search']);
        }
        $this->db->order_by('id', 'DESC');
        $this->db->from('cities');
        $query_count = $this->db->get();
        $total_rows = $query_count->num_rows();
        $result = array('total_rows' => $total_rows, 'result_data' => $result_data);
        return $result;
    }
     

    //get all areas from  table 
    function getAreaInfoWithCity() {
        $this->db->select('a.*,b.city_name_english');
        $this->db->order_by('a.id', 'DESC');
        $this->db->from('areas a');
        $this->db->join('cities b', 'b.id = a.city_id');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    //get all distributors  list from distributors table
    function getDistributorData() {
        $this->db->select('a.*,b.city_name_english');
        $this->db->order_by('a.id', 'DESC');
        $this->db->from('distributors a');
        $this->db->join('cities b', 'b.id = a.city_id');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    //get all users from  users table 
    function getUsersWithArea() {
        $this->db->select('a.*,b.area_name_english');
        $this->db->order_by('a.id', 'DESC');
        $this->db->from('users a');
        $this->db->join('areas b', 'b.id = a.area');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    //get all orders from  orders table 
    function getOrderDetails() {
        $sql = "SELECT a.*,(a.product_amount*d.price) total_price, b.name user_name,"
                . "b.contact_number user_contact_number,e.city_name_english,f.area_name_english,"
                . "d.name product_name,d.price product_unit_price FROM orders a "
                . "LEFT JOIN users b ON b.id = a.user_id "
                . "LEFT JOIN cities e ON e.id = b.city_id "
                . "LEFT JOIN areas f ON f.id = b.area "
                . "LEFT JOIN products d ON d.id = a.product_id ORDER BY a.id DESC";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
    //get  orders details by order id from  orders table 
    function getOrderDetailsByOrderId($order_id) {
        $sql = "SELECT a.*,(a.product_amount*d.price) total_price, b.name user_name,"
                . "b.contact_number user_contact_number,e.id city_id,e.city_name_english,f.area_name_english,f.id area_id, "
                . "d.name product_name,d.price product_unit_price FROM orders a "
                . "LEFT JOIN users b ON b.id = a.user_id "
                . "LEFT JOIN cities e ON e.id = b.city_id "
                . "LEFT JOIN areas f ON f.id = b.area "
                . "LEFT JOIN products d ON d.id = a.product_id WHERE a.id = $order_id ORDER BY a.id DESC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    //get  feddback details all from  feedback table 
    function getFeedback() {
        $sql = "SELECT a.*, b.name user_name,b.contact_number user_contact_number, "
                . "c.name distributor_name,c.contact_number distributor_contact_number FROM feedback a "
                . "LEFT JOIN users b ON b.id = a.user_id "
                . "LEFT JOIN orders x ON x.id = a.order_id "
                . "LEFT JOIN distributors c ON c.id = x.distributor_id "
                . "WHERE (x.status = 1 OR x.status = 2) ORDER BY a.id DESC";
        
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
    //get  prefrred distributor details by user id
    function preferredDistributorDetails($user_id) {
        $sql = "SELECT a.*, b.name dist_name,b.id dist_id FROM preferred_distributors a "
                . "LEFT JOIN distributors b ON b.id = a.distributor_id "
                . "WHERE a.user_id = $user_id";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    //get  users by user id from  users table 
    function getUsersWithAreaByUserId($user_id) {
        $this->db->select('a.*,b.area_name_english');
        $this->db->order_by('a.id', 'DESC');
        $this->db->where('a.id', $user_id);
        $this->db->from('users a');
        $this->db->join('areas b', 'b.id = a.area');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    //get  distributors by area id 
    function getDistributrosByAreaId($area_id) {
        $query = $this->db->get('distributors');
        $result = $query->result();
        if($result){
            $i = 0;
            foreach($result as $distArea){
                if(in_array($area_id,  json_decode($distArea->area))){
                    $result['data'][$i]['dist_id'] = $distArea->id;
                    $result['data'][$i]['dist_name'] = $distArea->name;
                    $i++;
                }
            }
            
        }
        if($i==0){
            $result['data'] = array();
        }
        return $result;
    }

    public function viewAreaLisByCityId($id) {
        $this->db->select('a.*,b.city_name_english');
        $this->db->join('cities b', 'b.id = a.city_id', 'left');
        $this->db->where('a.city_id', $id);
        $this->db->from('areas a');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
     function check_userrecheck($name, $id, $title, $tbl_name) {
        $sql = "SELECT id FROM $tbl_name where $title='$name' AND id!='$id'";
        $query = $this->db->query($sql);
        $result = $query->num_rows();
        //print_r($result);exit;
        return $result;
    }

}
