<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Articulos extends CI_Controller
{
    private $reglas_comunes = array(
        array(
            'field' => 'codigo',
            'label' => 'Código',
            'rules' => 'trim|required|ctype_digit|max_length[13]',
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

    public function index()
    {
        $data['filas'] = $this->Articulo->todos();
        $this->load->view('articulos/index', $data);
    }

    public function insertar()
    {
        if ($this->input->post('insertar') !== NULL)
        {
            $reglas = $this->reglas_comunes;
            $reglas[0]['rules'] .= '|is_unique[articulos.codigo]';
            $this->form_validation->set_rules($reglas);
            if ($this->form_validation->run() !== FALSE)
            {
                $valores = $this->limpiar('insertar', $this->input->post());
                $this->Articulo->insertar($valores);
                redirect('articulos/index');
            }
        }
        $this->load->view('articulos/insertar');
    }

    public function editar($id = NULL)
    {
        if ($id === NULL)
        {
            redirect('articulos/index');
        }

        $id = trim($id);

        if ($this->input->post('editar') !== NULL)
        {
            $reglas = $this->reglas_comunes;
            $reglas[0]['rules'] .= "|callback__codigo_unico[$id]";
            $this->form_validation->set_rules($reglas);
            if ($this->form_validation->run() !== FALSE)
            {
                $valores = $this->limpiar('editar', $this->input->post());
                $this->Articulo->editar($valores, $id);
                redirect('articulos/index');
            }
        }
        $valores = $this->Articulo->por_id($id);
        if ($valores === FALSE)
        {
            redirect('articulos/index');
        }
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

    public function _codigo_unico($codigo, $id)
    {
        $res = $this->Articulo->por_codigo($codigo);

        if ($res === FALSE || $res['id'] === $id)
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('_codigo_unico',
                'El {field} debe ser único.');
            return FALSE;
        }
    }

    private function limpiar($accion, $valores)
    {
        unset($valores[$accion]);
        if ($valores['existencias'] === '')
        {
            $valores['existencias'] = NULL;
        }

        return $valores;
    }
}
