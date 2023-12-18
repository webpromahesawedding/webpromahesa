
<!-- BREADCRUMB -->
<div id="breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="<?php echo base_url() ?>">Home</a></li>
			<li class="active">Dashboard Customer</li>
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
				
				<h4>DASHBOARD</h4>

				<div id="store">

					<div class="row">

						<div class="col-lg-12">
							
							<h5>Halo, Selamat Datang!</h5>

							<table class="table table-bordered">
								<tbody>
									<?php 
									$id = $_SESSION['customer_id'];
									$customer = $this->db->query("select * from customer where customer_id='$id'");
									$i = $customer->row();
									?>
									<tr>
										<th width="20%">Nama</th>	
										<td><?php echo $i->customer_nama ?></td>
									</tr>
									<tr>
										<th width="20%">Email</th>	
										<td><?php echo $i->customer_email ?></td>
									</tr>
									<tr>
										<th>HP</th>	
										<td><?php echo $i->customer_hp ?></td>
									</tr>
									<tr>
										<th>Alamat</th>	
										<td><?php echo $i->customer_alamat ?></td>
									</tr>
								</tbody>
							</table>
						</div>


					</div>
				</div>

			</div>
		</div>
	</div>
</div>
