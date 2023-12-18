<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Customer
      <small>Customer Website</small>
    </h1>
  </section>

  <section class="content">

    <div class="row">
      <div class="col-lg-12">

        <a href="<?php echo base_url().'dashboard/customer_tambah'; ?>" class="btn btn-sm btn-primary">Buat customer baru</a>

        <br/>
        <br/>

        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Customer</h3>
          </div>
          <div class="box-body">
            <table class="table table-bordered table-striped" id="table-datatable">
              <thead>
                <tr>
                  <th width="1%">NO</th>
                  <th>NAMA</th>
                  <th>EMAIL</th>
                  <th>HP</th>
                  <th>ALAMAT</th>
                  <th width="10%">OPSI</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $no = 1;
                foreach($customer as $c){
                  ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $c->customer_nama; ?></td>
                    <td><?php echo $c->customer_email; ?></td>
                    <td><?php echo $c->customer_hp; ?></td>
                    <td><?php echo $c->customer_alamat; ?></td>
                    <td>            
                      <a href="<?php echo base_url().'dashboard/customer_edit/'.$c->customer_id; ?>" class="btn btn-warning btn-sm"> <i class="fa fa-pencil"></i> </a>
                      <a href="<?php echo base_url().'dashboard/customer_hapus/'.$c->customer_id; ?>" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> </a>
                    </td>
                  </tr>
                  <?php 
                }
                ?>
              </tbody>
            </table>
            

          </div>
        </div>

      </div>
    </div>

  </section>

</div>