<?if (!defined('basePath')) exit('No direct script access allowed');

$tableName	= $this->table_prefix.'menu';
$refTable	= $this->table_prefix.'pages';

if(!@$this->session('admin_menu')){

	$this->session_set(array('admin_menu'=>'0_public'));
}

$arrMenu = array(

	'0_public'	=> 'Public,laptop',
	'1_admin' 	=> 'Admin,user'
);
	
if(isset($_POST['admin_menu'])){
	$this->session_unset('admin_menu');
	
	$addSession = array(	
		'admin_menu' => $_POST['admin_menu']
	);

	$this->session_set($addSession);
}

$selectMenu		 = '';

foreach($arrMenu as $k => $v){

	$arrVal		 = explode(',',$v);
	$selectTitle = $arrVal[0];
	$selectIcon  = $arrVal[1];
	
	$actvMenu 	 = isset($_POST['admin_menu'])?substr($_POST['admin_menu'],0,1):substr($this->session('admin_menu'),0,1);
	$xClass	  	 = substr($k,0,1) == $actvMenu?' class="active"':'';	
	$selectMenu .= '<li id="'.$k.'"'.$xClass.'><span onclick="selectmenu(\''.$k.'\')"><i class="icon-'.$selectIcon.'"></i>'.$selectTitle.'</span></li>';
}

$selectMenu = '<div class="m-button"><ul></i>'.$selectMenu.'</ul><div class="clearfix"></div></div><div class="clearfix"></div>';

echo $selectMenu;
?>

<form id="frmAdminMenu" method="post" action="">
	<input id="adminMenu" type="hidden" name="admin_menu" value="0_public"/>
</form>

<!--- Script --->
<script type="text/javascript">
	
	var selectActive = '0_public';
	
	function selectmenu(menu){
		
		$("#adminMenu").val(menu);
		$("#frmAdminMenu").submit();
	}
	
</script>