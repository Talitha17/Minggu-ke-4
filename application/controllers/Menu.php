<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function index()
    {
        $data['title'] = 'Menu Management';
        $data['users'] = $this->db->get_where('users', ['email' =>
        $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            New menu added! </div>');
            redirect('menu');
        }
    }
    public function submenu()
    {
        $data['title'] = 'Sub Menu Management';
        $data['users'] = $this->db->get_where('users', ['email' =>
        $this->session->userdata('email')])->row_array();

        $data['subMenu'] = $this->db->get('user_sub_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('menu/submenu', $data);
        $this->load->view('templates/footer');
    }
    public function hapus($id)
    {
        $where = array('id' => $id);
        $this->session->hapus_data($where, 'users');
        redirect('menu');
    }
}
