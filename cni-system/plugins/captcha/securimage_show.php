<?php

include 'securimage.php';

$img = new securimage();

//$img->ttf_file = "./GARA.TTF";
//$img->image_bg_color = "";
$img->use_gd_font = true;
$img->gd_font_file = "./gdfonts/automatic.gdf";
$img->image_width = 132;
$img->font_size = 18;
$img->text_color = "#000000";
$img->draw_lines = false;
$img->arc_linethrough = false;
$img->arc_line_colors = "#386FCF";
$img->use_multi_text = false;
// $img->charset = "ABCDEFGHKLMNPRSTUWY23456789";
$img->charset = "BCDEFHKPSTW347";

//$img->show(); // alternate use:  $img->show('/path/to/background.jpg');
$img->show('captcha.png');

?>
