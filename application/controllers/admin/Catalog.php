<?php
class Catalog extends MY_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('catalog_model');
    }
    function index(){
        $list = $this->catalog_model->get_list();
        $this->data['list'] = $list;
        //lấy nội dung message
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message;
        //load ra view
        $this->data['temp'] = 'admin/catalog/index';
        $this->load->view('admin/main',$this->data);
    }
    //thêm mới dữ liệu
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
        $this->data['temp'] = 'admin/catalog/add';
        $this->load->view('admin/main',$this->data);
    }
}
?>