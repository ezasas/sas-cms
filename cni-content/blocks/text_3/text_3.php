<?php if (!defined('basePath')) exit('No direct script access allowed');

$sText = base64_decode(html_entity_decode($block['block_params']));
$sText = mb_convert_encoding($sText, "UTF-8", "HTML-ENTITIES");

echo $sText;
?>