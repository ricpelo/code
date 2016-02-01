<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function login()
{
    $CI =& get_instance();

    $out = "";

    if ($CI->Usuario->logueado()):
      $usuario = $CI->session->userdata('usuario');
      $out .= '<div class="row">';
        $out .= '<div class="col-md-12 text-right">';
          $out .= form_open('usuarios/logout',
                            'class="form-inline" style="padding-right:20px"');
            $out .= '<div class="form-group">';
              $out .= form_label('Usuario: ' . $usuario['nick'], 'logout') .
                                 '&nbsp;';
              $out .= form_submit('logout', 'Logout',
                                  'id="logout" class="btn btn-primary btn-xs"');
            $out .= '</div>';
          $out .= form_close();
        $out .= '</div>';
      $out .= '</div>';
      $out .= '<hr/>';
    endif;

    return $out;
}
