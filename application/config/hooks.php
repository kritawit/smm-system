<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$hook['post_controller_constructor'] = array(
	'class' => 'onload',
	'function' => 'check_login',
	'filename' => 'onload.php',
	'filepath' => 'hooks' 
);