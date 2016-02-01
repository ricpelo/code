<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function mensaje()
{
    $CI =& get_instance();
    $mensaje = $CI->session->flashdata('mensaje');

    $out = "";

    if ($mensaje !== NULL)
    {
        $out .= '<div class="alert alert-danger" role="alert">';
          $out .= $mensaje;
        $out .= '</div>';
    }

    return $out;
}
