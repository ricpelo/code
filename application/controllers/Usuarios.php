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
            'rules' => 'trim|is_natural|callback__existe_rol'
        )
    );

    private $array_password_anterior = array(
        'field' => 'password_anterior',
        'label' => 'Contraseña Antigua',
        'rules' => 'required'
    );

    public function __construct()
    {
        parent::__construct();
        $accion = $this->uri->rsegment(2);

        if ( ! in_array($accion, array('login', 'recordar', 'regenerar')) &&
             ! $this->Usuario->logueado())
        {
            redirect('usuarios/login');
        }

        if ( ! in_array($accion, array('login', 'logout', 'recordar', 'regenerar')))
        {
            if ( ! $this->Usuario->es_admin())
            {
                $mensajes[] = array('error' =>
                    "No tiene permisos para estar en el index de usuarios.");
                $this->flashdata->load($mensajes);

                redirect('articulos/index');
            }
        }

        // $this->output->enable_profiler(TRUE);
    }

    public function login()
    {
        if ($this->Usuario->logueado())
        {
            redirect('usuarios/index');
        }

        if ($this->input->post('login') !== NULL)
        {
            $nick = $this->input->post('nick');

            $reglas = array(
                array(
                    'field' => 'nick',
                    'label' => 'Nick',
                    'rules' => array(
                        'trim', 'required',
                        array('existe_nick', array($this->Usuario, 'existe_nick'))
                    ),
                    'errors' => array(
                        'existe_nick' => 'El nick debe existir.',
                    ),
                ),
                array(
                    'field' => 'password',
                    'label' => 'Contraseña',
                    'rules' => "trim|required|callback__password_valido[$nick]"
                )
            );

            $this->form_validation->set_rules($reglas);
            if ($this->form_validation->run() === TRUE)
            {
                $usuario = $this->Usuario->por_nick($nick);
                $this->session->set_userdata('usuario', array(
                    'id' => $usuario['id'],
                    'nick' => $nick,
                    'rol_id' => $usuario['rol_id']
                ));
                redirect('usuarios/index');
            }
        }
        $this->template->load('usuarios/login');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('usuarios/login');
    }

    public function recordar()
    {
        if ($this->input->post('recordar') !== NULL)
        {
            $reglas = array(
                array(
                    'field' => 'nick',
                    'label' => 'Nick',
                    'rules' => array(
                        'trim',
                        'required',
                        array('existe_usuario', array($this->Usuario, 'existe_nick'))
                    ),
                    'errors' => array(
                        'existe_usuario' => 'Ese usuario no existe.'
                    )
                )
            );
            $this->form_validation->set_rules($reglas);
            if ($this->form_validation->run() !== FALSE)
            {
                // Preparar correo
                $nick = $this->input->post('nick');
                $usuario = $this->Usuario->por_nick($nick);
                $usuario_id = $usuario['id'];
                $this->load->model('Token');
                $enlace = anchor('/usuarios/regenerar/' . $usuario_id . '/' .
                                 $this->Token->generar($usuario_id));
                $this->load->library('email');
                $this->email->from('iesdonana2daw@gmail.com');
                $this->email->to($usuario['email']);
                $this->email->subject('Regeneración de contraseña');
                $this->email->message($enlace);
                $this->email->send();

                $mensajes[] = array('info' =>
                    "Se ha enviado un correo a su dirección de email.");
                $this->flashdata->load($mensajes);

                redirect('usuarios/login');
            }
        }
        $this->template->load('usuarios/recordar');
    }

    public function regenerar($usuario_id = NULL, $token = NULL)
    {
        if ($usuario_id === NULL || $token === NULL)
        {
            redirect('usuarios/login');
        }

        $this->load->model('Token');

        if ($this->Token->comprobar($usuario_id, $token) === TRUE)
        {
            $data['usuario_id'] = $usuario_id;
            $data['token'] = $token;
            if ($this->input->post('regenerar') !== NULL)
            {
                $reglas = array(
                    array(
                        'field' => 'password',
                        'label' => 'Contraseña',
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'password_confirm',
                        'label' => 'Confirmar contraseña',
                        'rules' => 'trim|required|matches[password]'
                    )
                );
                $this->form_validation->set_rules($reglas);
                if ($this->form_validation->run() !== FALSE)
                {
                    $password = password_hash($this->input->post('password'),
                                              PASSWORD_DEFAULT);
                    $this->Usuario->editar(array('password' => $password),
                                           $usuario_id);
                    $this->Token->borrar($usuario_id);

                    $mensajes[] = array('info' =>
                        "Su contraseña se ha regenerado correctamente.");
                    $this->flashdata->load($mensajes);

                    redirect('usuarios/login');
                }
            }
            $this->template->load('usuarios/regenerar', $data);
        }
        else
        {
            $mensajes[] = array('error' =>
                "Información no valida para la regeneración de la contraseña. Por favor, vuelva a intentarlo.");
            $this->flashdata->load($mensajes);
            
            redirect('usuarios/login');
        }
    }

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
                $this->Usuario->insertar($valores);
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
            redirect('usuarios/index');
        }

        $id = trim($id);

        if ($this->input->post('editar') !== NULL)
        {
            $reglas = $this->reglas_comunes;
            $reglas[0]['rules'] .= "|callback__nick_unico[$id]";
            $reglas[] = $this->array_password_anterior;
            $reglas[sizeof($reglas)-1]['rules'] .= "|callback__password_anterior_correcto[$id]";
            $this->form_validation->set_rules($reglas);
            if ($this->form_validation->run() !== FALSE)
            {
                $valores = $this->limpiar('editar', $this->input->post());
                $this->Usuario->editar($valores, $id);
                redirect('usuarios/index');
            }
        }
        $valores = $this->Usuario->por_id($id);
        if ($valores === FALSE)
        {
            redirect('usuarios/index');
        }
        $data = $valores;
        if (isset($data['password']))
        {
            unset($data['password']);
        }
        $data['roles'] = $this->Rol->lista();
        $this->template->load('usuarios/editar', $data);
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

    public function _password_valido($password, $nick)
    {
        $usuario = $this->Usuario->por_nick($nick);

        if ($usuario !== FALSE &&
            password_verify($password, $usuario['password']) === TRUE)
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('_password_valido',
                'La {field} no es válida.');
            return FALSE;
        }
    }

    public function _password_anterior_correcto($password_anterior, $id)
    {
        $valores = $this->Usuario->password($id);
        if (password_verify($password_anterior, $valores['password']) === TRUE)
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('_password_anterior_correcto',
                'La {field} no es correcta.');
            return FALSE;
        }
    }

    public function _nick_unico($nick, $id)
    {
        $res = $this->Usuario->por_nick($nick);

        if ($res === FALSE || $res['id'] === $id)
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('_nick_unico',
                'El {field} debe ser único.');
            return FALSE;
        }
    }

    private function limpiar($accion, $valores)
    {
        unset($valores[$accion]);
        $valores['password'] = password_hash($valores['password'], PASSWORD_DEFAULT);
        unset($valores['password_confirm']);
        if (isset($valores['password_anterior']))
        {
            unset($valores['password_anterior']);
        }
        return $valores;
    }
}
