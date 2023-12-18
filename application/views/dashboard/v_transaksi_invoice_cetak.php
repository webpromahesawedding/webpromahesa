<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<style>
	body{
		font-family: sans-serif;
	}

	.table{
		border-collapse: collapse;
	}
	.table th,
	.table td{
		padding: 5px 10px;
		border: 1px solid black;
	}
</style>

<div>

	<?php 
		foreach($invoice as $i){
		?>
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
						$id_invoice = $i->invoice_id;
						$transaksi = $this->db->query("select * from transaksi,produk where transaksi_produk=produk_id and transaksi_invoice='$id_invoice'")->result();
						foreach($transaksi as $d){
							$total += $d->transaksi_harga;
						?>
						<tr>
							<td class="text-center"><?php echo $no++; ?></td>
							<td>
								<center>
									<?php if($d->produk_foto1 == ""){ ?>
									<img src="<?php echo base_url(); ?>gambar/sistem/produk.png" style="width: 50px;height: auto">
									<?php }else{ ?>
									<img src="<?php echo base_url(); ?>gambar/produk/<?php echo $d->produk_foto1 ?>" style="width: 50px;height: auto">
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


		<?php 
		}
	?>

</div>


<script>
	window.print();
</script>
</body>
</html>