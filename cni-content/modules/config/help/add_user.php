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
			<div class="help-title">Tambah Title, Content, Description, Tag</div>
			<div class="help-content">
				<li>Isi kolom <b>Username</b> untuk user login</li>
				<li>Isi kolom <b>Password</b> untuk login</li>
				<li>Pilih kolom <b>User Group</b> untuk Level</li>
				<li>Isi kolom <b>Name</b> untuk Nama lengkap User</li>
				<li>Isi kolom <b>Email</b> untuk Email User</li>
			</div>
		</div>
		
		<div class="help-item">
			<div class="help-title">Active</div>
			<div class="help-content">
			<li>Opsi ini menandakan jika on maka user aktif dan jika off maka user belom aktif login.</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Menyimpan data</div>
			<div class="help-content">
			<li>Jika sudah terisi semua , tekan tombol<button id="save_post" class="btn btn-sm btn-primary" name="save_post" type="submit">
<i class="fa fa-plus"></i>
Add 
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