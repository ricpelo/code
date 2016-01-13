<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Articulos extends CI_Controller
{
    public function index()
    {
        $data['filas'] = $this->db->query('select * from articulos')->result_array();
        $this->load->view('articulos/index', $data);
    }

    public function borrar($id = NULL)
    {
        if ($this->input->post('borrar') !== NULL)
        {
            $id = $this->input->post('id');
            if ($id !== NULL)
            {
                $this->db->query("delete from articulos where id = ?", array($id));
            }
            redirect('articulos/index');
        }
        else
        {
            if ($id === NULL)
            {
                redirect('articulos/index');
            }
            else
            {
                $res = $this->db->query('select * from articulos where id = ?', array($id));
                if ($res->num_rows() === 0)
                {
                    redirect('articulos/index');
                }
                else
                {
                    $data = $res->row_array();
                    $this->load->view('articulos/borrar', $data);
                }
            }
        }
    }
}
