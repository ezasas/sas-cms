<?php if (!defined('basePath')) exit('No direct script access allowed');

// Table Name
$sqltable 	= array(

	'table' => $this->table_prefix.'category'
);

$categoryName = $this->site->isMultiLang()?'category_name_'.$this->active_lang():'category_name';

/* select */
$arrOption = array(
	'addoption'	=> array(
		'0' => '--'
	),
	'reftable'	=> array(
		'name' 	=> $this->table_prefix.'category',
		'id' 	=> 'category_id', 
		'field'	=> $categoryName,
		'cond' 	=> 'where 1'
	)
);

/* checkbox */
$arrCheck  = array(
	'addcheck'	=> array(
		'1' => 'Yes',
		'0' => 'No',
	),
	'reftable'	=> array(
		'name' 	=> $this->table_prefix.'category',
		'id' 	=> 'category_id', 
		'field'	=> $categoryName,
		'cond' 	=> 'where 1'
	)
);

/* Radio */
$arrRadio  = array(

	'addRadio'	=> array(
		'1' => 'Yes',
		'0' => 'No'
	),
	'reftable'	=> array(
		'name' 	=> $this->table_prefix.'category',
		'id' 	=> 'category_id', 
		'field'	=> $categoryName,
		'cond' 	=> 'where 1'
	)
);

// Define form field
$params	= array(
	//$this->form->input->html($this->langTabs()),	
	//$this->form->input->plaintext('Plaintext', 'add_plaintext', $size=150),
	
	$this->form->input->plaintext('Plaintext', 'add_fieldname', $size=150,$comment=''),
	$this->form->input->html('	
		<script type="syntaxhighlighter" class="brush: php; html-script: true">
		<![CDATA[
		<?php
		
		$this->form->input->plaintext(\'Plaintext\', \'add_fieldname\', $size=25,$comment=\'\')
		
		?>
		]]>
		</script>
		<hr>
	'),	
	$this->form->input->text('Text', 'add_fieldname',80, $multilang=false),
	$this->form->input->html('	
		<script type="syntaxhighlighter" class="brush: php; html-script: true">
		<![CDATA[
		<?php
		
		$this->form->input->text(\'Text\', \'add_fieldname\', $size=25, $multilang=false, $value=\'\', $extra=\'class="form-control"\', $comment=\'\')
		
		?>
		]]>
		</script>
		<hr>
	'),
	$this->form->input->password('Password', 'add_fieldname', $size=25, $value='', $extra='class="form-control"'),
	$this->form->input->html('	
		<script type="syntaxhighlighter" class="brush: php; html-script: true">
		<![CDATA[
		<?php
		
		$this->form->input->password(\'Password\', \'add_fieldname\', $size=25, $value=\'\', $extra=\'class="form-control"\')
		
		?>
		]]>
		</script>
		<hr>
	'),
	$this->form->input->textarea('Textarea','add_fieldname',30,3,$editor=false, $multilang=false),
	$this->form->input->html('	
		<script type="syntaxhighlighter" class="brush: php; html-script: true">
		<![CDATA[
		<?php
		
		$this->form->input->textarea(\'Textarea\',\'add_fieldname\',30,3,$editor=false, $multilang=false)
		
		?>
		]]>
		</script>
		<hr>
	'),
	$this->form->input->textarea('Editor', 'add_fieldname', $cols=30, $rows=3, $editor=true, $multilang=false, $comment='', $value='', $extra='class="form-control"'),
	$this->form->input->html('	
		<script type="syntaxhighlighter" class="brush: php; html-script: true">
		<![CDATA[
		<?php
		
		$this->form->input->textarea(\'Editor\', \'add_fieldname\', $cols=30, $rows=3, $editor=true, $multilang=false, $comment=\'\', $value=\'\', $extra=\'\')
		
		?>
		]]>
		</script>
		<hr>
	'),
	$this->form->input->select('Select', 'add_fieldname', $arrOption, $multiple=false, $extra='class="select2 form-control"'),
	$this->form->input->select('Multiple Select', 'add_fieldname', $arrOption, $multiple=true, $extra='class="select2 form-control"'),
	$this->form->input->html('	
		<script type="syntaxhighlighter" class="brush: php; html-script: true">
		<![CDATA[		
		<?php
		
		/* Generate options */
		$arrOption = array(
			\'addoption\'	=> array(
				\'0\' => \'--\'
			),
			\'reftable\'	=> array(
				\'name\' 	=> $this->table_prefix.\'table_name\',
				\'id\' 	=> \'filed_id\', 
				\'field\'	=> filed_name,
				\'cond\' 	=> \'where 1\'
			)
		);
		
		/* Select */
		$this->form->input->select(\'Select\', \'add_fieldname\', $arrOption, $multiple=false, $extra=\'class="select2 form-control"\')
		
		/* Multiple Select */
		$this->form->input->select(\'Select\', \'add_fieldname\', $arrOption, $multiple=true, $extra=\'class="select2 form-control"\')
		
		?>
		]]>
		</script>
		<hr>
	'),
	$this->form->input->checkbox('Checkbox', 'add_fieldname', $arrCheck, $extra='class="form-control"'),
	$this->form->input->html('	
		<script type="syntaxhighlighter" class="brush: php; html-script: true">
		<![CDATA[		
		<?php
		
		/* init */
		$arrCheck  = array(
			\'addcheck\'	=> array(
				\'1\' => \'Yes\',
				\'0\' => \'No\',
			),
			\'reftable\'	=> array(
				\'name\' 	=> $this->table_prefix.\'table_name\',
				\'id\' 	=> \'filed_id\', 
				\'field\'	=> filed_name,
				\'cond\' 	=> \'where 1\'
			)
		);
		
		/* Checkbox */
		$this->form->input->checkbox(\'Checkbox\', \'add_fieldname\', $arrCheck, $extra=\'class=""\')
		
		?>
		]]>
		</script>
		<hr>
	'),
	$this->form->input->switchcheck('Switchcheck 1', 'add_fieldname', $skin=1,$checked=false, $addClass=''),	
	$this->form->input->switchcheck('Switchcheck 2', 'add_fieldname', $skin=2,$checked=false, $addClass=''),
	$this->form->input->switchcheck('Switchcheck 3', 'add_fieldname', $skin=3,$checked=false, $addClass=''),
	$this->form->input->switchcheck('Switchcheck 4', 'add_fieldname', $skin=4,$checked=false, $addClass=''),
	$this->form->input->switchcheck('Switchcheck 5', 'add_fieldname', $skin=5,$checked=false, $addClass=''),
	$this->form->input->switchcheck('Switchcheck 6', 'add_fieldname', $skin=6,$checked=false, $addClass=''),
	$this->form->input->html('	
		<script type="syntaxhighlighter" class="brush: php; html-script: true">
		<![CDATA[		
		<?php
		
		/* switchcheck */
		$this->form->input->switchcheck(\'Switchcheck\', \'add_fieldname\', $skin=6,$checked=false, $addClass=\'\')
		
		/* skin options */
		$skin=1, $skin=2, $skin=3, $skin=4, $skin=5, $skin=6
		
		?>
		]]>
		</script>
		<hr>
	'),
	$this->form->input->radio('Radio', 'add_fieldname', $arrRadio, $extra='class="form-control"'),
	$this->form->input->html('	
		<script type="syntaxhighlighter" class="brush: php; html-script: true">
		<![CDATA[		
		<?php
		
		/* init */
		$arrRadio  = array(

			\'addRadio\'	=> array(
				\'1\' => \'Yes\',
				\'0\' => \'No\'
			),
			\'reftable\'	=> array(
				\'name\' 	=> $this->table_prefix.\'table_name\',
				\'id\' 	=> \'filed_id\', 
				\'field\'	=> filed_name,
				\'cond\' 	=> \'where 1\'
			)
		);
		
		/* Checkbox */
		$this->form->input->radio(\'Radio\', \'add_fieldname\', $arrRadio, $extra=\'class=""\')
		
		?>
		]]>
		</script>
		<hr>
	'),
	$this->form->input->file('File', 'add_fieldnamefile', @$path, $allowedTypes='zip,rar,pdf', $maxsize='', $comment='comment here'),
	$this->form->input->html('	
		<script type="syntaxhighlighter" class="brush: php; html-script: true">
		<![CDATA[		
		<?php
		
		/* input image */
		$this->form->input->file(\'File\', \'add_fieldname\', @$path, $allowedTypes=\'zip,rar,pdf\', $maxsize=\'\', $comment=\'comment here\')
		
		?>
		]]>
		</script>
		<hr>
	'),
	$this->form->input->image('Image', 'add_fieldname', @$path, $thumbPath='', $allowedTypes='image', $maxsize='', $extra='class="form-control"'),
	$this->form->input->html('	
		<script type="syntaxhighlighter" class="brush: php; html-script: true">
		<![CDATA[		
		<?php
		
		/* input image */
		$this->form->input->image(\'Image\', \'add_fieldname\', @$path, $thumbPath=\'\', $allowedTypes=\'image\', $maxsize=\'\', $extra=\'class=""\')
		
		?>
		]]>
		</script>
		<hr>
	'),
	$this->form->input->datePicker('DatePicker', 'add_fieldname'),
	$this->form->input->html('	
		<script type="syntaxhighlighter" class="brush: php; html-script: true">
		<![CDATA[		
		<?php
		
		/* Date picker */
		$this->form->input->datePicker(\'DatePicker\', \'add_fieldname\')
		
		?>
		]]>
		</script>
		<hr>
	'),
	$this->form->input->dateRangePicker('dateRangePicker', 'add_fieldname'),
	$this->form->input->html('	
		<script type="syntaxhighlighter" class="brush: php; html-script: true">
		<![CDATA[		
		<?php
		
		/* Date range picker */
		$this->form->input->dateRangePicker(\'dateRangePicker\', \'add_fieldname\')
		
		?>
		]]>
		</script>
		<hr>
	'),
	$this->form->input->dateTimePicker('dateTimePicker', 'add_fieldname'),
	$this->form->input->html('	
		<script type="syntaxhighlighter" class="brush: php; html-script: true">
		<![CDATA[		
		<?php
		
		/* Date time picker */
		$this->form->input->dateTimePicker(\'dateTimePicker\', \'add_fieldname\')
		
		?>
		]]>
		</script>
		<hr>
	'),
	$this->form->input->timePicker('timePicker', 'add_fieldname'),
	$this->form->input->html('	
		<script type="syntaxhighlighter" class="brush: php; html-script: true">
		<![CDATA[		
		<?php
		
		/* Time picker */
		$this->form->input->timePicker(\'timePicker\', \'add_fieldname\')
		
		?>
		]]>
		</script>
		<hr>
	'),
	$this->form->input->colorpicker('Colorpicker', 'add_fieldname'),
	$this->form->input->html('	
		<script type="syntaxhighlighter" class="brush: php; html-script: true">
		<![CDATA[		
		<?php
		
		/* Time picker */
		$this->form->input->colorpicker(\'Colorpicker\', \'add_fieldname\')
		
		?>
		]]>
		</script>
		<hr>
	'),
	$this->form->input->html('<p>Iki HTML lhoo</p>'),
	$this->form->input->html('	
		<script type="syntaxhighlighter" class="brush: php; html-script: true">
		<![CDATA[		
		<?php
		
		/* Time picker */
		$this->form->input->html(\'<p>Iki HTML lhoo</p>\')
		
		?>
		]]>
		</script>
		<hr>
	'),
	$this->form->input->html('
		<br>
		<h2>
			Options
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				onInsert - onUpdate - beforeInsert - beforeUpdate
			</small>
		</h2>
		<br>
	'),
	$this->form->input->html('
		<h4>On Insert</h4>
		<p>Fungsi ini di eksekusi setelah data disimpan(insert) ke database.</p>
	'),
	$this->form->input->html('	
		<script type="syntaxhighlighter" class="brush: php; html-script: true">
		<![CDATA[		
		<?php
		
		/* onInsert */
		$this->form->onInsert(\'functionName($post)\');

		function functionName($post){
			
			global $system;
			
			//Your code..
		}
		
		?>
		]]>
		</script>
		<hr>
	'),
	$this->form->input->html('
		<h4>On Update</h4>
		<p>Fungsi ini di eksekusi setelah data disimpan(update) ke database.</p>
	'),
	$this->form->input->html('	
		<script type="syntaxhighlighter" class="brush: php; html-script: true">
		<![CDATA[		
		<?php
		
		/* onUpdate */
		$this->form->onUpdate(\'functionName($post)\');

		function functionName($post){
			
			global $system;
			
			//Your code..
		}
		
		?>
		]]>
		</script>
		<hr>
	'),
	$this->form->input->html('
		<h4>Before Insert</h4>
		<p>Fungsi ini di eksekusi sebelum data disimpan(insert) ke database.</p>
	'),
	$this->form->input->html('	
		<script type="syntaxhighlighter" class="brush: php; html-script: true">
		<![CDATA[		
		<?php
		
		/* beforeInsert */
		$this->form->beforeInsert(\'functionName()\');

		function functionName(){
	
			global $system;

			$error = false;
			$alert = \'\';
			
			//Your code..
			
			$response = array(
				
				\'error\' => $error,
				\'alert\' => $alert
			);
			
			return $response;	
		}
		
		?>
		]]>
		</script>
		<hr>
	'),
	$this->form->input->html('
		<h4>Before Update</h4>
		<p>Fungsi ini di eksekusi setelah data disimpan(update) ke database.</p>
	'),
	$this->form->input->html('	
		<script type="syntaxhighlighter" class="brush: php; html-script: true">
		<![CDATA[		
		<?php
		
		/* beforeUpdate */
		$this->form->beforeUpdate(\'functionName()\');

		function functionName(){
	
			global $system;

			$error = false;
			$alert = \'\';
			
			//Your code..
			
			$response = array(
				
				\'error\' => $error,
				\'alert\' => $alert
			);
			
			return $response;	
		}
		
		?>
		]]>
		</script>
		<hr>
	'),
	$this->form->input->html('
		<div class="page-header">
			<h2>
				Get Form 
				<small>
					<i class="ace-icon fa fa-angle-double-right"></i>
					menampilkan form
				</small>
			</h2>
		</div>
	'),
	$this->form->input->html('	
		<script type="syntaxhighlighter" class="brush: php; html-script: true">
		<![CDATA[		
		<?php
		
		/* init */
		$fieldID  = \'\';
		$sqltable = array(

			\'table\'	   => $this->table_prefix.\'tableName\',
			\'filed_id\' => $fieldID
		);
		
		/* example */
		$postID   = intval($this->uri(3);
		$sqltable = array(

			\'table\'	  => $this->table_prefix.\'posts\',
			\'post_id\' => $postID
		);
		
		/* input element */
		$params 	= array(
		
			//form input
		}
		
		/* get form [$act = add/edit] */
		getForm($act,$sqltable,$params,$formName=\'form\',$submitValue=\'Submit\',$finishBotton=false,$resetBotton=false,$extra=\'\')
		
		?>
		]]>
		</script>
		<hr>
	')
);

$this->form->getForm('add',$sqltable,$params,$formName='category',$submitValue='Submit',$finishBotton=false,$resetBotton=false,$extra='class=""')
?>

<!-- shcore css -->
<?php echo $this->load_css($this->themeURL().'assets/css/shcore/shCore.css');?>
<?php echo $this->load_css($this->themeURL().'assets/css/shcore/shThemeDefault.css');?>

<!-- shcore js -->
<script src="<?=$this->themeURL()?>assets/js/shcore/jquery.localscroll-1.2.7-min.js"></script>
<script src="<?=$this->themeURL()?>assets/js/shcore/shCore.js"></script>
<script src="<?=$this->themeURL()?>assets/js/shcore/shBrushPhp.js"></script>
<script src="<?=$this->themeURL()?>assets/js/shcore/shBrushXML.js"></script>
<script src="<?=$this->themeURL()?>assets/js/shcore/shBrushJScript.js"></script>
<script src="<?=$this->themeURL()?>assets/js/shcore/shBrushCss.js"></script>
<script src="<?=$this->themeURL()?>assets/js/shcore/custom.js"></script>