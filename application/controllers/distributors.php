<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Distributors extends CI_Controller {

    var $tbl_name1;
    var $tbl_name2;

    function __construct() {
        parent::__construct();
        $this->load->library("lib");
        $this->lib->auth_check(); //authentication check
        $this->load->model("admindbmodel");
        $this->tbl_name1 = "distributors";
        $id = $this->session->userdata('loged_user_id');
        $this->load->helper('text');
    }

    public function index() {

        $result = $this->admindbmodel->getDistributorData();
        $data['allcities'] = $this->admindbmodel->fetch_all_data_result('cities');
        $json = array();
        $json['data']=array();
        if ($result) {
            foreach ($result as $key => $val) {
                $totalAreas = "<span class='areaview label label-info category-action' data-toggle='modal' data-target='#myModal' data-json='" . $val['area'] . "' data-value='" . $val['id'] . "'>" . count(json_decode($val['area'])) . "</span>";
                if ($val['status'] == 1) {
                    $status_change_btn = "<span class='label label-success'>Active</span> &nbsp; ";
                } else {
                    $status_change_btn = "<span class='label label-danger'>Inactive</span> &nbsp; ";
                }
                $orders = count($this->admindbmodel->fetch_data_con_result($val['id'], 'distributor_id', 'orders'));
                $view_btn = "<a href='#' title='View' class='view btn btn-primary btn-sm' data-toggle='modal' data-target='#myModal' data-value='" . $val['id'] . "'><i class='icon-search icon-white'></i>View</a> ";
                $delete_btn = "<a href='" . base_url('distributors/delete_data/' . $val['id']) . "' title='Delete' class='delete btn  btn-danger btn-sm'><i class='icon-trash icon-white'></i>Delete</a>";
                $edit_btn = "<a href='" . base_url('distributors/edit/' . $val['id']) . "' title='Edit' class='btn btn-sm btn-info' ><i class='icon-edit icon-white'></i>Edit</a> ";
                $Cdate = date('j\<\s\u\p\>S\<\/\s\u\p\> M Y h:i a', strtotime($val['insert_date']));
                $json['data'][$key]['id'] = $val["id"];
                $json['data'][$key]['name'] = $val['name'];
                $json['data'][$key]['contact_number'] = $val['contact_number'];
                $json['data'][$key]['city_name'] = $val['city_name_english'];
                $json['data'][$key]['area'] = "<a href='#'" . $totalAreas . "</a>";
                $json['data'][$key]['orders'] = $orders;
                $json['data'][$key]['status'] = $status_change_btn;
                $json['data'][$key]['created_date'] = $Cdate;
                $json['data'][$key]['action'] = $view_btn . $edit_btn . $delete_btn;
            }
        }

        $data['title'] = "Distributor management";
        $data['datainfo'] = json_encode($json);
        $data['main_content'] = 'distributors/list';
        $this->load->view('template', $data);
    }

    //    view modal area
    public function areaview() {
        $areas = json_decode($_POST['postJsonVal']);
        if (count($areas) > 0) {
            $html = ' <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">All areas</h4>
      </div>
      <div class="modal-body">
        <form>';
            foreach ($areas as $row) {
                $areaData = $this->admindbmodel->fetch_data_con_result($row, 'id', 'areas');
                $html .=' <div class="modal-field text-align-none">
    <dl class="dl-horizontal">';
                $html .='<dt>Area Name:</dt>';
                $html .="<dd> " . $areaData[0]->area_name_english . " </dd>
    </dl>
          </div>";
            }

            $html.='</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>';
        } else {
            $html = ' <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">All areas</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="modal-field text-align-none">
          No record found!
       
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>';
        }

        echo $html;
    }

//    view modal
    public function view() {
        $dataValue = $this->admindbmodel->fetch_data_con_result($_POST['postID'], 'id', 'distributors');
        $insert_date = date('Y-m-d h:i a', strtotime($dataValue[0]->insert_date));
        $areaCovered = count(json_decode($dataValue[0]->area));
        $status = 'Inactive';
        if ($dataValue[0]->area == 1) {
            $status = 'Active';
        }
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
             Id : ' . $dataValue[0]->id . '
          </div>
          <div class="modal-field text-align-none">
             Contact Number : ' . $dataValue[0]->contact_number . '
          </div>
          <div class="modal-field text-align-none">
             Areas : ' . $areaCovered . '
          </div>
          <div class="modal-field text-align-none">
             Status : ' . $status . '
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

//get area list by city
    public function getAreaByCityId() {
        $html = '';
        $html .="<option value=''>Please Select</option>";
        $areaData = $this->admindbmodel->fetch_data_con_result($_POST['postID'], 'city_id', 'areas');
        if ($areaData) {
            foreach ($areaData as $areaVal) {
                $html .="<option value='" . $areaVal->id . "'>" . $areaVal->area_name_english . "</option>";
            }
        } else {
            $html .="<option value=''>No area available</option>";
        }
        echo $html;
        exit;
        ;
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
        $result = $this->admindbmodel->update_data_con($data, $id, $fieldName, $this->tbl_name1);
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
        die();
    }

    public function add() {
        $data['title'] = 'Add New';
        $data['main_content'] = 'distributors/add';
        $data['areaValue'] = $this->admindbmodel->fetch_all_data_result('areas');
        $data['cityValue'] = $this->admindbmodel->fetch_all_data_result('cities');
        $this->form_validation->set_rules('name', 'Name', 'strip_tags|trim|required');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'strip_tags|trim|required');
        $this->form_validation->set_rules('distributor_address', 'Address', 'strip_tags|trim|required');
        $this->form_validation->set_rules('area[]', 'Area', 'strip_tags|trim|required');
        if ($this->form_validation->run() != FALSE) {
            $insert_data['insert_date'] = date('Y-m-d H:i:s');
            $insert_data['name'] = $this->input->post('name');
            $insert_data['contact_number'] = $this->input->post('contact_number');
            $insert_data['city_id'] = $this->input->post('city_id');
            $insert_data['email'] = $this->input->post('email');
            $insert_data['distributor_address'] = $this->input->post('distributor_address');
            $insert_data['password'] = md5($this->input->post('distributor_address'));
            $insert_data['area'] = json_encode($this->input->post('area'));
            if ($this->admindbmodel->set_data($insert_data, 'distributors') == TRUE) {
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
        $data['areaValue'] = $this->admindbmodel->fetch_data_con_result($data['dataValue'][0]->city_id, 'city_id', 'areas');
        $data['cityValue'] = $this->admindbmodel->fetch_all_data_result('cities');
        $data['title'] = 'Edit Area';
        $data['main_content'] = 'distributors/edit';
        $this->form_validation->set_rules('name', 'Name', 'strip_tags|trim|required');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'strip_tags|trim|required');
        $this->form_validation->set_rules('distributor_address', 'Address', 'strip_tags|trim|required');
        $this->form_validation->set_rules('city_id', 'City', 'strip_tags|trim|required');
        $this->form_validation->set_rules('area[]', 'Area', 'strip_tags|trim|required');
        if ($this->form_validation->run() != FALSE) {
            $updateData['status'] = $this->input->post('status');
            $updateData['name'] = $this->input->post('name');
            $updateData['city_id'] = $this->input->post('city_id');
            $updateData['contact_number'] = $this->input->post('contact_number');
            $updateData['email'] = $this->input->post('email');
            $updateData['distributor_address'] = $this->input->post('distributor_address');
            $updateData['area'] = json_encode($_POST['area']);
            if ($_POST['password']) {
                $updateData['password'] = md5($_POST['password']);
            }
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
