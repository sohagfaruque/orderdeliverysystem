<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Account extends CI_Controller {

    var $tbl_name1;
    var $tbl_name2;

    function __construct() {
        parent::__construct();
        $this->load->library("lib");
        $this->lib->auth_check(); //authentication check
        $this->load->model("admindbmodel");
        $this->tbl_name1 = "news";
        $this->tbl_name2 = "admin_list";
        $id = $this->session->userdata('loged_user_id');
    }

//    view modal
    public function view() {
        $newsValue = $this->admindbmodel->getNewsDataById($_POST['newsid'], 'id', $this->tbl_name1);
        if ($newsValue[0]->type == 1) {
            $type = 'Admin';
        }
        if ($newsValue[0]->type == 2) {
            $type = 'Editor';
        }
        if ($newsValue[0]->type == 3) {
            $type = 'Author';
        }
        $image = "<img src='" . base_url('assets/images/news/small') . '/' . $newsValue[0]->image . "'>";
        $status = $newsValue[0]->status == 1 ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';
        $verified = $newsValue[0]->verified == 1 ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>';
        $insertDate = date('Y-m-d h:i a', strtotime($newsValue[0]->insert_date));
        $html = ' <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">' . $newsValue[0]->newsName . '</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="modal-footer text-align-none">
             Title : ' . $newsValue[0]->newsName . '
          </div>
          <div class="modal-footer text-align-none">
             Category : ' . $newsValue[0]->category . '
          </div>
          <div class="modal-footer text-align-none">
             Posted By : ' . $newsValue[0]->userName . '/' . $type . '
          </div>
          <div class="modal-footer text-align-none">
             Link : ' . $newsValue[0]->newsLink . '
          </div>
          <div class="modal-footer text-align-none">
             Details : ' . $newsValue[0]->newsDetails . '
          </div>
          <div class="modal-footer text-align-none">
             Image : ' . $image . '
          </div>
          <div class="modal-footer text-align-none">
             Insert Date : ' . $insertDate . '
          </div>
           <div class="modal-footer text-align-none">
             Status : ' . $status . '
          </div>
           <div class="modal-footer text-align-none">
             Verified : ' . $verified . '
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

//url validation
    public function valid_url($url) {
        if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
            return TRUE;
        } else {
            $this->form_validation->set_message('valid_url', 'Url Is Not Valid');
            return FALSE;
        }
    }

    public function edit($id) {
        $this->form_validation->set_rules('email', 'Email', 'strip_tags|trim|required|valid_email|callback_recheck_availabity_by_email');
        $this->form_validation->set_rules('name', 'Name', 'strip_tags|trim|required');

        if ($this->form_validation->run() != FALSE) {
            //update data from inpput fields
            if (isset($_POST['password'])) {
                if($_POST['password']){
                    $updateData['password'] = md5($this->input->post('password'));
                }
                
            }
            $updateData['name'] = $this->input->post('name');
            $updateData['email'] = $this->input->post('email');

            if ($this->admindbmodel->update_data_con($updateData, $id, 'id', $this->tbl_name2)) {
//                   store in session data
                $data['userValue'] = $this->admindbmodel->fetch_data_con_result($id, 'id', $this->tbl_name2);
                $this->session->set_userdata('loged_user_id', $data['userValue'][0]->id);
                $this->session->set_userdata('username', $data['userValue'][0]->name);
                $this->session->set_userdata('type', $data['userValue'][0]->type);
                $this->session->set_userdata('user_email', $data['userValue'][0]->email);
                $this->session->set_userdata('authenkey', 'loggedin');
                
                $data['successMsg'] = 'Successfully Updated';
                $data['userValue'] = $this->admindbmodel->fetch_data_con_result($id, 'id', $this->tbl_name2);
                $data['title'] = $data['userValue'][0]->name . ' || Edit User';
                $data['main_content'] = 'dashboard/updateprofile';
                $this->load->view('template', $data);
            } else {
                $data['errorMsg'] = 'System Error.Please Let Us Know.';
                $data['userValue'] = $this->admindbmodel->fetch_data_con_result($id, 'id', $this->tbl_name2);
                $data['title'] = $data['userValue'][0]->name . ' || Edit User';
                $data['main_content'] = 'dashboard/updateprofile';
                $this->load->view('template', $data);
            }
        } else {
            $data['userValue'] = $this->admindbmodel->fetch_data_con_result($id, 'id', $this->tbl_name2);

            $data['title'] = $data['userValue'][0]->name . ' || Edit User';
            $data['main_content'] = 'dashboard/updateprofile';
            $this->load->view('template', $data);
        }
    }
}
