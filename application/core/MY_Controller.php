<?php
class MY_Controller extends CI_Controller{
    function __construct(){
        //kế thừa CI_controller
        parent::__construct();

        $controller = $this->uri->segment(1);
        switch($controller){
            case 'admin':
            {
                // xử lý các dữ liệu khi truy cập trang admin
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

    }
}
?>