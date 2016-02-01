<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function mensaje()
{
    $CI =& get_instance();
    $mensaje = $CI->session->flashdata('mensaje');

    $out = "";

    if ($mensaje !== NULL)
    {
        $out .= '<div class="row">';
          $out .= '<div class="col-md-8 col-md-offset-2">';
            $out .= '<div class="alert alert-danger" role="alert">';
              $out .= $mensaje;
            $out .= '</div>';
          $out .= '</div>';
        $out .= '</div>';
    }

    return $out;
}
