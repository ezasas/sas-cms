<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?=$this->head();?>
<?=$this->load_css($this->themeURL().'css/style.css');?>
</head>

<body>

<div id="coming-soon">

<h1>Under Construction</h1>

<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam egestas, mi vehicula dictum tempor, justo dui dictum purus, vel aliquet erat neque vitae enim. Etiam velit lectus, porta nec auctor ac, facilisis at erat.</p>

<form method="post">
	<div id="subscribe">
		<input type="text" placeholder="enter your email address...">
		<input type="submit" value="Submit">
		<div class="clear"></div>
	</div>
</form>

<a href="http://twitter.com/#!/<?=$this->site->twitter();?>" title="Visit JohnSardine on Twitter" class="twitter center"><?=$this->site->twitter();?></a>

</div>

</body>
</html>