<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
       $this->load->view('auth/utama');  
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        //jika user ada 
        if ($user) {
            //user aktif
            if ($user['is_active'] == 1) {
                //cek password      
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if($user['role_id'] == 1){
                         redirect(admin);
                    }else if($user['role_id'] == 2){
                        redirect(operator);
                    }else{
                       redirect(user); 
                    }
                    
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" 
                    role="alert"> Wrong Password </div>');
                    redirect('auth/login');
                }

                }else{
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" 
                role="alert"> This email has not been actived!! </div>');
                redirect('auth/login');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" 
            role="alert"> Email is not Registered </div>');
            redirect('Auth/login');
        }
    }


    public function registration()
    {
        if($this->session->userdata('email')){
            redirect('user');
        }
        
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]',[
            'is_unique' => 'this email has already registed!']);

        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'password dont matches',
            'min_length' => 'Password too short'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->library('form_validation');
            $data['title'] = 'User Registration';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email', true);
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($email),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 3,
                'is_active' => 0,
                'date_created' => time()
            ];

            //siapkan token
            $token = base64_encode(openssl_random_pseudo_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];


            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);

            $this->_sendEmail($token, 'verify');


            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Congratulation! 
                    Your account has been created. Please Activated your Account </div>');
            redirect('auth/login');
        }
      }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol'    => 'smtp',
            'smtp_host'   => 'ssl://smtp.googlemail.com',
            'smtp_user'   => 'team.03cupcake@gmail.com',
            'smtp_pass'   => 'hamdi4677',
            'smtp_port'   => 465, 
            'mailtype'    => 'html',
            'wordwrap'    => TRUE,
            'charset'     => 'utf-8',
            'newline'     => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);

        $this->email->from('team.03cupcake@gmail.com','Cupcake Project');
        $this->email->to($this->input->post('email'));

        if($type == 'verify') {
            $this->email->subject('Account Verification');
            $this->email->message('Click this link to verify your account <br> <a href="'. base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '"><button>Activated </button></a>');
        }else if($type == 'forgot'){
            $this->email->subject('Reset Password');
            $this->email->message('Click this link to reset your password : <a href="'. base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
        }
        


         if($this->email->send()) {
            return true;
         } else{
            echo $this->email->print_debugger();
            die;
         }

    } 

    public function verify(){

        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if($user){
         $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array(); 
         
         if($user_token){
            if(time() - $user_token['date_created'] < (60 * 60 * 24)){
                $this->db->set('is_active', 1);
                $this->db->where('email', $email);
                $this->db->update('user');

                $this->db->delete('user_token', ['email' => $email]);

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'. $email .' has been Activated! Please Login</div>');
            redirect('auth/login');


            }else{

            $this->db->delete('user', ['email' => $email]);
            $this->db->delete('user_token', ['email' => $email]);

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Account activation failed! Token Expired. </div>');
            redirect('auth/login'); 
            }

         }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Account activation failed! Wrong token. </div>');
            redirect('auth/login');
         }  

        }else{
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Account activation failed! Wrong email. </div>');
            redirect('auth/login');  
        }


    }  

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> You have been Loggin Out </div>');
            redirect('auth/login');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');

    }

    public function forgotPassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        if ($this->form_validation->run() == FALSE) {
        $data['title'] = 'Forgot Password';
        $this->load->view('templates/auth_header', $data);
        $this->load->view('auth/forgot-pass');
        $this->load->view('templates/auth_footer'); 
        }else{
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

            if($user) {
                $token = base64_encode(openssl_random_pseudo_bytes(32));
                $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];

            $this->db->insert('user_token', $user_token);
            $this-> _sendEmail($token, 'forgot');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Please check your Email to Reset your password! </div>');
                redirect('auth/forgotpassword'); 

            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Email is not Registered or Activated! </div>');
                redirect('auth/forgotpassword'); 
            }
        }
    }


    public function resetPassword(){
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if($user){
         $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if($user_token){
                $this->session->set_userdata('reset_email', $email);
                $this->changePassword();

        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Reset Password failed! Wrong Token </div>');
                redirect('auth/login'); 
          }

        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Reset Password failed! Wrong Email </div>');
                redirect('auth/login'); 
        }
    }

    public function changePassword()
    {
        if(!$this->session->userdata('reset_email')){
            redirect('auth');
        }

        $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[3]|matches[password2]');
         $this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[3]|matches[password1]');

        if ($this->form_validation->run() == FALSE) {
        $data['title'] = 'Change Password';
        $this->load->view('templates/auth_header', $data);
        $this->load->view('auth/change-pass');
        $this->load->view('templates/auth_footer'); 
        }else{
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Password has been Change. Please Login!</div>');
                redirect('auth/login'); 
        }
    }

    public function login(){
        if($this->session->userdata('email')){
            redirect('user');
        }

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Login Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            $this-> _login();
        }
    }

     public function features()
    {
       $this->load->view('auth/features');
        

    }
     public function contact()
    {
        $this->load->view('auth/contact');

    }
    public function portofolio()
    {
        $this->load->view('auth/portofolio');

    }
    public function team()
    {
        $this->load->view('auth/team');

    }
     public function home()
    {
        $this->load->view('auth/home');

    }
}