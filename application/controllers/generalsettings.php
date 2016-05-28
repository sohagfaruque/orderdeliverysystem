<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Generalsettings extends CI_Controller {

    var $tbl_name1;
    var $tbl_name2;

    function __construct() {
        parent::__construct();
        $this->load->library("lib");
        $this->lib->auth_check(); //authentication check
        $this->load->model('users_model');
        $this->load->model("admindbmodel");
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->tbl_name2 = "admin_list";
        $this->load->library('email');
    }

    public function index() {
        $id = $this->session->userdata('loged_user_id');
        $data['title'] = 'General Settings';
        $data['main_content'] = 'generalsettings/edit';
        $data['dataValue'] = $this->admindbmodel->fetch_data_con_result($id, 'id', $this->tbl_name2);
        $data['versionValue'] = $this->admindbmodel->fetch_all_data_result('app_version');
        $data['verificationValue'] = $this->admindbmodel->fetch_data_con_result(1, 'type', 'verification_settings');
        $this->form_validation->set_rules('name', 'User Name', 'strip_tags|trim|required|callback_recheck_availabity');
        $this->form_validation->set_rules('status', 'Status', 'strip_tags|trim|required');
        $this->form_validation->set_rules('app_version', 'App Version', 'strip_tags|trim|required');
        if ($this->form_validation->run() != FALSE) {
            //update data from inpput fields
            if (isset($_POST['password'])) {
                if ($_POST['password'] != '') {
                    $updateData['password'] = md5($this->input->post('password'));
                }
            }
            $updateData['name'] = $this->input->post('name');
            $updateData['email'] = $this->input->post('email');
            if ($this->admindbmodel->update_data_con($updateData, $id, 'id', $this->tbl_name2)) {
                $updateVerification['updated_by'] = $id;
                $updateVerification['status'] = $this->input->post('status');
                $this->admindbmodel->update_data_con($updateVerification, 1, 'type', 'verification_settings'); //mobile verification update
                $updateAppVersion['app_version'] = $this->input->post('app_version');
                $updateAppVersion['update_date'] = date('Y-m-d H:i:s');
                $this->admindbmodel->update_data($updateAppVersion, 'app_version'); //Update app version
                $data['successMsg'] = 'Successfully Updated';
                $this->load->view('template', $data);
            } else {
                $data['errorMsg'] = 'System Error.Please Let Us Know.';
                $data['userValue'] = $this->admindbmodel->fetch_data_con_result($id, 'id', $this->tbl_name2);
            }
        } else {
            $this->load->view('template', $data);
        }
    }

    /* Delete User */

    public function delete_data($id) {
        $update_data['soft_delete'] = 1;
        if ($checkAnsIs = $this->admindbmodel->update_data_con($update_data, $id, 'id', $this->tbl_name2) == true) {
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

    public function recheck_availabity($name) {
        $id = $this->session->userdata('loged_user_id');
        if ($this->admindbmodel->check_userrecheck($name, $id, 'name', $this->tbl_name2) > 0) {
            $this->form_validation->set_message('recheck_availabity', 'This name is Already Assigned to Other Admin!');
            return FALSE;
        } else {
            return true;
        }
    }

    /* profile update */

    public function profile_edit($id) {
        //print_r();exit;
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        if ($this->form_validation->run() != FALSE) {
            //customize date to insert in db
            $update_data['email'] = $this->input->post("email");
            $update_data['name'] = $this->input->post("name");
            $updateresult = $this->admindbmodel->update_data_con($update_data, $id, 'id', $this->tbl_name2);
            if ($updateresult == TRUE) {
                $this->session->set_userdata('username', $update_data['name']);
                $this->session->set_userdata('user_email', $update_data['email']);
                $this->email->from('info@notification.com', 'Admin');
                $this->email->to($update_data['email']);
                $this->email->subject('Profile Setting Change.');
                $message = "<p>Your Profile Setting Has Been Changed.</p>";

                $this->email->message($message);
                $sendmail = $this->email->send();
                $rurl = base_url() . "home/";
                echo "<script> alert('Information Successfully Updated');  window.location.href='" . $rurl . "'</script>";
            } else {
                echo "<script>alert('System Error.Please Contact With Developer!');  window.location.href=''</script>";
            }
        } else {
            $data["result"] = $this->admindbmodel->getDataById($id, 'id', $this->tbl_name2);
            $data['main_content'] = 'home/profile';
            $this->load->view('template', $data);
        }
    }

    /* change password view start */

    public function changepassword() {

        $this->form_validation->set_rules('cpass', 'Current Password', 'trim|required|callback_passwordcheck');
        $this->form_validation->set_rules('pass', 'Password', 'trim|required|matches[passconf]|md5');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required');
        if ($this->form_validation->run() != FALSE) {
            $insert_ARR['password'] = $this->input->post("pass");
            $result = $this->admindbmodel->update_data_con($insert_ARR, $this->session->userdata('user_email'), 'email', $this->tbl_name2);
            if ($result == TRUE) {
                echo "<script>alert('Successfully Updated');  window.location.href='" . $this->config->item('base_url') . "home'</script>";
            } else {
                echo "<script>alert('System Error.Please Contact with Developer');  window.location.href='" . $this->config->item('base_url') . "index.php/home'</script>";
            }
        } else {
            $data['main_content'] = 'home/changepassword';
            $this->load->view('template', $data);
        }
    }

    /* Check whether email exits or not start */

    public function passwordcheck($cpass) {
        if ($this->admindbmodel->fetch_data_con2($this->session->userdata('user_email'), md5($cpass), 'email', 'password', $this->tbl_name2)) {
            return true;
        } else {

            $this->form_validation->set_message('passwordcheck', 'You Have Entered Wrong Password');
            return FALSE;
        }
    }

}
