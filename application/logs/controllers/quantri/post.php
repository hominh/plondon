<?php
ob_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    class Post extends CI_Controller {
        protected $_data;
        public function __construct() {
            parent::__construct();
            $this->load->helper('url');
            $this->load->model('post_model');
            $this->load->model('categorypost_model');
            $this->load->library('session');
            $this->load->library('form_validation');
            $this->load->helper("slug");
            $this->load->library('ckeditor');
            $this->load->library('ckfinder');
            $this->ckeditor->basePath = base_url() . 'assets/ckeditor/';
            //Thiết lập các tool icon ckeditor
            $this->ckeditor->config['toolbar'] = array(
                array('Source', '-', 'Bold', 'Italic', 'Underline', '-',
                    'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-',
                    'Undo', 'Redo', '-', 'NumberedList', 'BulletedList',
                    'Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt',
                    'Link', 'Unlink', 'Anchor',
                    'Image', 'Flash', 'Table', 'PageBreak',
                    'Styles', 'Format', 'Font', 'FontSize',
                    'TextColor', 'BGColor', 'Code'
                ),
            );
            // Thiết lập ngôn ngữ hiển thị en => english, vi => Việt Nam , fr => Pháp
            $this->ckeditor->config['language'] = 'en';

            $this->ckeditor->config['width'] = '730px';
            $this->ckeditor->config['height'] = '200px';
            //Thêm ckfinder vào
            $this->ckfinder->SetupCKEditor($this->ckeditor, '../../../assets/ckfinder/');
        }
        public function login() {
            $logged = $this->session->userdata('logged_in');
            if ($logged) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
        public function index() {
            if ($this->login()) {
                $user = $this->session->userdata ( 'logged_in' );
                $session_data = $this->session->userdata ( 'logged_in' );
                $this->_data ['username'] = $session_data ['username'];
                $this->_data ['subview'] = 'backend/post/index_view';
                $this->_data ['titlePage'] = 'List Soft';
                $this->_data ['info'] = $this->post_model->getList();
                $this->_data ['total_new'] = $this->post_model->countAll();
                $this->load->view('backend/layout/master', $this->_data);
            }
            else {
                $this->load->view ( 'login_form' );
            }   
            
        }
        public function create() {
            $config['upload_path'] = 'assets/uploads/imagegioithieu/';
            $config['allowed_types'] = 'gif|jpg|png';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->set_allowed_types('*');
            $data['upload_data'] = '';
            if (!$this->upload->do_upload('userfile')) {
                $data = array('msg' => $this->upload->display_errors());
            } else {
                $data = array('msg' => "Upload success!");
                $data['upload_data'] = $this->upload->data();
            }
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];
            $image = base_url() . $config['upload_path'] . $file_name;
            
            if ($this->login()) { 
                $this->_data['titlePage'] = 'Thêm mới bài viết';
                $this->_data['categorypost'] = $this->categorypost_model->getSubCategory();

                $this->_data['subview'] = 'backend/post/create_view';
                $this->form_validation->set_rules("name", "name", "required|xss_clean|trim|min_length[4]|callback_check_name");
                

                if ($this->form_validation->run() == TRUE) {
                    $date = date('Y-m-d H:i:s');
                    $data_insert = array(
                        "name" => $this->input->post("name"),
                        "title" => $this->input->post("title"),
                        "description" => $this->input->post("description"),
                        "content" => $this->input->post("content"),
                        "slug" => create_slug($this->input->post("name")),
                        "meta_keyword" => $this->input->post("meta_keyword"),
                        "meta_description" => $this->input->post("meta_description"),
                        "categorypost_id" => $this->input->post("categoryfooter"),
                        "image" => $image,
                        "date_created" => $date,
                        "showhome" => $this->input->post("showhome"),
                        "top" => $this->input->post("top"),
                        "has_logo" => $this->input->post("logo")

                    );
                    $this->post_model->insert($data_insert);
                    $this->session->set_flashdata("flash_mess", "Added");
                    redirect(base_url() . "quantri/post");
                }
                $this->load->view('backend/layout/master', $this->_data);
            }
            else {
                $this->load->view ( 'login_form' );
            }
        }
        public function check_name($name) {
            $id = $this->uri->segment(3);
            if ($this->post_model->checkName($name) == FALSE) {
                $this->form_validation->set_message("check_user", "Bài viết này đã tồn tại, vui lòng nhập lại");
                return FALSE;
            } else {
                return TRUE;
            }
        }

    public function edit($id) {
        $config['upload_path'] = 'assets/uploads/imagegioithieu/';
            $config['allowed_types'] = 'gif|jpg|png';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->set_allowed_types('*');
            $data['upload_data'] = '';
            if (!$this->upload->do_upload('userfile')) {
                $data = array('msg' => $this->upload->display_errors());
            } else {
                $data = array('msg' => "Upload success!");
                $data['upload_data'] = $this->upload->data();
            }
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];
            $image = base_url() . $config['upload_path'] . $file_name;
            if ($this->login()) {
                $this->_data['titlePage'] = "Chỉnh sửa bài viết";
                $this->_data['subview'] = 'backend/post/edit_view';
                $this->_data['info'] = $this->post_model->getById($id);
                
                

                $this->_data['categorypost'] = $this->categorypost_model->getSubCategory();

                $arr = (object)$this->_data['info'];
                $id_parent = $arr->categorypost_id;
                $this->_data['chuyenmucid'] = $this->categorypost_model->getListByParentId($id_parent);
                $date = date('Y-m-d H:i:s');
                $this->form_validation->set_rules("name", "name", "required|xss_clean|trim|min_length[4]");
                if ($this->form_validation->run() == TRUE) {
                    if (!$this->upload->do_upload('userfile')) {
                        $data_update = array(
                            "name" => $this->input->post("name"),
                            "title" => $this->input->post("title"),
                            "description" => $this->input->post("description"),
                            "content" => $this->input->post("content"),
                            "slug" => create_slug($this->input->post("name")),
                            "meta_keyword" => $this->input->post("meta_keyword"),
                            "meta_description" => $this->input->post("meta_description"),
                            "categorypost_id" => $this->input->post("categorypost"),
                            "showhome" => $this->input->post("showhome"),
                            "date_created" => $date,
                            "top" => $this->input->post("top"),
                            "has_logo" => $this->input("logo")
                        );
                    }
                    else {
                        $data_update = array(
                            "name" => $this->input->post("name"),
                            "title" => $this->input->post("title"),
                            "description" => $this->input->post("description"),
                            "content" => $this->input->post("content"),
                            "slug" => create_slug($this->input->post("name")),
                            "meta_keyword" => $this->input->post("meta_keyword"),
                            "meta_description" => $this->input->post("meta_description"),
                            "categorypost_id" => $this->input->post("categorypost"),
                            "image" => $image,
                            "showhome" => $this->input->post("showhome"),
                            "date_created" => $date,
                            "top" => $this->input->post("top"),
                            "has_logo" => $this->input("logo")
                        );
                    }
                    
                    $this->post_model->update($data_update,$id);
                    $this->session->set_flashdata("flash_mess", "Cập nhật thành công");
                    redirect(base_url() . "quantri/post");
                }
                $this->load->view('backend/layout/master', $this->_data);
            }
            else {
                $this->load->view ( 'login_form' );
            }
        }
        
        public function delete($id) {
            $this->post_model->delete($id);
            $this->session->set_flashdata("flash_mess", "Delete Success");
            redirect(base_url() . "quantri/post");
        }

}

?>

