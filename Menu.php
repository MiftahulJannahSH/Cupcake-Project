<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->ci =& get_instance();
        $this->ci->load->model('Menu_model');
    }


	public function index()
	    {
	    	$data['title'] = 'Menu Management';
	    	$data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();

	    	$data['menu'] = $this->db->get('user_menu')->result_array();

	    	$this->form_validation->set_rules('menu','Menu', 'required');

	    	if($this->form_validation->run() == FALSE){
	    		$this->load->view('templates/header', $data);
		    	$this->load->view('templates/sidebar', $data);
		    	$this->load->view('templates/topbar', $data);
		    	$this->load->view('menu/index', $data);
		    	$this->load->view('templates/footer');

	    	}else{
	    		$this->db->insert('user_menu',['menu' => $this->input->post('menu')]);
	    		$this->session->set_flashdata('message', '<div class="alert alert-success" 
                    role="alert"> New Menu Added! </div>');
                    redirect('Menu');
	    	}
	    	
	    	
	    }

	    public function submenu(){
	    	$data['title'] = 'Submenu Management';
	    	$data['user'] = $this->db->get_where('user',['email' => 
	    		$this->session->userdata('email')])->row_array();
	    		$this->load->model('Menu_model','menu');

	    	$data['subMenu'] = $this->menu->getSubMenu();
	    	$data['menu'] = $this->db->get('user_menu')->result_array();


	    	$this->form_validation->set_rules('title','Title', 'required');
	    	$this->form_validation->set_rules('menu_id','Menu', 'required');
	    	$this->form_validation->set_rules('url','Url', 'required');
	    	$this->form_validation->set_rules('icon','icon', 'required');
	    	


	    	if($this->form_validation->run() == false){
	    		$this->load->view('templates/header', $data);
		    	$this->load->view('templates/sidebar', $data);
		    	$this->load->view('templates/topbar', $data);
		    	$this->load->view('menu/submenu', $data);
		    	$this->load->view('templates/footer');
	    	} else{
	    		$data = [
	    			'title' => $this->input->post('title'),
	    			'menu_id' => $this->input->post('menu_id'),
	    			'url' => $this->input->post('url'),
	    			'icon' => $this->input->post('icon'),
	    			'is_active' => $this->input->post('is_active'),
	    		];
	    		$this->db->insert('user_sub_menu', $data);
	    		$this->session->set_flashdata('message', '<div class="alert alert-success" 
                    role="alert"> New Submenu Added! </div>');
                    redirect('Menu/submenu');
	    	}

	    }
	    //hapus
	    public function hapus_menu($id)
    	{
        $this->load->model('Menu_model');
        $this->Menu_model->hapus_menu_proses($id);
        redirect('menu','refresh');
   		}
   		public function hapus_submenu($id)
    	{
    		$where=array('id'=>$id);
        $this->Menu_model->hapus($where,'user_sub_menu');
        $this->session->set_flashdata('flash','Dihapus');
        redirect('Menu/submenu','refresh');
   		}


   		public function hapus_project($id)
    	{
        $this->load->model('Menu_model');
        $this->Menu_model->hapus_project_proses($id);
        redirect('operator','refresh');
   		}

		//edit
   		    public function edit($id){
   		    $data['title'] = 'Edit Submenu';
	    	$data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();

      		$where=array('id'=> $id);
      		$data['subMenu'] = $this->Menu_model->ambil_where($where, 'user_sub_menu')->result();
      		//$this->load->view('edit', $data);

	    	$this->form_validation->set_rules('menu',' Full Menu', 'required');
	        if($this->form_validation->run() == false){
	        $this->load->view('templates/header', $data);
	        $this->load->view('templates/sidebar', $data);
	        $this->load->view('templates/topbar', $data);
	        $this->load->view('menu/edit', $data);
	        $this->load->view('templates/footer'); 
	        } else {
           
            $this->db->update('user_sub_menu');  
                    redirect('menu');


        }
         }


        function proses_edit(){
        	$id=$this->input->post('id');
        	$menu_id=$this->input->post('menu_id');
        	$title=$this->input->post('title');
        	$url=$this->input->post('url');
        	$icon=$this->input->post('icon');

        	$data=array(
        		'menu_id' => $menu_id,
        		'title' => $title,
        		'url' => $url,
        		'icon' => $icon

				);
        	$where=array('id' => $id);

        	$this->Menu_model->update($where, $data, 'user_sub_menu');
        	$this->session->set_flashdata('message', '<div class="alert alert-success" 
                    role="alert"> Submenu has been updated </div>');
        	redirect('Menu/submenu');
         
    }

    	function hapus($id)
        {
            $where=array('id' => $id);

        $this->Menu_model->hapus_sm($where, 'user_sub_menu');
        $this->session->set_flashdata('message', '<div class="alert alert-success" 
                    role="alert"> Submenu has been deleted </div>');
        redirect('Menu/submenu','refresh');
        }
       


   		
}