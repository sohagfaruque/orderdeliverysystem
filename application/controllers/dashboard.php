<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
        $id = $this->session->userdata('loged_user_id');
        $this->session->unset_userdata('start'); //unselt datatable falg
    }

    function index() {
        $data['title'] = 'Dashboard';
        $data['main_content'] = 'dashboard/dashboard';
        $data['areaValue'] = $this->admindbmodel->fetch_all_data_result('areas');
        $data['cityValue'] = $this->admindbmodel->fetch_all_data_result('cities');
        $data['userValue'] = $this->admindbmodel->fetch_all_data_result('users');
        $data['productValue'] = $this->admindbmodel->fetch_all_data_result('products');
        $data['orderValue'] = $this->admindbmodel->fetch_all_data_result('orders');
        $data['distributortValue'] = $this->admindbmodel->fetch_all_data_result('distributors');
        $this->load->view('template', $data);
    }

    function userlist() {
        $data['title'] = 'User List';
        $data['main_content'] = 'home/userlist';
        $this->load->view('template', $data);
    }

    public function getUserList() {
        $data_table_param['offset'] = $_POST['length'] == -1 ? '' : $_POST['start'];
        $data_table_param['limit'] = $_POST['length'] == -1 ? '' : $_POST['length'];
        $data_table_param['search'] = $_POST['search']['value'];
        $sorting_array = array(0 => 'id', 1 => 'name');
        $data_table_param['sorting'] = $sorting_array[$_POST['order'][0]['column']];
        $data_table_param['sorting_dir'] = $_POST['order'][0]['dir'];
        $result = $this->admindbmodel->get_users($data_table_param);
        // print_r($result);exit;
        $json = array();
        $json['draw'] = 0;
        $json['recordsTotal'] = $result['total_rows'];
        $json['recordsFiltered'] = $result['total_rows'];
        $json['data'] = array();
        $counter = $_POST['start'];
        foreach ($result['user_data'] as $key => $val) {
            $counter = $counter + 1;
            if ($val['status'] == 1) {
                $status_change_btn = "<span class='label label-success'>Active</span> &nbsp; "
                        . "<a href='" . base_url('home/updateUserStatus/' . $val['id']) . "/" . $val['status'] . "' class='update' title='Deactive This User' style='color:#dd1111;'>"
                        . "<i class='fa fa-times'></i>"
                        . "</a>";
            } else {
                $status_change_btn = "<span class='label label-danger'>Inactive</span> &nbsp; "
                        . "<a href='" . base_url('home/updateUserStatus/' . $val['id']) . "/" . $val['status'] . "' class='update' title='Active This User'><i class='fa fa-check'></i></a>";
            }
            if ($val['type'] == 1) {
                $type = "<span class='label label-success'>Admin</span>";
            }
            if ($val['type'] == 2) {
                $type = "<span class='label label-primary'>Editor</span>";
            }
            if ($val['type'] == 3) {
                $type = "<span class='label label-info'>Author</span>";
            }
            $edit_btn = "<a href='" . base_url('home/editUser/' . $val['id']) . "' title='Edit' class='btn btn-info' ><i class='icon-edit icon-white'></i>Edit</a> ";
            $view_btn = "<a href='#' title='View' class='view btn btn-primary' data-toggle='modal' data-target='#myModal' data-value='" . $val['id'] . "'><i class='icon-search icon-white'></i>View</a> ";
            $delete_btn = "<a href='" . base_url('home/delete_data/' . $val['id']) . "' title='Delete' class='delete btn btn-danger'><i class='icon-trash icon-white'></i>Delete</a>";
            $Cdate = date('j\<\s\u\p\>S\<\/\s\u\p\> M Y h:i a', strtotime($val['insert_date']));
            $json['data'][$key]['serial'] = $counter;
            $json['data'][$key]['name'] = $val['name'];
            $json['data'][$key]['email'] = $val['email'];
            $json['data'][$key]['type'] = $type;

            $json['data'][$key]['status'] = $status_change_btn;
            $json['data'][$key]['Cdate'] = $Cdate;
            $json['data'][$key]['action'] = $view_btn . $edit_btn . $delete_btn;
        }
        echo json_encode($json);
        die();
    }

    //    view modal
    public function userView() {
        $userValue = $this->admindbmodel->fetch_data_con_result($_POST['userid'], 'id', $this->tbl_name2);
        $status = $userValue[0]->status == 1 ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';
        if ($userValue[0]->type == 1) {
            $type = "<span class='label label-success'>Admin</span>";
        }
        if ($userValue[0]->type == 2) {
            $type = "<span class='label label-primary'>Editor</span>";
        }
        if ($userValue[0]->type == 3) {
            $type = "<span class='label label-info'>Author</span>";
        }
        $insertDate = date('Y-m-d h:i a', strtotime($userValue[0]->insert_date));
        $html = ' <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">' . $userValue[0]->name . '</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="modal-footer text-align-none">
             Name : ' . $userValue[0]->name . '
          </div>
          <div class="modal-footer text-align-none">
             Email : ' . $userValue[0]->email . '
          </div>
          <div class="modal-footer text-align-none">
             Type : ' . $type . '
          </div>
          <div class="modal-footer text-align-none">
             Insert Date : ' . $insertDate . '
          </div>
           <div class="modal-footer text-align-none">
             Status : ' . $status . '
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

    /* update user status */

    public function updateUserStatus($id, $status) {
        if ($status == 0) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }
        $fieldName = 'id';
        $result = $this->admindbmodel->update_data_con($data, $id, $fieldName, $this->tbl_name2);
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
        die();
    }

//    add user as admin,editor,author
    public function adduser() {
        $this->form_validation->set_rules('email', 'Email', 'strip_tags|trim|required|valid_email|is_unique[admin_list.email]');
        $this->form_validation->set_rules('name', 'name', 'strip_tags|trim|required');
        $this->form_validation->set_rules('type', 'Type', 'strip_tags|trim|required');
        $this->form_validation->set_rules('password', 'Type', 'strip_tags|trim|required');
        if ($this->form_validation->run() != FALSE) {

            $insert_data['insert_date'] = date('Y-m-d H:i:s');
            $insert_data['name'] = $this->input->post('name');
            $insert_data['email'] = $this->input->post('email');
            $insert_data['type'] = $this->input->post('type');
            $insert_data['password'] = md5($this->input->post('type'));
            $insert_data['status'] = 1;
            if ($this->admindbmodel->set_data($insert_data, $this->tbl_name2)) {
                $data['title'] = 'Add User';
                $data['successMsg'] = 'User Added Successfully.';
                $data['main_content'] = 'home/adduser';
                $this->load->view('template', $data);
            } else {
                $data['title'] = 'Add User';
                $data['errorMsg'] = 'System Error.Please Contact With Developer.';
                $data['main_content'] = 'home/adduser';
                $this->load->view('template', $data);
            }
        } else {
            $data['title'] = 'Add User';
            $data['main_content'] = 'home/adduser';
            $this->load->view('template', $data);
        }
    }

    public function editUser($id) {
        $this->form_validation->set_rules('email', 'Email', 'strip_tags|trim|required|valid_email|callback_recheck_availabity_by_email');
        $this->form_validation->set_rules('name', 'Name', 'strip_tags|trim|required');
        $this->form_validation->set_rules('type', 'Type', 'strip_tags|trim|required');
        $this->form_validation->set_rules('status', 'Status', 'strip_tags|trim|required');
        if ($this->form_validation->run() != FALSE) {
            //update data from inpput fields
            if (isset($_POST['password'])) {
                $updateData['password'] = md5($this->input->post('password'));
            }
            $updateData['name'] = $this->input->post('name');
            $updateData['email'] = $this->input->post('email');
            $updateData['type'] = $this->input->post('type');
            $updateData['status'] = $this->input->post('status');
            if ($this->admindbmodel->update_data_con($updateData, $id, 'id', $this->tbl_name2)) {
//                   
                $data['successMsg'] = 'Successfully Updated';
                $data['userValue'] = $this->admindbmodel->fetch_data_con_result($id, 'id', $this->tbl_name2);
                $data['title'] = $data['userValue'][0]->name . ' || Edit User';
                $data['main_content'] = 'home/edituser';
                $this->load->view('template', $data);
            } else {
                $data['errorMsg'] = 'System Error.Please Let Us Know.';
                $data['userValue'] = $this->admindbmodel->fetch_data_con_result($id, 'id', $this->tbl_name2);
                $data['title'] = $data['userValue'][0]->name . ' || Edit User';
                $data['main_content'] = 'home/edituser';
                $this->load->view('template', $data);
            }
        } else {
            $data['userValue'] = $this->admindbmodel->fetch_data_con_result($id, 'id', $this->tbl_name2);
            $data['title'] = $data['userValue'][0]->name . ' || Edit User';
            $data['main_content'] = 'home/edituser';
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

    public function recheck_availabity_by_email($name) {
        $id = $this->uri->segment(3);
        if ($this->admindbmodel->check_userrecheck($name, $id, 'email', $this->tbl_name2) > 0) {
            $this->form_validation->set_message('recheck_availabity_by_email', 'This Email is Already Assigned to Other Admin!');
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
