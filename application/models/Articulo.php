<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Articulo extends CI_Model
{
    public function todos()
    {
        return $this->db->query('select * from articulos')->result_array();
    }

    public function borrar($id)
    {
        return $this->db->query("delete from articulos where id = ?",
                                array($id));
    }

    public function por_id($id)
    {
        res = $this->db->query('select * from articulos where id = ?',
                                array($id));
        return $res->num_rows() > 0 ? $res->row_array() : FALSE;
    }
}
