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
				Halaman ini menampilkan daftar '.$this->pageTitle().'
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Menu Widget</div>
			<div class="help-content">
				<li>Pilih nama widget sebelah kiri.</li>
				<li>Klik dan drag/drop nama widget ke kolom widget sebelah kanan (Top, Konten, Right, Bottom)</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Setting Widget</div>
			<div class="help-content">
				<li>klik <i class="fa fa-wrench"></i> untuk setting widget</li>
				<li>Pilih <b>Display</b> untuk ditampilkan pada (Home Page, Hide Home Page, atau All Page)</li>
				<li>Isi kolom title untuk nama widget</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Menghapus Data</div>
			<div class="help-content">
				<li>klik dan drag widget lalu drop keluar dan taruh kesisi kiri</li>
			</div>
		</div>
	</div>';
	?>