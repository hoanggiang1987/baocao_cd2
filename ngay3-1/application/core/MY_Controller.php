<?php
class MY_Controller extends CI_Controller{
    //biến data gửi sang view
    public $data = array();
    function __construct(){
        //kế thừa CI_controller
        parent::__construct();

        $controller = $this->uri->segment(1);
        switch($controller){
            case 'admin':
            {
                // xử lý các dữ liệu khi truy cập trang admin
                $this->load->helper('admin');
                $this->_check_login();
                break;
            }
            default:{

            }
        }
    }
    /*
    * Kiểm tra trạng thái login của admin
    */
    private function _check_login(){
        $controller = $this->uri->rsegment('1');
        $controller = strtolower($controller);
        $login = $this->session->userdata('login');
        if(!$login && $controller != 'login'){
            redirect(admin_url('login'));
        }
        if($login && $controller == 'login'){
            redirect(admin_url('home'));
        }
    }
}
?>