<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }


    public function index()
    {
        $data['title'] = 'Dasboard Member ';
        $data['next'] = 'Anda Login Sebagai <strong>User</strong>';
        $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();
        $data['project'] = $this->db->get('tb_project')->result_array();
        $data['tim'] = $this->db->get('user_tim')->result_array();
        
        $this->form_validation->set_rules('link','Admin', 'required');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function project()
    {
      $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('name','Full name', 'required|trim');

        if($this->form_validation->run() == false){
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('operator/input', $data);
        $this->load->view('templates/footer'); 
        } else {
            $nama = $this->input->post('nama');
            $keterangan = $this->input->post('keterangan');
            $link = $this->input->post('link');
            $detail = $this->input->post('detail');


            //cek jika ada gabar yang di upload
            $upload_image = $_FILES['gambar']['nama'];

            if($upload_image){
                $config['allowed_types'] = 'jpg|png|gif|jpeg|JPG|JPEG';
                $config['max_size'] = '1024000';
                $config['upload_path'] = './assets/img/uploads/';

                $this->load->library('upload', $config);

                if($this->upload->do_upload('gambar')){
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('gambar', $new_image); 
                }else{
                    echo $this->upload->display_errors();
                }
            }

            $this->db->set('nama', $nama);
            $this->db->where('email', $email);
            $this->db->update('operator');


             $this->session->set_flashdata('message', '<div class="alert alert-success" 
                    role="alert"> Your profile has been updated </div>');
                    redirect('operator/input');


        }
        
         
    
    }


public function profile()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/profile', $data);
        $this->load->view('templates/footer');
    }

    public function edit(){
      $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('name','Full name', 'required|trim');

        if($this->form_validation->run() == false){
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/edit', $data);
        $this->load->view('templates/footer'); 
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');


            //cek jika ada gabar yang di upload
            $upload_image = $_FILES['image']['name'];

            if($upload_image){
                $config['allowed_types'] = 'jpg|png|gif|jpeg|JPG|JPEG';
                $config['max_size'] = '1024000';
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);

                if($this->upload->do_upload('image')){
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image); 
                }else{
                    echo $this->upload->display_errors();
                }
            }

            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');


             $this->session->set_flashdata('message', '<div class="alert alert-success" 
                    role="alert"> Your profile has been updated </div>');
                    redirect('user/profile');


        }
        
         
    }

    public function changePassword()
    {
        $data['title'] = 'Change Password';
        $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('current_password','Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1','New Password', 'required|trim|min_length[3]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2','Confirm New Password', 'required|trim|min_length[3]|matches[new_password1]');


        if($this->form_validation->run() == false){
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/changepassword', $data);
        $this->load->view('templates/footer');
    }else{
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password1');
        if(!password_verify($current_password, $data['user']['password'])){ 
           $this->session->set_flashdata('message', '<div class="alert alert-danger" 
                    role="alert"> Wrong current password </div>');
                    redirect('user/changepassword'); 
            }else{
                if($current_password == $new_password){
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" 
                    role="alert"> New password can not be the same as current password </div>');
                    redirect('user/changepassword');
                }else{
                    //password benar
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="alert alert-success" 
                    role="alert"> Password Changed </div>');
                    redirect('user/changepassword');
                }
            }
        }
    }

    public function tim()
    {
        $data['title'] = 'Tim Support';
        $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();
        
        $data['project'] = $this->db->get('tb_project')->result_array();
        $data['tim'] = $this->db->get('user_tim')->result_array();
        $this->form_validation->set_rules('link','Admin', 'required');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/tim', $data);
        $this->load->view('templates/footer');
    }

    public function detail($id)
    {
        $data['title'] = 'DETAIL';
        $data['user'] = $this->db->get_where('user',['email' => 
            $this->session->userdata('email')])->row_array();
        $data['project'] = $this->db->get('tb_project')->result_array();

        $this->load->model('Menu_model');
        $detail = $this->Menu_model->detail_data($id);
        $data['detail'] = $detail;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/view', $data);
        $this->load->view('templates/footer');

    }
}