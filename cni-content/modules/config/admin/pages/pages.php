<?php if (!defined('basePath')) exit('No direct script access allowed');

switch($this->uri(3)){

	case 'content': include 'pages.content.php'; break;
	case 'application': include 'pages.application.php'; break;
	default: include 'pages.content.php'; break;
}