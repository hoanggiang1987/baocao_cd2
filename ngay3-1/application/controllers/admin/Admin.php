<?php
class Admin extends MY_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('admin_model');
    }
    function index(){
        $input = array();
        $list = $this->admin_model->get_list($input);
        $this->data['list'] = $list;

        $total = $this->admin_model->get_total();
        $this->data['total'] = $total;
        //lấy nội dung message
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;

        $this->data['temp'] = 'admin/admin/index';
        $this->load->view('admin/main',$this->data);
    }
    //function check username đã tồn tại chưa
    function check_username(){
        $username = $this->input->post('username');
        $where = array('username' => $username);
        //Kiểm tra username đã tồn tại chưa
        if($this->admin_model->check_exists($where)){
            $this->form_validation->set_message(__FUNCTION__,'Tài khoản đã tồn tại');
            return false;
        }
        return true;
    }
    
    //function add admin
    function add(){
        $this->load->library('form_validation');
        $this->load->helper('form');
        if($this->input->post()){
            $this->form_validation->set_rules('name','Tên','required|min_length[8]');
            $this->form_validation->set_rules('username','Tài khoản đăng nhập','required|callback_check_username');
            $this->form_validation->set_rules('password','Mật khẩu','required|min_length[6]');
            $this->form_validation->set_rules('re_password', 'Nhập lại mật khẩu', 'matches[password]');
            if($this->form_validation->run()){
                $name = $this->input->post('name');
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $data = array(
                    'name' => $name,
                    'username' => $username,
                    'password' => md5($password)
                );
                if($this->admin_model->create($data)){
                    $this->session->set_flashdata('message','Thêm mới thành công');
                }
                else{
                    $this->session->set_flashdata('message','Thêm mới thất bại');
                }
                //chuyen tới trang danh sách
                redirect(admin_url('admin'));
            }
        }
        $this->data['temp'] = 'admin/admin/add';
        $this->load->view('admin/main',$this->data);
    }
    function edit(){
        $this->load->library('form_validation');
        $this->load->helper('form');
        $id = $this->uri->rsegment('3');
        $id = intval($id);
        $info = $this->admin_model->get_info($id);
        if(!$info){
            $this->session->set_flashdata('message','Không tồn tại id quản trị viên này');
            redirect(admin_url('admin'));
        }
        $this->data['info'] = $info;
        if($this->input->post()){
            $this->form_validation->set_rules('name','Tên','required|min_length[8]');
            $this->form_validation->set_rules('username','Tài khoản đăng nhập','required');
            $password = $this->input->post('password');
            if($password){
                $this->form_validation->set_rules('password','Mật khẩu','required|min_length[6]');
                $this->form_validation->set_rules('re_password', 'Nhập lại mật khẩu', 'matches[password]');
            }
            if($this->form_validation->run()){
                $name = $this->input->post('name');
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $data = array(
                    'name' => $name,
                    'username' => $username,
                );
                if($password){
                    $data['password'] = md5($password);
                }
                if($this->admin_model->update($id,$data)){
                    $this->session->set_flashdata('message','Cập nhật thành công');
                }
                else{
                    $this->session->set_flashdata('message','Cập nhật thất bại');
                }
                //chuyen tới trang danh sách
                redirect(admin_url('admin'));
            }
        }
        $this->data['temp'] = 'admin/admin/edit';
        $this->load->view('admin/main',$this->data);
    }

    //function xóa dữ liệu
    function delete(){
        $id = $this->uri->rsegment('3');
        $id = intval($id);
        $info = $this->admin_model->get_info($id);
        if(!$info){
            $this->session->set_flashdata('message','Không tồn tại id quản trị viên này');
            redirect(admin_url('admin'));
        }
        //Thực hiện xóa
        $this->admin_model->delete($id);
        $this->session->set_flashdata('message','Xóa thành công');
        redirect(admin_url('admin'));
    }
    //đăng xuất
    function logout(){
        if($this->session->userdata('login')){
            $this->session->unset_userdata('login');
        }
        redirect(admin_url('login'));
    }
}