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
				Halaman ini untuk menambahkan data '.$this->pageTitle().'
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Upload Foto Slider</div>
			<div class="help-content">
				<li>Klik icon upload gambar pojok kanan atas</li>
				<li>Pilih gambar dari komputer, recomended 1400x600 pixel</li>
				<li>Tunggu sampai proses upload selesai. Indicatornya <div class="loading_add_image progress-upload progress progress-small progress-striped active" style="margin-top:10px;">
<div class="progress-bar progress-bar-warning" style="width: 100%;"></div>
</div> akan hilang.</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Tambah Title, Deskripsi, Link Slider</div>
			<div class="help-content">
				<li>Isi kolom <b>Title</b> untuk judul Slider</li>
				<li>Isi kolom <b>Taglline</b> (optional sesuai design)</li>
				<li>Isi kolom <b>Deskription</b> untuk penjelasan Slider</li>
				<li>Isi kolom <b>Caption</b> Button (optional sesuai design)</li>
				<li>Isi kolom <b>Link URL</b> (optional sesuai design)</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Status publish</div>
			<div class="help-content">
				<li>Pilih On pada check publish untuk ditampilkan</li>
				<li>Pilih Off untuk tidak ditampilkan</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Menyimpan data</div>
			<div class="help-content">
			<li>Jika sudah terisi semua , tekan tombol<button id="save_post" class="btn btn-sm btn-primary" name="save_post" type="submit">
<i class="fa fa-plus"></i>
Add Photo
</button></li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Menambahkan data lain</div>
			<div class="help-content">
			<li>Ulangi langkah diatas</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Kembali ke Halaman tabel data</div>
			<div class="help-content">
			<li>Tekan tombol <a class="btn btn-sm btn-success" href="#">
<i class="fa fa-check"></i>
Finish
</a></li>
			</div>
		</div>
	</div>';
	?>