<?php if (!defined('basePath')) exit('No direct script access allowed'); 

$menuID = $this->db->getOne("select menu_id from ".$this->table_prefix."menu where page_id='".$this->thisPageID()."'");
$fPage	= $this->site->isMultiLang()?'page_name_'.$this->active_lang():'page_name';
$fURL	= $this->site->isMultiLang()?'page_url_'.$this->active_lang():'page_url';
$sql 	= "select m.icon, p.".$fPage." as page_name,p.".$fURL." as page_url from ".$this->table_prefix."menu m left join ".$this->table_prefix."pages p on(m.page_id=p.page_id) where m.parent_id='".$menuID."'";
$pages	= $this->db->getAll($sql);
$pageList = '';

foreach($pages as $page){
	
	$pageList .= '
		
		<div class="col-md-2 col-xs-4">
			<div class="nav-icon-list">
				<a href="'.$page['page_url'].'">
					<div class="square">
						<div class="square-content">
							<div class="img-wrap">
								<div class="icon-xlg"><i class="ace-icon fa '.$page['icon'].'"></i></div>
								<p>'.$page['page_name'].'</p>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
	';
}
?>

<div class="row">
	<?php echo $pageList ?>
</div>