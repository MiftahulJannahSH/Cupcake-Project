<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Operator extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }


    public function index()
    {
        $data['title'] = 'Dasboard Operator';
        $data['next'] = 'Anda Login Sebagai <strong>Operator</strong>';
        $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();
        $data['tim'] = $this->db->get('user_tim')->result_array();
                
        $data['role'] = $this->db->get('user_role')->result_array();
        $data['project'] = $this->db->get('tb_project')->result_array();
        $this->form_validation->set_rules('link','Operator', 'required');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('operator/index', $data);
        $this->load->view('templates/footer');
    }

	public function input()
    {
    	$data['title'] = 'Input Project ';
        $data['next'] = 'Anda Login Sebagai <strong>Operator</strong>';
        $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();
        
        $data['project'] = $this->db->get('tb_project')->result_array();
        $this->form_validation->set_rules('link','Admin', 'required');

        $data['tim'] = $this->db->get('user_tim')->result_array();

        if($this->form_validation->run() == FALSE){
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('operator/input', $data);
        $this->load->view('templates/footer');

         }else{
                    $nama       = $this->input->post('nama');
                    $keterangan = $this->input->post('keterangan');
                    $link       = $this->input->post('link');
                    $detail     = $this->input->post('detail');
                    $gambar     = $_FILES['gambar'];
                
                if($gambar=''){}else{
                $config['upload_path'] = './assets/img/uploads/'; 
                $config['allowed_types'] ='jpg|png|gif|jpeg|JPG|JPEG|jfif';
                $config['max_size'] = '1024000';
                
                $this->load->library('upload', $config);
                    if(!$this->upload->do_upload('gambar')){
                        echo "uploads gagal"; die();
                    }else{
                        $gambar=$this->upload->data('file_name');
                    }
                }
                $data = array(
                    'nama' => $nama ,
                    'keterangan' => $keterangan ,
                    'link' => $link ,
                    'detail' => $detail ,
                    'gambar' => $gambar 

                     );
                
                $this->Menu_model->input_data($data, 'tb_project');

             $this->session->set_flashdata('message', '<div class="alert alert-success" 
                    role="alert"> Your profile has been updated </div>');
                    redirect('operator/input');


        }
}
        

        

    //edit
        function edit($id){
        $data['title'] = 'Edit Project';
        $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();    
           $where=array('id'=> $id);

        $data['project'] = $this->Menu_model->ambilkan_where($where, 'tb_project')->result();
           

            $this->form_validation->set_rules('name','Full name', 'required|trim');
            if($this->form_validation->run() == false){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('operator/edit', $data);
            $this->load->view('templates/footer'); 
            } else {
           
            $this->db->update('tb_project');  
                    redirect('operator');
         }
     }

        function proses_edit(){
          $id=$this->input->post('id');
            $nama=$this->input->post('nama');
            $keterangan=$this->input->post('keterangan');
            $link=$this->input->post('link');
            $gambar=$this->input->post('gambar');

            $data=array(
                'nama' => $nama,
                'keterangan' => $keterangan,
                'link' => $link,
                'gambar' => $gambar

                );
            $where=array('id' => $id);

            $this->Menu_model->update($where, $data, 'tb_project');
            $this->session->set_flashdata('message', '<div class="alert alert-success" 
                    role="alert"> Project has been updated </div>');
            redirect('operator/input');
         
     }


        function hapus($id)
        {
            $where=array('id' => $id);

        $this->Menu_model->hapus($where, 'tb_project');
        $this->session->set_flashdata('message', '<div class="alert alert-success" 
                    role="alert"> Project has been deleted </div>');
        redirect('operator/input','refresh');
        }


         function detail($id)
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

            