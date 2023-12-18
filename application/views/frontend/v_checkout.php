<!-- BREADCRUMB -->
<div id="breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="<?php echo base_url() ?>">Home</a></li>
			<li class="active">Check Out</li>
		</ul>
	</div>
</div>
<!-- /BREADCRUMB -->

<!-- section -->
<div class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			
			<div class="col-md-12">
				<div class="order-summary clearfix">
					<div class="section-title">
						<h3 class="title">Buat Pesanan</h3>
					</div>

					<div class="row">
						<form method="post" action="<?php echo base_url().'welcome/checkout_act' ?>">
							<div class="col-lg-6">

								<div class="row">
									<div class="col-lg-12">

										<br>


										<h4 class="text-center">INFORMASI PEMBAYARAN PESANAN</h4>

										<div class="form-group">
											<label>Nama</label>
											<input type="text" class="input" name="nama" placeholder="Masukkan nama pemesan .." required="required">
										</div>

										<div class="form-group">
											<label>Nomor HP</label>
											<input type="number" class="input" name="hp" placeholder="Masukkan no.hp aktif .." required="required">
										</div>

										<div class="form-group">
											<label>Alamat Lengkap</label>
											<textarea name="alamat" class="form-control" style="resize: none;" rows="6" placeholder="Masukkan alamat lengkap .."></textarea>
										</div>

										<div class="form-group">
											<label>Kabupaten</label>
											<select id="kabupaten" name="kabupaten" class="input">
												<option>Pilih Kabupaten</option>
												<option>Karawang</option>
												<option>Bandung</option>
												<option>Purwakarta</option>
												<option>Subang</option>
												<option>Bandung</option>
												<option>Bekasi</option>
											</select>
										</div>
										<br>

									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="pull-left">
										<a class="main-btn" href="<?php echo base_url('welcome/keranjang') ?>">Edit Pemesanan</a>
										</div>

										<div class="pull-right">
											<input type="submit" class="primary-btn" value="Bayar">
										</div>
									</div>
								</div>

							</div>
							<div class="col-lg-6">

								<?php 
								if(isset($_SESSION['keranjang'])){

									$jumlah_isi_keranjang = count($_SESSION['keranjang']);

									if($jumlah_isi_keranjang != 0){

										?>


										<table class="shopping-cart-table table">
											<thead>
												<tr>
													<th>Produk</th>
													<th class="text-center">Harga</th>
													<th class="text-center">Jumlah</th>
													<th class="text-center">Total Harga</th>
												</tr>
											</thead>
											<tbody>

												<?php
											// cek apakah produk sudah ada dalam keranjang
												 $total_berat = 0;
												$jumlah_total = 0;
												$total = 0;
												for($a = 0; $a < $jumlah_isi_keranjang; $a++){
													$id_produk = $_SESSION['keranjang'][$a]['produk'];
													$jml = $_SESSION['keranjang'][$a]['jumlah'];

													$isi = $this->db->query("select * from produk where produk_id='$id_produk'");
													$i = $isi->row();

													$total += $i->produk_harga*$jml;
													$jumlah_total += $total;

													$xd = $_SESSION['keranjang'][$a]['jumlah']; 
													?>

													<tr>
														<td>
															<a href="produk_detail.php?id=<?php echo $i->produk_id ?>"><?php echo $i->produk_nama ?></a>
														</td>
														<td class="text-center">
															<?php echo "Rp. " . number_format($i->produk_harga) . " ,-"; ?>
														</td>
														<td class="qty text-center">
															<?php echo $_SESSION['keranjang'][$a]['jumlah']; ?>
														</td>
														<td class="text-center"><strong class="primary-color total_harga" id="total_<?php echo $i->produk_id ?>"><?php echo "Rp. ".number_format($total) . " ,-"; ?></strong></td>
													</tr>

													<?php
													$total = 0;

												}

												?>

											</tbody>
											<tfoot>
												<tr>
													<th class="empty" colspan="2"></th>
													<th>TOTAL BAYAR</th>
													<th class="text-center"><span id="tampil_total"><?php echo "Rp. ".number_format($jumlah_total) . " ,-"; ?></span></th>
												</tr>
											</tfoot>
										</table>
										<input type="hidden" name="total_bayar" id="total_bayar" value="<?php echo $jumlah_total; ?>">

										<?php
									}else{

										echo "<br><br><br><h3><center>Keranjang Masih Kosong. Yuk <a href='<?php echo base_url() ?>'>belanja</a> !</center></h3><br><br><br>";
									}


								}else{
									echo "<br><br><br><h3><center>Keranjang Masih Kosong. Yuk <a href='<?php echo base_url() ?>'>belanja</a> !</center></h3><br><br><br>";
								}
								?>

							</div>
						</form>


					</div>






				</div>

			</div>

		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /section -->
