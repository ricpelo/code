<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Model
{
    public function todos()
    {
        return $this->db->get('usuarios_roles')->result_array();
    }

    public function borrar($id)
    {
        return $this->db->delete('usuarios', array('id' => $id));
    }

    public function por_id($id)
    {
        $res = $this->db->get_where('usuarios_roles', array('id' => $id));
        return $res->num_rows() > 0 ? $res->row_array() : FALSE;
    }

    public function por_nick($nick)
    {
        $res = $this->db->get_where('usuarios_roles', array('nick' => $nick));
        return $res->num_rows() > 0 ? $res->row_array() : FALSE;
    }

    public function existe_nick($nick)
    {
        return $this->por_nick($nick) !== FALSE;
    }

    public function logueado()
    {
        return $this->session->has_userdata('usuario');
    }

    public function insertar($valores)
    {
        return $this->db->insert('usuarios', $valores);
    }

    public function editar($valores, $id)
    {
        return $this->db->where('id', $id)->update('usuarios', $valores);
    }
}
