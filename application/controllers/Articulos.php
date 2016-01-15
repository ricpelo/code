<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Articulos extends CI_Controller
{
    public function index()
    {
        $data['filas'] = $this->Articulo->todos();
        $this->load->view('articulos/index', $data);
    }

    public function insertar()
    {
        if ($this->input->post('insertar') !== NULL)
        {
            $reglas = array(
                array(
                    'field' => 'codigo',
                    'label' => 'Código',
                    'rules' => 'trim|required|ctype_digit|max_length[13]|is_unique[articulos.codigo]',
                    'errors' => array(
                        'ctype_digit' => 'El campo %s debe contener sólo dígitos.'
                    )
                ),
                array(
                    'field' => 'descripcion',
                    'label' => 'Descripción',
                    'rules' => 'trim|required|max_length[50]'
                ),
                array(
                    'field' => 'precio',
                    'label' => 'Precio',
                    'rules' => 'trim|required|numeric|less_than_equal_to[9999.99]'
                ),
                array(
                    'field' => 'existencias',
                    'label' => 'Existencias',
                    'rules' => 'trim|integer|greater_than_equal_to[-2147483648]|less_than_equal_to[+2147483647]'
                )
            );
            $this->form_validation->set_rules($reglas);
            if ($this->form_validation->run() !== FALSE)
            {
                $valores = $this->input->post();
                unset($valores['insertar']);
                $this->Articulo->insertar($valores);
                redirect('articulos/index');
                return;
            }
        }
        $this->load->view('articulos/insertar');
    }

    public function editar($id = NULL)
    {
        if ($this->input->post('editar') !== NULL)
        {
            $reglas = array(
                array(
                    'field' => 'codigo',
                    'label' => 'Código',
                    'rules' => 'trim|required|ctype_digit|max_length[13]|is_unique[articulos.codigo]',
                    'errors' => array(
                        'ctype_digit' => 'El campo %s debe contener sólo dígitos.'
                    )
                ),
                array(
                    'field' => 'descripcion',
                    'label' => 'Descripción',
                    'rules' => 'trim|required|max_length[50]'
                ),
                array(
                    'field' => 'precio',
                    'label' => 'Precio',
                    'rules' => 'trim|required|numeric|less_than_equal_to[9999.99]'
                ),
                array(
                    'field' => 'existencias',
                    'label' => 'Existencias',
                    'rules' => 'trim|integer|greater_than_equal_to[-2147483648]|less_than_equal_to[+2147483647]'
                )
            );
            $this->form_validation->set_rules($reglas);
            if ($this->form_validation->run() !== FALSE)
            {
                $valores = $this->input->post();
                unset($valores['editar']);
                $this->Articulo->editar($valores);
                redirect('articulos/index');
                return;
            }
        }
        $valores = $this->Articulo->por_id($id);
        $data = $valores;
        $this->load->view('articulos/editar', $data);
    }

    public function borrar($id = NULL)
    {
        if ($this->input->post('borrar') !== NULL)
        {
            $id = $this->input->post('id');
            if ($id !== NULL)
            {
                $this->Articulo->borrar($id);
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
                $res = $this->Articulo->por_id($id);
                if ($res === FALSE)
                {
                    redirect('articulos/index');
                }
                else
                {
                    $data = $res;
                    $this->load->view('articulos/borrar', $data);
                }
            }
        }
    }
}
