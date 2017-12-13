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
				halaman ini menampilkan daftar '.$this->pageTitle().'
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Main Menu</div>
			<div class="help-content">
				<li>Klik tab <b>public menu</b> untuk menambah menu dihalaman publish.</li>
				<li>Klik tab <b>admin menu</b> untuk menambah menu dihalaman admin.</li>
				<li>Pilih letak menu yang akan ditambahkan sebelah pojok kanan atas (top,bottom,right,left) optional.</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Tambah Menu</div>
			<div class="help-content">
				<li>Pilih nama halaman di kolom <b>Pages</b> atau nama kategori di kolom <b>Category</b>
				<li>Pilih icon menu (untuk menu admin)</li>
				<li>Setelah memilih, klik <button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>Add to menu</button></li>
				<li>Menu tambah disebelah kanan kolom <b> public menu/admin menu</b></li>
			</div>
		</div>

		<div class="help-item">
			<div class="help-title">Urutan Menu</div>
			<div class="help-content">
				<li>klik menu dan drag ke posisi yang diinginkan lalu lepas (drop).</li>
				<li>Untuk sub menu, drag dan geser ke kanan lalu drop.</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Mengedit Menu</div>
			<div class="help-content">
				<li>klik <i class="fa fa-pencil"></i>untuk mengedit menu</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Menghapus Menu</div>
			<div class="help-content">
				<li>klik icon 
					<a class="red"  href="#">
						<i class="fa fa-trash bigger-130"></i>
					</a> untuk menghapus menu
				</li>
			</div>
		</div>
	</div>';
	?>