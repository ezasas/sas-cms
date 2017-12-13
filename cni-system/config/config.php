<?php

/** CNI - Configuration File
  *
  *   @version: 1.0
  *    @author: Hasan Sas <nepster_23@yahoo.com>
  * @copyright: 2013-2014 CNI Project
  *   @package: cni_system
  *   @license: http://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license: http://opensource.org/licenses/LGPL-3.0 LGPLv3
  */
  
/* Base URL */
$base_url 					= 'Dev/app/sas/';


/* Database Setting */
$config['db_host']	 	= 'localhost';
$config['db_user'] 		= 'root';
$config['db_password'] 	= '';
$config['db_name'] 		= 'sas';


/* prefix */
$config['tablePrefix']	= 'sas_';
$config['adminName']		= 'sas-admin';
$config['permalink']		= '.html';


/* Define Base URL/Path */
$config['baseURL']		= $base_url;
$config['basePath']		= str_replace('//','/',$_SERVER['DOCUMENT_ROOT'].'/'.$base_url);


/* Session */
$config['sessionName']	= 'sassession';


/* email */
$config['useMailer']	 	= false;
$config['emailHost']	 	= '';
$config['emailUser'] 	 	= '';
$config['emailPassword'] 	= '';


/* Copyright */
$config['copyright']		= 'Designed & Developed by <a href="http://www.citra.web.id" target="_blank">Citraweb</a>';


/* Demo */
$config['demo']			= false;


/* Database Driver */
$config['db_diver']		= 'mysql';
$config['drivers']	 	= array('mysql','mysqli');
/* API */
$config['googleKey']		= 'AIzaSyCn8EFLEdv8yxSd7H5TxrbKjcbN50cgqqA';
$config['youtubeKey']		= 'AIzaSyCP4VPZCZv2corqe_qB0I3k3C0za81jzMk';
?>