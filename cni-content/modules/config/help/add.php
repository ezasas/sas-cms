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
				halaman ini untuk menambahkan data '.$this->pageTitle().'
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Tambah Title, Content, Description, Tag</div>
			<div class="help-content">
				<li>Isikan kolom title untuk judul</li>
				<li>Isi kolom Tagline</li>
				<li>Isi kolom Content untuk isi konten</li>
				<li>Isi kolom Description untuk ringkasan konten</li>
				<li>Isi kolom Tag untuk tagline keyword dengan koma</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Upload Foto</div>
			<div class="help-content">
				<li>Arahkan mouse ke form upload <b>Featured Image</b>, maka akan muncul icon <button id="button_add_image">
				<i class="fa fa-upload"></i>
				</button>dan klik, pilih file image dan klick open. tunggu sampai proses upload selesai. Indicatornya <div class="loading_add_image progress-upload progress progress-small progress-striped active" style="margin-top:10px;">
<div class="progress-bar progress-bar-warning" style="width: 100%;"></div>
</div> akan hilang.
				</li>
				<li>Usahakan memakai foto dengan resolusi yang tinggi dengan lebar ideal 800px. Maksimal size gambar yang akan diuupload adalah 2Mb dengan dimensi maksimal 2000px. Jika melebihi batas tersebut maka upload akan gagal</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Publish</div>
			<div class="help-content">
			<li>Opsi ini menandakan jika on maka post akan langsung muncul di halaman utama, Opsi off maka post tidak akan langsung dimunculkan, defaultnya ON</li>
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
			<li>tekan tombol <a class="btn btn-sm btn-success" href="#">
<i class="fa fa-check"></i>
Finish
</a></li>
			</div>
		</div>
	</div>';
	?>