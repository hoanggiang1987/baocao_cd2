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
            $this->form_validation->set_rules('name','Tên','required');
            
            if($this->form_validation->run()){
                $name = $this->input->post('name');
                $parent_id = $this->input->post('parent_id');
                $sort_order = $this->input->post('sort_order');
                $data = array(
                    'name' => $name,
                    'parent_id' => $parent_id,
                    'sort_order' => intval($sort_order)
                );
                if($this->catalog_model->create($data)){
                    $this->session->set_flashdata('message','Thêm mới thành công');
                }
                else{
                    $this->session->set_flashdata('message','Thêm mới thất bại');
                }
                //chuyen tới trang danh sách
                redirect(admin_url('catalog'));
            }
        }
        //lay danh sach danh muc 
        $input= array();
        $input['where'] = array('parent_id' => 0);
        $list = $this->catalog_model->get_list($input);
        $this->data['list'] = $list;

        $this->data['temp'] = 'admin/catalog/add';
        $this->load->view('admin/main',$this->data);
    }
    
    //cập nhật dữ liệu
    function edit(){
        $this->load->library('form_validation');
        $this->load->helper('form');
        $id = $this->uri->rsegment('3');
        $info = $this->catalog_model->get_info($id);
        if(!$info){
            $this->session->set_flashdata('message','Không tồn tại danh mục này');
            redirect(admin_url('catalog'));
        }
        $this->data['info'] = $info;
        if($this->input->post()){
            $this->form_validation->set_rules('name','Tên','required');
            
            if($this->form_validation->run()){
                $name = $this->input->post('name');
                $parent_id = $this->input->post('parent_id');
                $sort_order = $this->input->post('sort_order');
                $data = array(
                    'name' => $name,
                    'parent_id' => $parent_id,
                    'sort_order' => intval($sort_order)
                );
                if($this->catalog_model->update($id, $data)){
                    $this->session->set_flashdata('message','Cập nhật thành công');
                }
                else{
                    $this->session->set_flashdata('message','Cập nhật thất bại');
                }
                //chuyen tới trang danh sách
                redirect(admin_url('catalog'));
            }
        }
        //lay danh sach danh muc 
        $input= array();
        $input['where'] = array('parent_id' => 0);
        $list = $this->catalog_model->get_list($input);
        $this->data['list'] = $list;

        $this->data['temp'] = 'admin/catalog/edit';
        $this->load->view('admin/main',$this->data);
    }

    //function delete

    function delete()
    {
        //lay id danh mục
        $id = $this->uri->rsegment(3);
        $this->_del($id);
        
        //tạo ra nội dung thông báo
        $this->session->set_flashdata('message', 'Xóa dữ liệu thành công');
        redirect(admin_url('catalog'));
    }
    
    /*
     * Xoa nhieu danh muc san pham
     */
    function delete_all()
    {
        $ids = $this->input->post('ids');
        foreach ($ids as $id)
        {
            $this->_del($id , false);
        }
    }
    
    /*
     * Thuc hien xoa
     */
    private function _del($id, $rediect = true)
    {
        $info = $this->catalog_model->get_info($id);
        if(!$info)
        {
            //tạo ra nội dung thông báo
            $this->session->set_flashdata('message', 'không tồn tại danh mục này');
            if($rediect)
            {
                redirect(admin_url('catalog'));
            }else{
                return false;
            }
        }
        
        //kiem tra xem danh muc nay co san pham khong
        $this->load->model('product_model');
        $product = $this->product_model->get_info_rule(array('catalog_id' => $id), 'id');
        if($product)
        {
            //tạo ra nội dung thông báo
            $this->session->set_flashdata('message', 'Danh mục '.$info->name.' có chứa sản phẩm,bạn cần xóa các sản phẩm trước khi xóa danh mục');
            if($rediect)
            {
                redirect(admin_url('catalog'));
            }else{
                return false;
            }
        }
        
        //xoa du lieu
        $this->catalog_model->delete($id);
        
    }
}
?>