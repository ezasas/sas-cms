<?php if (!defined('basePath')) exit('No direct script access allowed');

switch($this->uri(3)){

	case 'content': include 'pages.add.content.php'; break;
	case 'application': include 'pages.add.application.php'; break;
	default: include 'pages.add.content.php'; break;
}
?>