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
			<div class="help-title">Menu Tabel</div>
			<div class="help-content">
				<li>Klik <b>Add New</b> untuk menambah data baru</li>
				<li>Beri tanda centang pada kolom data lalu klik <b>Save All Changes</b> untuk menyimpan data</li>
				<li>Beri tanda centang pada kolom kiri data lalu klik <b>Delete Seleted</b> untuk menghapus data</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Mengedit Data</div>
			<div class="help-content">
				<li>klik <a class="green" title="Edit" href="#">
						<i class="fa fa-pencil bigger-130"></i>
						</a> untuk mengedit data
				</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Active User</div>
			<div class="help-content">
				<li>Tanda centang pada kolom <b>Active</b> untuk status user aktif.</li>
			</div>
		</div>
		<div class="help-item">
			<div class="help-title">Menghapus Data</div>
			<div class="help-content">
				<li>Klik icon 
					<a class="red"  href="#">
						<i class="fa fa-trash bigger-130"></i>
					</a> untuk menghapus data
				</li>
				<li>Beri tanda centang pada sebelah kiri data yang ingin dihapus lalu klik tombol <b>Delete Selected</b> untuk menghapus data sekaligus</li>
			</div>
		</div>
	</div>';
	?>