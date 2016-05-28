<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Feedback extends CI_Controller {

    var $tbl_name1;
    var $tbl_name2;

    function __construct() {
        parent::__construct();
        $this->load->library("lib");
        $this->lib->auth_check(); //authentication check
        $this->load->model("admindbmodel");
        $this->tbl_name1 = "feedback";
        $id = $this->session->userdata('loged_user_id');
        $this->load->helper('text');
    }

    public function index() {
        $result = $this->admindbmodel->getFeedback();
        $data['allorders'] = $this->admindbmodel->fetch_all_data_result('orders');
        $json = array();
        $json['data'] = array();
        foreach ($result as $key => $val) {
            $view_btn = "<a href='#' title='View' class='view btn btn-primary btn-sm' data-toggle='modal' data-target='#myModal' data-value='" . $val['id'] . "'><i class='icon-search icon-white'></i>View</a> ";
            $delete_btn = "<a href='" . base_url('feedback/delete_data/' . $val['id']) . "' title='Delete' class='delete btn  btn-danger btn-sm'><i class='icon-trash icon-white'></i>Delete</a>";
            $edit_btn = "<a href='" . base_url('feedback/edit/' . $val['id']) . "' title='Edit' class='btn btn-sm btn-info' ><i class='icon-edit icon-white'></i>Edit</a> ";
            $Cdate = date('j\<\s\u\p\>S\<\/\s\u\p\> M Y h:i a', strtotime($val['insert_date']));
            $json['data'][$key]['user_name'] = $val['user_name'];
            $json['data'][$key]['user_contact_number'] = $val['user_contact_number'];
            $json['data'][$key]['distributor_name'] = $val['distributor_name'];
            $json['data'][$key]['distributor_contact_number'] = $val['distributor_contact_number'];
            $json['data'][$key]['order_id'] = $val['id'];
            $json['data'][$key]['feedback_msg'] = $val['feedback_msg'];
            $json['data'][$key]['rating'] = $val['rating'];
            $json['data'][$key]['createdDate'] = $Cdate;
            $json['data'][$key]['action'] = $delete_btn;
        }
        $data['title'] = "Feedback management";
        $data['main_content'] = 'feedback/list';
        $data['datainfo'] = json_encode($json);
        $this->load->view('template', $data);
    }

//    view modal
    public function view() {
        $dataValue = $this->admindbmodel->fetch_data_con_result($_POST['postID'], 'id', 'feedback');
        $insert_date = date('Y-m-d h:i a', strtotime($dataValue[0]->insert_date));
        $html = ' <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">' . $dataValue[0]->area_name_english . '</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="modal-field text-align-none">
             English Name : ' . $dataValue[0]->area_name_english . '
          </div>
          <div class="modal-field text-align-none">
             Arabic Name : ' . $dataValue[0]->area_name_arabic . '
          </div>
          <div class="modal-field text-align-none">
             Added Date : ' . $insert_date . '
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>';
        echo $html;
    }

    /* Delete Data */

    public function delete_data($id) {
        if ($checkAnsIs = $this->admindbmodel->deleteDataOneCon($id, 'id', $this->tbl_name1) == true) {
            $result = 1; //Delete Success
        } else {

            $result = 2; //system Error.Please Contact with Developer
        }

        echo $result;
        exit;
    }

    /* update status */

    public function update_status($id, $status) {
        if ($status == 0) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }
        $fieldName = 'id';
        $result = $this->admindbmodel->update_data_con($data, $id, $fieldName, 'users');
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
        die();
    }

    public function add() {
        $data['title'] = 'Add New';
        $data['main_content'] = 'feedback/add';
        $data['cityValue'] = $this->admindbmodel->fetch_all_data_result('cities');
        $this->form_validation->set_rules('area_name_english', 'English Name', 'strip_tags|trim|required|is_unique[feedback.area_name_english]');
        $this->form_validation->set_rules('city_id', 'City', 'strip_tags|trim|required');
        if ($this->form_validation->run() != FALSE) {
            $insert_data['insert_date'] = date('Y-m-d H:i:s');
            $insert_data['area_name_english'] = $this->input->post('area_name_english');
            $insert_data['area_name_arabic'] = $this->input->post('area_name_arabic');
            $insert_data['city_id'] = $this->input->post('city_id');
            if ($this->admindbmodel->set_data($insert_data, 'feedback') == TRUE) {
                $data['successMsg'] = 'Successfully Added';
                $this->load->view('template', $data);
            } else {
                $data['errorMsg'] = 'System Error.Please Contact With Developer.';
                $this->load->view('template', $data);
            }
        } else {
            $this->load->view('template', $data);
        }
    }

    public function edit($id) {
        $data['dataValue'] = $this->admindbmodel->fetch_data_con_result($id, 'id', $this->tbl_name1);
        $data['cityValue'] = $this->admindbmodel->fetch_all_data_result('cities');
        $data['title'] = 'Edit Area';
        $data['main_content'] = 'feedback/edit';
        $this->form_validation->set_rules('area_name_english', 'English Name', 'strip_tags|trim|required');
        $this->form_validation->set_rules('city_id', 'City', 'strip_tags|trim|required');
        if ($this->form_validation->run() != FALSE) {
            $updateData['area_name_english'] = $this->input->post('area_name_english');
            $updateData['area_name_arabic'] = $this->input->post('area_name_arabic');
            $updateData['city_id'] = $this->input->post('city_id');
            if ($this->admindbmodel->update_data_con($updateData, $id, 'id', $this->tbl_name1) == TRUE) {
                $data['successMsg'] = 'Successfully Updated';
                $this->load->view('template', $data);
            } else {
                $data['errorMsg'] = 'System Error.Please Let Us Know.';
                $this->load->view('template', $data);
            }
        } else {
            $this->load->view('template', $data);
        }
    }

//check availabity by category english name
    public function recheck_availabity_by_englishname($name) {
        $id = $this->uri->segment(3);
        if ($this->admindbmodel->recheckAvailabiltyWithTitleId($name, $id, 'englishName', 'operatorID', $this->tbl_name1) > 0) {
            $this->form_validation->set_message('recheck_availabity_by_englishname', 'This Title is already assigned by other!');
            return FALSE;
        } else {
            return true;
        }
    }

    //    image validation
    public function imageValidation() {
        $allow_ext = array('jpg', 'gif', 'png', 'bmp', 'jpeg');
        if (trim($_FILES["imagefile"]["name"]) == "") {
            $this->form_validation->set_message('imageValidation', 'Can Not Be empty');
            return FALSE;
        } else if (!in_array(end(explode('.', trim($_FILES["imagefile"]["name"]))), $allow_ext)) {
            $this->form_validation->set_message('imageValidation', 'Image Must be jpg, gif, png, bmp or jpeg');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
