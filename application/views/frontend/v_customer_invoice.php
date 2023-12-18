<!-- BREADCRUMB -->
<div id="breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="<?php echo base_url() ?>">Home</a></li>
			<li class="active">Invoice Customer</li>
		</ul>
	</div>
</div>
<!-- /BREADCRUMB -->

<div class="section">
	<div class="container">
		<div class="row">

			<?php 
			$this->load->view('frontend/v_customer_sidebar');
			?>

			<div id="main" class="col-md-9">

				<h4>INVOICE</h4>

				<div id="store">
					<div class="row">

						<?php 
						$id_invoice = $_GET['id'];
						$id = $_SESSION['customer_id'];
						$invoice = $this->db->query("select * from invoice where invoice_customer='$id' and invoice_id='$id_invoice' order by invoice_id desc")->result();
					
						foreach($invoice as $i){
							?>


							<div class="col-lg-12">

								<a href="<?php echo base_url() ?>welcome/customer_invoice_cetak?id=<?php echo $_GET['id'] ?>" target="_blank" class="btn btn-default btn-sm"><i class="fa fa-print"></i> CETAK</a>

								<br/>
								<br/>

								<h4>INVOICE-00<?php echo $i->invoice_id ?></h4>


								<br/>
								<?php echo $i->invoice_nama; ?><br/>
								<?php echo $i->invoice_alamat; ?><br/>
								<?php echo $i->invoice_kabupaten; ?><br/>
								Hp. <?php echo $i->invoice_hp; ?><br/>
								<br/>

								<div class="table-responsive">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th class="text-center" width="1%">NO</th>
												<th colspan="2">Produk</th>
												<th class="text-center">Harga</th>
												<th class="text-center">Jumlah</th>
												<th class="text-center">Total Harga</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											$no = 1;
											$total = 0;
											$transaksi = $this->db->query("select * from transaksi,produk where transaksi_produk=produk_id and transaksi_invoice='$id_invoice'")->result();
											foreach($transaksi as $d){
												$total += $d->transaksi_harga;
												?>
												<tr>
													<td class="text-center"><?php echo $no++; ?></td>
													<td>
														<center>
															<?php if($d->produk_foto1 == ""){ ?>
																<img src="<?php echo base_url() ?>gambar/sistem/produk.png" style="width: 50px;height: auto">
															<?php }else{ ?>
																<img src="<?php echo base_url() ?>gambar/produk/<?php echo $d->produk_foto1 ?>" style="width: 50px;height: auto">
															<?php } ?>
														</center>
													</td>
													<td><?php echo $d->produk_nama; ?></td>
													<td class="text-center"><?php echo "Rp. ".number_format($d->transaksi_harga).",-"; ?></td>
													<td class="text-center"><?php echo number_format($d->transaksi_jumlah); ?></td>
													<td class="text-center"><?php echo "Rp. ".number_format($d->transaksi_jumlah * $d->transaksi_harga)." ,-"; ?></td>
												</tr>
												<?php 
											}
											?>
										</tbody>
										<tfoot>
											<tr>
												<td colspan="4" style="border: none"></td>
												<th>Total Bayar</th>
												<td class="text-center"><?php echo "Rp. ".number_format($i->invoice_total_bayar)." ,-"; ?></td>
											</tr>
										</tfoot>
									</table>
								</div>


								<h5>STATUS :</h5> 
								<?php 
								if($i->invoice_status == 0){
									echo "<span class='label label-warning'>Menunggu Pembayaran</span>";
								}elseif($i->invoice_status == 1){
									echo "<span class='label label-default'>Menunggu Konfirmasi</span>";
								}elseif($i->invoice_status == 2){
									echo "<span class='label label-danger'>Ditolak</span>";
								}elseif($i->invoice_status == 3){
									echo "<span class='label label-primary'>Dikonfirmasi & Sedang Diproses</span>";
								}elseif($i->invoice_status == 4){
									echo "<span class='label label-warning'>Dikirim</span>";
								}elseif($i->invoice_status == 5){
									echo "<span class='label label-success'>Selesai</span>";
								}
								?>

							</div>	


							<?php 
						}
						?>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>