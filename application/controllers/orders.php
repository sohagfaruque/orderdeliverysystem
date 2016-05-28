<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orders extends CI_Controller {

    var $tbl_name1;
    var $tbl_name2;

    function __construct() {
        parent::__construct();
        $this->load->library("lib");
        $this->lib->auth_check(); //authentication check
        $this->load->model("admindbmodel");
        $this->tbl_name1 = "orders";
        $id = $this->session->userdata('loged_user_id');
        $this->load->helper('text');
    }

    public function index() {
        $result = $this->admindbmodel->getOrderDetails();
        $json = array();
        $json['data'] = array();
        foreach ($result as $key => $val) {
            if ($val['status'] == 0) {
                $status_btn = "<span class='label label-success'>Open</span> &nbsp; ";
            } elseif ($val['status'] == 1) {
                $status_btn = "<span class='label label-info'>Confirmed</span> &nbsp; ";
            } elseif ($val['status'] == 2) {
                $status_btn = "<span class='label label-warning'>Delivered</span> &nbsp; ";
            } else {
                $status_btn = "<span class='label label-danger'>Canceled</span> &nbsp; ";
            }
            if ($val['status'] == 0) {//
                $distributor_id = '';
                $distributor_contact_number = '';
            } else {
                $getDistributorData = $this->admindbmodel->fetch_data_con_result($val['distributor_id'], 'id', 'distributors');
                $distributor_id = $getDistributorData[0]->id;
                $distributor_contact_number = $getDistributorData[0]->contact_number;
            }
            $view_btn = "<a href='#' title='View' class='view btn btn-primary btn-sm' data-toggle='modal' data-target='#myModal' data-value='" . $val['id'] . "'><i class='icon-search icon-white'></i>View</a> ";
            $delete_btn = "<a href='" . base_url('orders/delete_data/' . $val['id']) . "' title='Delete' class='delete btn  btn-danger btn-sm'><i class='icon-trash icon-white'></i>Delete</a>";
            $edit_btn = "<a href='" . base_url('orders/edit/' . $val['id']) . "' title='Edit' class='btn btn-sm btn-info' ><i class='icon-edit icon-white'></i>Edit</a> ";
//            $order_date = date('j\<\s\u\p\>S\<\/\s\u\p\> M Y h:i a', strtotime($val['insert_date']));
            $order_date = date('d/m/Y', strtotime($val['insert_date']));
            $delivery_date = date('j\<\s\u\p\>S\<\/\s\u\p\> M Y h:i a', strtotime($val['delivery_date']));
            $json['data'][$key]['order_id'] = $val['id'];
            $json['data'][$key]['user_contact_number'] = $val['user_contact_number'];
            $json['data'][$key]['distributor_id'] = $distributor_id;
            $json['data'][$key]['distributor_contact_number'] = $distributor_contact_number;
            $json['data'][$key]['product_name'] = $val['product_name'];
            $json['data'][$key]['product_amount'] = $val['product_amount'];
            $json['data'][$key]['city_name_english'] = $val['city_name_english'];
            $json['data'][$key]['area_name_english'] = $val['area_name_english'];
            $json['data'][$key]['shipping_address'] = $val['shipping_address'];
            $json['data'][$key]['status'] = $status_btn;
            $json['data'][$key]['delivery_date'] = $delivery_date;
            $json['data'][$key]['order_date'] = $order_date;
            $json['data'][$key]['action'] = $view_btn . $edit_btn . $delete_btn;
        }
        $data['title'] = "Order management";
        $data['main_content'] = 'orders/list';
        $data['datainfo'] = json_encode($json);
        $this->load->view('template', $data);
    }

//    get distributor by user area id
    public function getDistributorByUserId() {
        $html = "<option value=''>Please select</option>";
        $userDetails = $this->admindbmodel->fetch_data_con_result($_POST['postID'], 'id', 'users');
        $getDistributor = $this->admindbmodel->getDistributrosByAreaId($userDetails[0]->area);
        if ($getDistributor['data']) {
            foreach ($getDistributor['data'] as $distVal) {
                $id = $distVal["dist_id"];
                $name = $distVal["dist_name"];
                $html .="<option value='" . $id . "'>" . $name . "(" . $id . ")</option>";
            }
        } else {
            $html .="<option value=''>No Distributor Found</option>";
        }
        echo $html;
        exit;
    }

    //get users by area id
    public function getUsersByAreaId() {
        $html = '';
        $html .="<option value=''>Please Select</option>";
        $userData = $this->admindbmodel->fetch_data_con_result($_POST['postID'], 'area', 'users');
        if ($userData) {
            foreach ($userData as $userVal) {
                $html .="<option value='" . $userVal->id . "'>" . $userVal->name . "(" . $userVal->contact_number . ")</option>";
            }
        } else {
            $html .="<option value=''>No User available</option>";
        }
        echo $html;
        exit;
        ;
    }

//    get available item amount product id
    public function getAmountByProductId() {
        $html = "<option value=''>Please select</option>";
        $productDetails = $this->admindbmodel->fetch_data_con_result($_POST['postID'], 'id', 'products');
        $availabeItems = $productDetails[0]->quantity - $productDetails[0]->sold_quantity;
        if ($availabeItems > 0) {
            for ($i = 1; $i <= $availabeItems; $i++) {
                $html .="<option value='" . $i . "'>" . $i . "</option>";
            }
        } else {
            $html .="<option value=''>Amount Not Availabe</option>";
        }
        echo $html;
        exit;
    }

//    view modal
    public function view() {
        $dataValue = $this->admindbmodel->getOrderDetailsByOrderId($_POST['postID']);
        $order_date = date('Y-m-d h:i a', strtotime($dataValue[0]->insert_date));
        $delivery_date = date('Y-m-d h:i a', strtotime($dataValue[0]->delivery_date));
        $verified = 'No';
        $distributor_id = '';
        if ($dataValue[0]->status == 0) {
            $status = 'Open';
        } elseif ($dataValue[0]->status == 1) {
            $status = 'Confirmed';
        } elseif ($dataValue[0]->status == 2) {
            $status = 'Delivered';
        } else {
            $status = 'Canceled';
        }
        if ($dataValue[0]->status != 0) {
            $distributor_id = $dataValue[0]->distributor_id;
        }
        $html = ' <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Order id "' . $dataValue[0]->id . '"</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="modal-field text-align-none">
            User Name : ' . $dataValue[0]->user_name . '
          </div>
          <div class="modal-field text-align-none">
            User Contact Number  : ' . $dataValue[0]->user_contact_number . '
          </div>
          <div class="modal-field text-align-none">
            Distributor id : ' . $distributor_id . '
          </div>
          <div class="modal-field text-align-none">
            Distributor Contact Number  : ' . $dataValue[0]->user_contact_number . '
          </div>
          <div class="modal-field text-align-none">
             Product Name   : ' . $dataValue[0]->product_name . '
          </div>
          <div class="modal-field text-align-none">
             Product Amount   : ' . $dataValue[0]->product_amount . '
          </div>
          <div class="modal-field text-align-none">
             Total Price   : ' . $dataValue[0]->total_price . '
          </div>
          <div class="modal-field text-align-none">
             City   : ' . $dataValue[0]->city_name_english . '
          </div>
          <div class="modal-field text-align-none">
             Shipping Address   : ' . $dataValue[0]->shipping_address . '
          </div>
          <div class="modal-field text-align-none">
             Area   : ' . $dataValue[0]->area_name_english . '
          </div>
          <div class="modal-field text-align-none">
             Status   : ' . $status . '
          </div>
          <div class="modal-field text-align-none">
             Order Date   : ' . $order_date . '
          </div>
          <div class="modal-field text-align-none">
             Delivery Date   : ' . $delivery_date . '
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
        $data['main_content'] = 'orders/add';
        $data['cityValue'] = $this->admindbmodel->fetch_all_data_result('cities');
        $data['userValue'] = $this->admindbmodel->fetch_all_data_result('users');
        $data['productValue'] = $this->admindbmodel->fetch_all_data_result('products');
        $this->form_validation->set_rules('city_id', 'City', 'strip_tags|trim|required');
        $this->form_validation->set_rules('user_id', 'User', 'strip_tags|trim|required');
        if (isset($_POST['status'])) {
            if ($_POST['status'] != 0) {
                $this->form_validation->set_rules('distributor_id', 'Distributor', 'strip_tags|trim|required');
            }
        }
        $this->form_validation->set_rules('product_id', 'Product', 'strip_tags|trim|required');
        $this->form_validation->set_rules('product_amount', 'Product Amount', 'strip_tags|trim|required');
        $this->form_validation->set_rules('status', 'Order Status', 'strip_tags|trim|required');
        $this->form_validation->set_rules('shipping_address', 'Shipping Address', 'strip_tags|trim|required');
        $this->form_validation->set_rules('preferred_date', 'Preferred Date', 'strip_tags|trim|required');
        $this->form_validation->set_rules('delivery_date', 'Delivery Date', 'strip_tags|trim|required');
        if ($this->form_validation->run() != FALSE) {
            $delivery_date = date('Y-m-d H:i:s', strtotime($_POST['delivery_date']));
            $preferred_date = date('Y-m-d H:i:s', strtotime($_POST['preferred_date']));
            $insert_data['insert_date'] = date('Y-m-d H:i:s');
            $insert_data['delivery_date'] = $delivery_date;
            $insert_data['preferred_date'] = $preferred_date;
            $insert_data['status'] = $this->input->post('status');
            $insert_data['shipping_address'] = $this->input->post('shipping_address');
            $insert_data['product_amount'] = $this->input->post('product_amount');
            $insert_data['product_id'] = $this->input->post('product_id');
            $insert_data['distributor_id'] = $this->input->post('distributor_id');
            $insert_data['user_id'] = $this->input->post('user_id');
            if ($_POST['status'] == 3) {
                $insert_data['cancel_date'] = date('Y-m-d H:i:s');
                $insert_data['cancel_by'] = 1; //1 means by admin
            }
            if ($this->admindbmodel->set_data($insert_data, 'orders') == TRUE) {
                if ($_POST['status'] != 3) {//if order is not canceled
                    $productDetails = $this->admindbmodel->fetch_data_con_result($_POST['product_id'], 'id', 'products'); //get product details
                    $updateData['sold_quantity'] = ($productDetails[0]->sold_quantity + $_POST['product_amount']);
                    $this->admindbmodel->update_data_con($updateData, $_POST['product_id'], 'id', 'products'); //update product table
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

    public function edit_27thmay($id) {
        $data['dataValue'] = $this->admindbmodel->getOrderDetailsByOrderId($id);
        $data['areaValue'] = $this->admindbmodel->fetch_data_con_result($data['dataValue'][0]->city_id, 'city_id', 'areas');
        $data['userValue'] = $this->admindbmodel->fetch_data_con_result($data['dataValue'][0]->area_id, 'area', 'users');
        $data['cityValue'] = $this->admindbmodel->fetch_all_data_result('cities');
        $data['productValue'] = $this->admindbmodel->fetch_all_data_result('products');
        $userData = $this->admindbmodel->fetch_data_con_result($data['dataValue'][0]->user_id, 'id', 'users');
        $dist_by_area = $this->admindbmodel->getDistributrosByAreaId($userData[0]->area);
        $data['getDistByArea'] = $dist_by_area['data']; //$this->admindbmodel->getDistributrosByAreaId($data['dataValue'][0]->area)['data'];
        $data['title'] = 'Edit Order';
        $data['main_content'] = 'orders/edit';
        $this->form_validation->set_rules('user_id', 'user', 'strip_tags|trim|required');
        $this->form_validation->set_rules('distributor_id', 'Distributor', 'strip_tags|trim|required');
        $this->form_validation->set_rules('product_id', 'Product', 'strip_tags|trim|required');
        $this->form_validation->set_rules('status', 'Status', 'strip_tags|trim|required');
        $this->form_validation->set_rules('delivery_date', 'Delivery Date', 'strip_tags|trim|required');
        if ($this->form_validation->run() != FALSE) {
            $delivery_date = date('Y-m-d H:i:s', strtotime($_POST['delivery_date']));
            $updateData['user_id'] = $this->input->post('user_id');
            $updateData['distributor_id'] = $this->input->post('distributor_id');
            $updateData['product_id'] = $this->input->post('product_id');
            $updateData['status'] = $this->input->post('status');
            $delivery_date = date('Y-m-d H:i:s', strtotime($_POST['delivery_date']));
            $updateData['delivery_date'] = $delivery_date;
            if ($_POST['status'] == 3) {
                $updateData['cancel_by'] = 1; //by admin
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

    public function edit($id) {
        $data['dataValue'] = $this->admindbmodel->getOrderDetailsByOrderId($id);
        $data['areaValue'] = $this->admindbmodel->fetch_data_con_result($data['dataValue'][0]->city_id, 'city_id', 'areas');
        $data['userValue'] = $this->admindbmodel->fetch_data_con_result($data['dataValue'][0]->area_id, 'area', 'users');
        $data['cityValue'] = $this->admindbmodel->fetch_all_data_result('cities');
        $data['productValue'] = $this->admindbmodel->fetch_all_data_result('products');
        $userData = $this->admindbmodel->fetch_data_con_result($data['dataValue'][0]->user_id, 'id', 'users');
        $dist_by_area = $this->admindbmodel->getDistributrosByAreaId($userData[0]->area);
        $data['getDistByArea'] = $dist_by_area['data']; //$this->admindbmodel->getDistributrosByAreaId($data['dataValue'][0]->area)['data'];
        $data['title'] = 'Edit Order';
        $data['main_content'] = 'orders/edit';
        $this->form_validation->set_rules('user_id', 'user', 'strip_tags|trim|required');
        $this->form_validation->set_rules('distributor_id', 'Distributor', 'strip_tags|trim|required');
        $this->form_validation->set_rules('product_id', 'Product', 'strip_tags|trim|required');
        $this->form_validation->set_rules('status', 'Status', 'strip_tags|trim|required');
        $this->form_validation->set_rules('delivery_date', 'Delivery Date', 'strip_tags|trim|required');
        $this->form_validation->set_rules('preferred_date', 'Prerred Date', 'strip_tags|trim|required');
        $this->form_validation->set_rules('shipping_address', 'Shipping Address', 'strip_tags|trim|required');
        if ($this->form_validation->run() != FALSE) {
            $delivery_date = date('Y-m-d H:i:s', strtotime($_POST['delivery_date']));
            $preffered_date = date('Y-m-d H:i:s', strtotime($_POST['preferred_date']));
            $updateData['user_id'] = $this->input->post('user_id');
            $updateData['distributor_id'] = $this->input->post('distributor_id');
            $updateData['product_id'] = $this->input->post('product_id');
            $updateData['product_amount'] = $this->input->post('product_amount');
            $updateData['shipping_address'] = $this->input->post('shipping_address');
            $updateData['status'] = $this->input->post('status');
            $delivery_date = date('Y-m-d H:i:s', strtotime($_POST['delivery_date']));
            $updateData['delivery_date'] = $delivery_date;
            $updateData['preferred_date'] = $preffered_date;
            if ($_POST['status'] == 3) {
                $updateData['cancel_by'] = 1; //by admin
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
