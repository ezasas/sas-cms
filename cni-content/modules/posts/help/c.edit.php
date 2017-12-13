<style>
.help-container{ height:auto;max-height:100% !important;}
.help-maintitle{ font-size:16px;font-weight:bold;color:#000;}
.help-item{ padding:8px; }
.help-title{ font-size:14px;font-weight:bold;color:#FDA01E;}
.help-content{ margin-left:15px;font-size:12px;color:#707070;}
.help-desc{ font-size:12px;color:#707070;}
</style>
<?if (!defined('basePath')) exit('No direct script access allowed');
$help	= '<div class="help-container">
		<div class="help-maintitle">Bantuan</div>
		<div class="help-item">
			<div class="help-desc">
				halaman ini untuk mengedit data '.$this->pageTitle().'
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Rubah data</div>
			<div class="help-content">
				<li>Rubah data sesuai yang diinginkan</li>
			</div>
		</div>
		
		<div class="help-item">
			<div class="help-title">Menyimpan data</div>
			<div class="help-content">
				<li>Jika sudah selesai mengedit data yang diinginkan, klik tombol <button id="save_banner" class="btn btn-sm btn-primary" name="save_banner" type="submit">
<i class="fa fa-save"></i>
Update Category
</button></li>
				
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Kembali ke Halaman tabel data</div>
			<div class="help-content">
			<li>tekan tombol <a class="btn btn-sm btn-success" href="#">
<i class="fa fa-check"></i>
Finish
</a></li>
			</div>
		</div>
	</div>';
	?>