<?
session_start();

require 'securimage.php';
?>

<img id="image" class="captcha" src="securimage_show.php?sid=<?=md5(uniqid(time()))?>"/>
			
<a href="#" onclick="document.getElementById('image').src = 'securimage_show.php?sid=' + Math.random(); return false"><img src="refresh.gif" border="0" alt="refresh image" title="refresh image"/></a>

<?
print_r($_SESSION);
?>