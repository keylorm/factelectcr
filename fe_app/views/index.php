<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$_dir = dirname(__FILE__) . '/';

if(!isset($vista) or $vista == 'login'){
    $vista = 'login';
}


require_once $_dir . '/master/header.php';


$file = $_dir . '/' . $vista . '.php';
if(file_exists($file)){
	require_once $file;
}else{
	echo '<p>La vista no fue encontrada</p>';
}

require_once $_dir . '/master/footer.php';
