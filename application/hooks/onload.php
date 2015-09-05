<?php
class Onload
{
    private $ci;

    public function __construct() {
        $this->ci = & get_instance();
    }

    public function check_login() {
        $controller = $this->ci->router->class;
        $method = $this->ci->router->method;

        if ($this->ci->session->userdata('login_id') == null) {
            if ($method != 'login') {
                redirect('main', 'refresh');
                exit();
            }
        }
        else {
            if ($method=='login') {
                redirect('','refresh');
                exit();
            }
        }
    }
}
?>