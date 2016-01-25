<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller
{
    private $reglas_comunes = array(
        array(
            'field' => 'nick',
            'label' => 'Nick',
            'rules' => 'trim|required|max_length[15]'
        ),
        array(
            'field' => 'password',
            'label' => 'Contraseña',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'password_confirm',
            'label' => 'Confirmar contraseña',
            'rules' => 'trim|required|matches[password]'
        ),
        array(
            'field' => 'rol_id',
            'label' => 'Rol',
            'rules' => 'trim|callback__existe_rol'
        )
    );

    public function index()
    {
        $data['filas'] = $this->Usuario->todos();
        $this->template->load('usuarios/index', $data);
    }

    public function insertar()
    {
        if ($this->input->post('insertar') !== NULL)
        {
            $reglas = $this->reglas_comunes;
            $reglas[0]['rules'] .= '|is_unique[usuarios.nick]';
            $this->form_validation->set_rules($reglas);
            if ($this->form_validation->run() !== FALSE)
            {
                $valores = $this->limpiar('insertar', $this->input->post());
                $this->Articulo->insertar($valores);
                redirect('usuarios/index');
            }
        }
        $data['roles'] = $this->Rol->lista();
        $this->template->load('usuarios/insertar', $data);
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
        $this->template->load('articulos/editar', $data);
    }

    public function borrar($id = NULL)
    {
        if ($this->input->post('borrar') !== NULL)
        {
            $id = $this->input->post('id');
            if ($id !== NULL)
            {
                $this->Usuario->borrar($id);
            }
            redirect('usuarios/index');
        }
        else
        {
            if ($id === NULL)
            {
                redirect('usuarios/index');
            }
            else
            {
                $res = $this->Usuario->por_id($id);
                if ($res === FALSE)
                {
                    redirect('usuarios/index');
                }
                else
                {
                    $data = $res;
                    $this->template->load('usuarios/borrar', $data);
                }
            }
        }
    }

    public function _existe_rol($rol_id)
    {
        if ($this->Rol->por_id($rol_id) === FALSE)
        {
            $this->form_validation->set_message('_existe_rol',
                'El {field} debe existir.');
            return FALSE;
        }
        else
        {
            return TRUE;
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
