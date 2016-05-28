<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products extends CI_Controller {

    var $tbl_name1;
    var $tbl_name2;

    function __construct() {
        parent::__construct();
        $this->load->library("lib");
        $this->lib->auth_check(); //authentication check
        $this->load->model("admindbmodel");
        $this->tbl_name1 = "products";
        $id = $this->session->userdata('loged_user_id');
        $this->load->helper('text');
    }

    public function index() {
        $result = $this->admindbmodel->fetch_all_data_result('products');
        $json = array();
        $json['data'] = array();
        foreach ($result as $key => $val) {
            $view_btn = "<a href='#' title='View' class='view btn btn-primary btn-sm' data-toggle='modal' data-target='#myModal' data-value='" . $val->id . "'><i class='icon-search icon-white'></i>View</a> ";
            $delete_btn = "<a href='" . base_url('products/delete_data/' . $val->id) . "' title='Delete' class='delete btn  btn-danger btn-sm'><i class='icon-trash icon-white'></i>Delete</a>";
            $edit_btn = "<a href='" . base_url('products/edit/' . $val->id) . "' title='Edit' class='btn btn-sm btn-info' ><i class='icon-edit icon-white'></i>Edit</a> ";
            $Cdate = date('j\<\s\u\p\>S\<\/\s\u\p\> M Y h:i a', strtotime($val->insert_date));
            $json['data'][$key]['name'] = $val->name;
            $json['data'][$key]['quantity'] = $val->quantity;
            $json['data'][$key]['sold_quantity'] = $val->sold_quantity;
            $json['data'][$key]['price'] = $val->price;
            $json['data'][$key]['createdDate'] = $Cdate;
            $json['data'][$key]['action'] = $view_btn . $edit_btn . $delete_btn;
        }
        $data['title'] = "Products management";
        $data['main_content'] = 'products/list';
        $data['datainfo'] = json_encode($json);
        $this->load->view('template', $data);
    }

//    view modal
    public function view() {
        $dataValue = $this->admindbmodel->fetch_data_con_result($_POST['postID'], 'id', 'products');
        $insert_date = date('Y-m-d h:i a', strtotime($dataValue[0]->insert_date));
        $html = ' <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">' . $dataValue[0]->name . '</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="modal-field text-align-none">
            Name : ' . $dataValue[0]->name . '
          </div>
          <div class="modal-field text-align-none">
             Quantity : ' . $dataValue[0]->quantity . '
          </div>
          <div class="modal-field text-align-none">
             Sold Quantity : ' . $dataValue[0]->sold_quantity . '
          </div>
          <div class="modal-field text-align-none">
             Availabe Quantity : ' . ($dataValue[0]->quantity - $dataValue[0]->sold_quantity) . '
          </div>
          <div class="modal-field text-align-none">
             Price : ' . $dataValue[0]->price . '
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
        $data['main_content'] = 'products/add';
        $this->form_validation->set_rules('name', 'English Name', 'strip_tags|trim|required');
        $this->form_validation->set_rules('quantity', 'Quantity', 'strip_tags|trim|required');
        $this->form_validation->set_rules('price', 'Price', 'strip_tags|trim|required');
        if ($this->form_validation->run() != FALSE) {
            $insert_data['insert_date'] = date('Y-m-d H:i:s');
            $insert_data['name'] = $this->input->post('name');
            $insert_data['quantity'] = $this->input->post('quantity');
            $insert_data['price'] = $this->input->post('price');
            if ($this->admindbmodel->set_data($insert_data, 'products') == TRUE) {
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
        $data['title'] = 'Edit Products';
        $data['main_content'] = 'products/edit';
        $this->form_validation->set_rules('name', 'Product Name', 'strip_tags|trim|required');
        $this->form_validation->set_rules('quantity', 'Product Quantity', 'strip_tags|trim|required');
        $this->form_validation->set_rules('price', 'Product Price', 'strip_tags|trim|required');
        if ($this->form_validation->run() != FALSE) {
            $updateData['name'] = $this->input->post('name');
            $updateData['quantity'] = $this->input->post('quantity');
            $updateData['price'] = $this->input->post('price');
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
