<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

	public function index()
    {
        
    	$data['title'] = 'Dasboard ';
        $data['next'] = 'Anda Login Sebagai <strong>Admin</strong>';
    	$data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();
    	
        $data['project'] = $this->db->get('tb_project')->result_array();
        $this->form_validation->set_rules('link','Admin', 'required');

        $data['tim'] = $this->db->get('user_tim')->result_array();

        if($this->form_validation->run() == FALSE){
    	$this->load->view('templates/header', $data);
    	$this->load->view('templates/sidebar', $data);
    	$this->load->view('templates/topbar', $data);
    	$this->load->view('admin/index', $data);
    	$this->load->view('templates/footer');

        } else{
                $data = [
                    'nama' => $this->input->post('nama'),
                    'keterangan' => $this->input->post('keterangan'),
                    'link' => $this->input->post('link'),
                    'gambar' => $this->input->post('gambar'),
                ];
                $this->db->insert('tb_project', $data);
                $this->session->set_flashdata('message', '<div class="alert alert-success" 
                    role="alert"> New Project Added! </div>');
                    redirect('Admin');
            }
        }

        
    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }

    public function roleAccess($role_id)
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user',['email' => 
            $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);

        $data['menu'] = $this->db->get('user_menu')->result_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
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


public function changeAccess(){
    $menu_id = $this->input->post('menuId');
    $role_id = $this->input->post('roleId');

    $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];


        $result = $this->db->get_where('user_access_menu', $data);

        if($result->num_rows() < 1){
            $this->db->insert('user_access_menu', $data);

        }else{
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Access Change </div>');
    
}

        public function roleedit($id){
            $data['title'] = 'Edit Role';
            $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();

            $where=array('id'=> $id);
            $data['Role'] = $this->Menu_model->ambilkantu_where($where, 'user_access_menu')->result();
            //$this->load->view('edit', $data);

            $this->form_validation->set_rules('menu',' Full Menu', 'required');
            if($this->form_validation->run() == false){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/roleedit', $data);
            $this->load->view('templates/footer'); 
            } else {
           
            $this->db->update('user_access_menu');  
                    redirect('admin/role');


        }
         }


        function proses_edit(){
            $id=$this->input->post('id');
            $role_id=$this->input->post('role_id');
            $menu_id=$this->input->post('menu_id');
           

            $data=array(
                'role_id' => $role_id,
                'menu_id' => $menu_id
                

                );
            $where=array('id' => $id);

            $this->Menu_model->update($where, $data, 'user_access_menu');
            $this->session->set_flashdata('message', '<div class="alert alert-success" 
                    role="alert"> Role has been updated </div>');
            redirect('admin/role');
         
    }
        
}



