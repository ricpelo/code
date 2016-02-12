<?php if ( ! defined('BASEPATH') ) exit('No direct script access allowed');
#header('Access-Control-Allow-Origin: *');
/*
 * IMPORTANTE: Para que funcionen las peticiones Ajax, el nombre de dominio
 * no debe cambiar. Por ejemplo, no funciona si el programa se ejecuta
 * sobre ci.local pero envía una petición Ajax a www.ci.local. Para que
 * funcione correctamente, lo mejor es hacer que el programa se ejecute
 * siempre desde ci.local, y para ello, añadimos en public/.htaccess las
 * siguientes líneas para quitar las www. del nombre de dominio:
 *
 *   RewriteCond %{HTTP_HOST} ^www\.(.+)$ [NC]
 *   RewriteRule ^(.*)$ http://%1/$1 [R=301,L]
 *
 */
class Ajax_post_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form', 'html'));
    }

    // Show view Page
    public function index() {
        $this->load->view("ajax_post_view");
    }

    // This function call from AJAX
    public function user_data_submit() {
        $data = array(
            'username' => $this->input->post('name'),
            'pwd'=>$this->input->post('pwd')
        );

        //Either you can print value or you can send value to database
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }
}
