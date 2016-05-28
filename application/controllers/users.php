<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends CI_Controller {

    var $tbl_name1;
    var $tbl_name2;

    function __construct() {
        parent::__construct();
        $this->load->library("lib");
        $this->lib->auth_check(); //authentication check
        $this->load->model("admindbmodel");
        $this->tbl_name1 = "users";
        $id = $this->session->userdata('loged_user_id');
        $this->load->helper('text');
    }

    public function index() {
        $result = $this->admindbmodel->getUsersWithArea();
        $data['allareas'] = $this->admindbmodel->fetch_all_data_result('areas');
        $data['allcities'] = $this->admindbmodel->fetch_all_data_result('cities');
        $json = array();
        $json['data'] = array();
        foreach ($result as $key => $val) {
            $preferred_distributor = "<span class='label label-danger'>No</span> &nbsp; ";
            $preferred_distributor_data = $this->admindbmodel->preferredDistributorDetails($val['id']);
            if ($preferred_distributor_data) {
                $preferred_distributor = $preferred_distributor_data[0]->dist_name . '(' . $preferred_distributor_data[0]->dist_id . ')';
            }
            if ($val['status'] == 1) {
                $status_change_btn = "<span class='label label-success'>Active</span> &nbsp; ";
            } else {
                $status_change_btn = "<span class='label label-danger'>Inactive</span> &nbsp; ";
            }
            if ($val['sms_verified'] == 1) {
                $sms_verified = "<span class='label label-success'>Yes</span> &nbsp; ";
            } else {
                $sms_verified = "<span class='label label-danger'>No</span> &nbsp; ";
            }
            $orders = count($this->admindbmodel->fetch_data_con_result($val['id'],'user_id','orders'));
            $city = $this->admindbmodel->fetch_data_con_result($val['city_id'],'id','cities');
            $view_btn = "<a href='#' title='View' class='view btn btn-primary btn-sm' data-toggle='modal' data-target='#myModal' data-value='" . $val['id'] . "'><i class='icon-search icon-white'></i>View</a> ";
            $delete_btn = "<a href='" . base_url('users/delete_data/' . $val['id']) . "' title='Delete' class='delete btn  btn-danger btn-sm'><i class='icon-trash icon-white'></i>Delete</a>";
            $edit_btn = "<a href='" . base_url('users/edit/' . $val['id']) . "' title='Edit' class='btn btn-sm btn-info' ><i class='icon-edit icon-white'></i>Edit</a> ";
            $Cdate = date('j\<\s\u\p\>S\<\/\s\u\p\> M Y h:i a', strtotime($val['insert_date']));
            $json['data'][$key]['user_id'] = $val['id'];
            $json['data'][$key]['contact_number'] = $val['contact_number'];
            $json['data'][$key]['orders'] = $orders;
            $json['data'][$key]['preferred_distributor'] = $preferred_distributor;
            $json['data'][$key]['users_address'] = $val['users_address'];
            $json['data'][$key]['sms_verified'] = $sms_verified;
            $json['data'][$key]['app_version'] = $val['app_version'];;
            $json['data'][$key]['city'] = $city[0]->city_name_english;
            $json['data'][$key]['area'] = $val['area_name_english'];
            $json['data'][$key]['status'] = $status_change_btn;
            $json['data'][$key]['createdDate'] = $Cdate;
            $json['data'][$key]['action'] = $view_btn . $edit_btn . $delete_btn;
        }
        $data['title'] = "User management";
        $data['main_content'] = 'users/list';
        $data['datainfo'] = json_encode($json);
        $this->load->view('template', $data);
    }

//    get distributor by area id
    public function getDistributorByArea() {
        $html = "<option value=''>None</option>";
        $getDistributor = $this->admindbmodel->getDistributrosByAreaId($_POST['postID']);
        if ($getDistributor['data']) {
            foreach ($getDistributor['data'] as $distVal) {
                $id = $distVal["dist_id"];
                $name = $distVal["dist_name"];
                $html .="<option value='" . $id . "'>" . $name . "(".$id.")</option>";
            }
        } else {
            $html .="<option value=''>No Distributor Found</option>";
        }
        echo $html;
        exit;
    }

//    view modal
    public function view() {
        $dataValue = $this->admindbmodel->getUsersWithAreaByUserId($_POST['postID']);
        $insert_date = date('Y-m-d h:i a', strtotime($dataValue[0]->insert_date));
        $status = 'Active';
        $verified = 'No';
        if ($dataValue[0]->status == 0) {
            $status = 'In active';
        }
        if ($dataValue[0]->sms_verified == 1) {
            $verified = 'Yes';
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
             Contact Number  : ' . $dataValue[0]->contact_number . '
          </div>
          <div class="modal-field text-align-none">
             Address   : ' . $dataValue[0]->users_address . '
          </div>
          <div class="modal-field text-align-none">
             Email   : ' . $dataValue[0]->email . '
          </div>
          <div class="modal-field text-align-none">
             Area   : ' . $dataValue[0]->area_name_english . '
          </div>
          <div class="modal-field text-align-none">
             Status   : ' . $status . '
          </div>
          <div class="modal-field text-align-none">
             App version   : ' . $dataValue[0]->app_version . '
          </div>
          <div class="modal-field text-align-none">
             Phone Verified   : ' . $verified . '
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
        $data['main_content'] = 'users/add';
        $data['cityValue'] = $this->admindbmodel->fetch_all_data_result('cities');
        $this->form_validation->set_rules('name', 'Name', 'strip_tags|trim|required');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'strip_tags|trim|required|is_unique[users.contact_number]');
        $this->form_validation->set_rules('users_address', 'Address', 'strip_tags|trim|required');
        $this->form_validation->set_rules('city_id', 'City', 'strip_tags|trim|required');
        $this->form_validation->set_rules('area', 'Area', 'strip_tags|trim|required');
        if ($this->form_validation->run() != FALSE) {
            $appVersion = $this->admindbmodel->fetch_all_data_result('app_version');
            $insert_data['insert_date'] = date('Y-m-d H:i:s');
            $insert_data['name'] = $this->input->post('name');
            $insert_data['app_version'] = $appVersion[0]->app_version;
            $insert_data['sms_verified'] = 1;
            $insert_data['city_id'] = $this->input->post('city_id');
            $insert_data['contact_number'] = $this->input->post('contact_number');
            $insert_data['email'] = $this->input->post('email');
            $insert_data['users_address'] = $this->input->post('users_address');
            $insert_data['password'] = md5($this->input->post('password'));
            $insert_data['area'] = $this->input->post('area');
            if (isset($_POST['preferred_distributor'])) {
                
            }
            $user_id = $this->admindbmodel->insertReturnLastId($insert_data, 'users');
            if ($user_id) {
                if ($_POST['preferred_distributor'] != '') {
                    $insertPreferredDist['insert_date'] = date('Y-m-d H:i:s');
                    $insertPreferredDist['user_id'] = $user_id;
                    $insertPreferredDist['distributor_id'] = $_POST['preferred_distributor'];
                    $this->admindbmodel->insertReturnLastId($insertPreferredDist, 'preferred_distributors');
                }
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
        $data['preferredDistValue'] = $this->admindbmodel->preferredDistributorDetails($id, 'user_id', 'preferred_distributors');
        $data['areaValue'] = $this->admindbmodel->fetch_data_con_result($data['dataValue'][0]->city_id, 'city_id', 'areas');
        $dist_by_area = $this->admindbmodel->getDistributrosByAreaId($data['dataValue'][0]->area);
        $data['getDistByArea'] = $dist_by_area['data']; //$this->admindbmodel->getDistributrosByAreaId($data['dataValue'][0]->area)['data'];
        $data['title'] = 'Edit User';
        $data['main_content'] = 'users/edit';
        $this->form_validation->set_rules('name', 'Name', 'strip_tags|trim|required');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'strip_tags|trim|required');
        $this->form_validation->set_rules('users_address', 'Address', 'strip_tags|trim|required');
        $this->form_validation->set_rules('status', 'Status', 'strip_tags|trim|required');
        $this->form_validation->set_rules('area', 'Area', 'strip_tags|trim|required');
        $this->form_validation->set_rules('sms_verified', 'Mobile Verification', 'required');
        $this->form_validation->set_rules('app_version', 'App Version', 'required');
        if ($this->form_validation->run() != FALSE) {
            $updateData['status'] = $this->input->post('status');
            $updateData['name'] = $this->input->post('name');
            $updateData['app_version'] = $this->input->post('app_version');
            $updateData['contact_number'] = $this->input->post('contact_number');
            $updateData['email'] = $this->input->post('email');
            $updateData['sms_verified'] = $this->input->post('sms_verified');
            $updateData['users_address'] = $this->input->post('users_address');
            $updateData['area'] = $this->input->post('area');
            if ($_POST['password']) {
                $updateData['password'] = md5($_POST['password']);
            }
            if ($this->admindbmodel->update_data_con($updateData, $id, 'id', $this->tbl_name1) == TRUE) {
                if ($_POST['preferred_distributor'] != '') {
                    if ($this->admindbmodel->fetch_data_con_result($id, 'id', 'preferred_distributors')) {
                        $updatePreferredDist['distributor_id'] = $_POST['preferred_distributor'];
                        $this->admindbmodel->update_data_con($updatePreferredDist, $id, 'id', 'preferred_distributors'); //update preferred dist
                    } else {
                        $insertPreferredDist['insert_date'] = date('Y-m-d H:i:s');
                        $insertPreferredDist['user_id'] = $id;
                        $insertPreferredDist['distributor_id'] = $_POST['preferred_distributor'];
                        $this->admindbmodel->insertReturnLastId($insertPreferredDist, 'preferred_distributors');
                    }
                } else {
                    $this->admindbmodel->deleteDataOneCon($id, 'user_id', 'preferred_distributors'); //delete preferred dist
                }

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
