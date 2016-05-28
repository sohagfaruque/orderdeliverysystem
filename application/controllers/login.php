<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class login extends CI_Controller {

    var $tbl_name1;

    function __construct() {
        parent::__construct();
        $this->load->helper("url");
        $this->load->model("admindbmodel");
        $this->load->helper('date');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->tbl_name1 = "admin_list";
    }

    public function index() {


        $this->form_validation->set_rules('name', 'User name', 'strip_tags|trim|required');
        $this->form_validation->set_rules('password', 'Password', 'strip_tags|trim|required');
        $data['title'] = "Gasable App";
        if ($this->form_validation->run() != FALSE) {
            $name = $this->input->post("name");
            $password = md5($this->input->post("password"));
            $result = $this->admindbmodel->fetch_data_two_con($name, $password, 'name', 'password', $this->tbl_name1);
            if (empty($result)) {
                $data['errorMsg'] = "User name and Password Does not Match";
                $this->load->view('login/login', $data);
            } else {
                $result = $this->admindbmodel->fetch_data_two_con($result[0]->id, 1, 'id', 'status', $this->tbl_name1);
                if (empty($result)) {
                    $data['errorMsg'] = "Your Account is Blocked By Admin.Please Contact With Admin.";
                    $this->load->view('login/login', $data);
                } else {
                    $result = $this->admindbmodel->fetch_data_two_con($result[0]->id, 0, 'id', 'soft_delete', $this->tbl_name1);
                    if (empty($result)) {
                        $data['errorMsg'] = "Your Account Has Been Deleted By Admin.Please Contact with Admin.";
                        $this->load->view('login/login', $data);
                    } else {
                        foreach ($result as $row) {
                            $updateData['last_logged_time']= date('Y-m-d H:i:s');
                            $updateData['logged_ip']= $_SERVER['REMOTE_ADDR'];
                            $updateWhere['id'] = $row->id;
                            $this->admindbmodel->update_data_con($updateData,$row->id,'id',  $this->tbl_name1);
                            $this->session->set_userdata('loged_user_id', $row->id);
                            $this->session->set_userdata('username', $row->name);
                            $this->session->set_userdata('type', $row->type);
                            $this->session->set_userdata('user_email', $row->email);
                            $this->session->set_userdata('last_logged_time', $row->last_logged_time);
                            $this->session->set_userdata('logged_ip', $row->logged_ip);
                            $this->session->set_userdata('authenkey', 'loggedin');
                        }
                       $redirectUrl = base_url('dashboard');
                        redirect($redirectUrl, 'refresh');
                    }
                }
            }
        } else {
            $this->load->view('login/login', $data);
        }
    }

    function forgotpass() {
        $this->form_validation->set_rules('email', 'Email Address', 'strip_tags|trim|valid_email|required|callback_email_check');
        if ($this->form_validation->run() != FALSE) {
            $emailAddress = $this->input->post("email");
            $result = $this->admindbmodel->fetch_data_con_result($emailAddress, 'email', $this->tbl_name1);
            foreach ($result as $row) {
                
            }
            $temp_pass['password'] = md5(uniqid());
            $this->email->from('info@polaaa.com', 'Admin');
            $this->email->to($emailAddress);
            $this->email->subject('Password Reset');
            $message = "<p>This email has been sent as a request to reset our password</p>";
            $message .= "<p><a href='" . base_url() . "login/reset_password/" . $temp_pass['password'] . "/$row->id'>Click here </a>if you want to reset your password,
										if not, then ignore</p>";
            $this->email->message($message);
            $sendmail = $this->email->send();
            if ($sendmail == TRUE) {
                $this->admindbmodel->update_data_con($temp_pass, $emailAddress, 'email', $this->tbl_name1);
                echo "<script>alert('Please Check your Email');  window.location.href='login'</script>";
            } else {
                
            }
        } else {
            $data['title'] = "Forgot Password || Android Apps";
            $this->load->view('login/forgotpass', $data);
        }
    }

    function reset_password($temp_pass, $id) {
        if ($this->admindbmodel->fetch_data_two_con($id, $temp_pass, 'id', 'password', $this->tbl_name1)) {

            $redirecturl = base_url() . "login/updatepassword/" . $id;
            redirect($redirecturl);
        } else {
            echo "the key is not valid";
        }
    }

    public function updatepassword() {
        $id = $this->uri->segment('3');
        $this->form_validation->set_rules('pass', 'Password', 'trim|required|matches[passconf]|md5');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required');

        if ($this->form_validation->run() != FALSE) {
            $update_pass['password'] = $this->input->post("pass");
            if ($this->admindbmodel->update_data_con($update_pass, $id, 'id', $this->tbl_name1) == TRUE) {
                $resultUser = $this->admindbmodel->fetch_data_con_result($id, 'id', $this->tbl_name1);
                foreach ($resultUser as $row) {
                    $this->session->set_userdata('loged_user_id', $row->id);
                    $this->session->set_userdata('username', $row->name);
                    $this->session->set_userdata('user_email', $row->email);
                }
                $this->session->set_userdata('authenkey', 'loggedin');
                echo "<script>alert('Your Password has been changed.');  window.location.href='" . base_url() . "userlist'</script>";
            } else {
                echo "<script>alert('System Error.Please Contact With Developer.');  window.location.href='" . base_url() . "login'</script>";
            }
        } else {
            $this->load->view('login/updatepass');
        }
    }

    public function email_check($email) {
        $result = $this->admindbmodel->fetch_data_con($email, 'email', $this->tbl_name1);
        if ($result < 1) {
            $this->form_validation->set_message('email_check', 'Your Email Address Is not in The List!');
            return false;
        } else {

            return true;
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        $redirecturl = $this->config->item('base_url');
        redirect($redirecturl);
    }

}

?>