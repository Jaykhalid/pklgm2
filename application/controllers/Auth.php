<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    //     public function __construct()
    //     {
    //         parent::__construct();
    //         $this->load->library('form_validation');
    //         $this->load->helper('url');
    //     }

    //     public function login()
    //     {
    //         $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    //         $this->form_validation->set_rules('password', 'Password', 'trim|required');


    //         if ($this->form_validation->run() == false) {
    //             $data['title'] = 'Login Pages';
    //             $this->load->view('templates/auth_header', $data);
    //             $this->load->view('auth/login');
    //             $this->load->view('templates/auth_footer');
    //         } else {
    //             //validasinya success
    //             $this->_login();
    //         }
    //     }


    //     private function _login()
    //     {
    //         $email = $this->input->post('email');
    //         $password = $this->input->post('password');

    //         $user = $this->db->get_where('user', ['email' => $email])->row_array();


    //         //jika usernya ada
    //         if ($user) {
    //             //jika usernya aktif
    //             if ($user['is_active'] == 1) {
    //                 //cek password
    //                 if (password_verify($password, $user['password'])) {
    //                     $data = [
    //                         'email' => $user['email'],
    //                         'role_id' => $user['role_id']
    //                     ];
    //                     $this->session->set_userdata($data);
    //                     redirect('home');
    //                 } else {
    //                     $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Wrong password! </div>');
    //                     redirect('auth/login');
    //                 }
    //             } else {
    //                 $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> This email has not been activated ! </div>');
    //                 redirect('auth/login');
    //             }
    //         } else {

    //             $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Email is not registered! </div>');
    //             redirect('auth/login');
    //         }
    //     }



    //     public function registration()
    //     {
    //         $this->form_validation->set_rules('name', 'Name', 'required|trim');
    //         $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
    //             'is_unique' => 'this email has already registered!'
    //         ]);
    //         $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
    //             'matches' => 'Password dont match!',
    //             'min_length' => 'Password too short!'
    //         ]);
    //         $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[3]|matches[password1]');

    //         if ($this->form_validation->run() == false) {
    //             $data['title'] = 'WPU User Registration';

    //             $this->load->view('templates/auth_header', $data);
    //             $this->load->view('auth/registration');
    //             $this->load->view('templates/auth_footer');
    //         } else {
    //             $email = $this->input->post('email', true);
    //             $data = [
    //                 'name' => htmlspecialchars($this->input->post('name', true)),
    //                 'email' => htmlspecialchars($email),
    //                 'image' => 'default.jpg',
    //                 'password' => password_hash(
    //                     $this->input->post('password1'),
    //                     PASSWORD_DEFAULT
    //                 ),
    //                 'role_id' => 2,
    //                 'is_active' => 0,
    //                 'date_created' => time()
    //             ];

    //             //siapakan token
    //             $token = base64_encode(random_bytes(32));
    //             $user_token = [
    //                 'email' => $email,
    //                 'token' => $token,
    //                 'date_created' => time()
    //             ];


    //             $this->db->insert('user', $data);
    //             $this->db->insert('user_token', $user_token);

    //             $this->_sendEmail($email, 'verify');

    //             $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Congratulation! your acccount has been created. Please activate your account </div>');
    //             redirect('auth');
    //         }
    //     }


    //     private function _sendEmail($token, $type)
    //     {
    //         $config = [
    //             'protocol'  => 'smtp',
    //             'smtp_host' => 'ssl://smtp.googlemail.com',
    //             'smtp_user' => 'toniindriyanto27@gmail.com',
    //             'smtp_pass' => '089605533669',
    //             'smtp_port' => 465,
    //             'mailtype'  => 'html',
    //             'charset'   => 'utf-8',
    //             'newline'   => "r/n"
    //         ];

    //         $this->load->initialize('email', $config);

    //         $this->email->from('toniindriyanto27@gmail.com', 'Toni Indriyanto');
    //         $this->email->to($this->input->post('email'));

    //         if ($type == 'verify') {
    //             $this->email->subject('Account Verification');
    //             $this->email->message('Click this link to verify you account : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '"> Activate </a>');
    //         } else if ($type == 'forgot') {
    //             $this->email->subject('Reset Password');
    //             $this->email->message('Click this link to reset your password : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '"> Reset Password </a>');
    //         }

    //         if ($this->email->send()) {
    //             return true;
    //         } else {
    //             echo $this->email->print_debugger();
    //             die;
    //         }
    //     }


    //     public function verify()
    //     {
    //         $email = $this->input->get('email');
    //         $token = $this->input->get('token');

    //         $user = $this->db->get_where('user', ['email' => $email])->row_array();

    //         if ($user) {
    //             $user_token = $this->db->get_where('user', ['token' => $token])->row_array();

    //             if ($user_token) {
    //                 if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
    //                     $this->db->set('is_active', 1);
    //                     $this->db->where('email', $email);
    //                     $this->db->update('user');

    //                     $this->db->delete('user_token', ['email' => $email]);

    //                     $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> ' . $email . ' has been activated! Please login. </div>');
    //                     redirect('auth/login');
    //                 } else {

    //                     $this->db->delete('user', ['email' => $email]);
    //                     $this->db->delete('user_token', ['email' => $email]);

    //                     $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Account activation failed! Wrong expired. </div>');
    //                     redirect('auth/login');
    //                 }
    //             } else {
    //                 $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Account activation failed! Wrong token. </div>');
    //                 redirect('auth/login');
    //             }
    //         } else {
    //             $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Account activation failed! Wrong email. </div>');
    //             redirect('auth/login');
    //         }
    //     }


    //     public function logout()
    //     {
    //         $this->session->unset_userdata('email');
    //         $this->session->unset_userdata('role_id');

    //         $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> You have been logout! </div>');
    //         redirect('auth/login');
    //     }

    //     public function forgotpassword()
    //     {
    //         $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    //         if ($this->form_validation->run() == false) {
    //             $data['title'] = 'Forgot Passwrod';
    //             $this->load->view('templates/auth_header', $data);
    //             $this->load->view('auth/forgot-password');
    //             $this->load->view('templates/auth_footer');
    //         } else {
    //             $email = $this->input->post('email');
    //             $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

    //             if ($user) {
    //                 $token = base64_encode(random_bytes(32));
    //                 $user_token = [
    //                     'email' => $email,
    //                     'token' => $token,
    //                     'date_created' => time()
    //                 ];

    //                 $this->db->insert('user_token', $user_token);
    //                 $this->_sendEmail($token, 'forgot');

    //                 $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Please your email to reset your password! </div>');
    //                 redirect('auth/forgotpassword');
    //             } else {

    //                 $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Email is not registered or activated! </div>');
    //                 redirect('auth/forgotpassword');
    //             }
    //         }
    //     }


    //     public function resetpassword()
    //     {
    //         $email = $this->input->get('email');
    //         $token = $this->input->get('token');

    //         $user = $this->db->get_where('user', ['email' => $email])->row_array();

    //         if ($user) {
    //             $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
    //             if ($user_token) {
    //                 $this->session->set_userdata('reset_email', $email);
    //                 $this->changepassword();
    //             } else {
    //                 $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Account activation failed! Wrong token. </div>');
    //                 redirect('auth/login');
    //             }
    //         } else {
    //             $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Account activation failed! Wrong email. </div>');
    //             redirect('auth/login');
    //         }
    //     }

    //     public function changepassword()
    //     {
    //         if (!$this->session->userdata('reset_email')) {
    //             redirect();
    //         }
    //         $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[3]matches[password2]');
    //         $this->form_validation->set_rules('password2', 'Repeat password', 'trim|required|min_length[3]matches[password1 ]');

    //         if ($this->form_validation->run() == false) {
    //             $data['title'] = 'Change Passwrod';
    //             $this->load->view('templates/auth_header', $data);
    //             $this->load->view('auth/change-password');
    //             $this->load->view('templates/auth_footer');
    //         } else {

    //             $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
    //             $email = $this->session->user_data('reset_email');

    //             $this->db->set('password', $password);
    //             $this->db->where('email', $email);
    //             $this->db->update('user');

    //             $this->session->unset_userdata('reset_email');
    //             $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Password has been changed! Please login. </div>');
    //             redirect('auth/login');
    //         }
    //     }

    public function index()
    {
        $this->send_mail();
    }


    public function send_mail()
    {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => '465',
            'smtp_user' => 'toniindriyanto27@gmail.com',
            'smtp_pass' => '089605533669',
            'mailtype' => 'html',
            'charset'  => 'iso-8859-1',
            'wordwrap' => TRUE
        );

        $message = "hello word !";
        $this->load->library('email', $config);
        $this->email->set_newline("r\n");
        $this->email->from('toniindriyanto27@gmail.com');
        $this->email->to('toniindriyanto27@gmail.com');
        $this->email->subject('subject : Send Mail');
        $this->email->message($message);
        if ($this->email->send()) {
            echo 'Email sent.';
        } else {
            show_error($this->email->print_debugger());
        }
    }
}
