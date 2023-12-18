<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <title>MAHESA WEDDING</title>

  <!-- Google font -->
  <link href="https://fonts.googleapis.com/css?family=Hind:400,700" rel="stylesheet">

  <!-- Bootstrap -->
  <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>frontend/css/bootstrap.min.css" />

  <!-- Slick -->
  <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>frontend/css/slick.css" />
  <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>frontend/css/slick-theme.css" />

  <!-- nouislider -->
  <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>frontend/css/nouislider.min.css" />

  <!-- Font Awesome Icon -->
  <link rel="stylesheet" href="<?php echo base_url() ?>frontend/css/font-awesome.min.css">

  <!-- Custom stlylesheet -->
  <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>frontend/css/style.css" />
</head>

<body>

  <style>
    .product-name {
      height: 5px;
    }
  </style>
  <!-- HEADER -->
  <header>
    
    <!-- header -->
    <div id="header">
      <div class="container">
        <div class="pull-left">
          <!-- Logo -->
          <div class="header-logo">
            <a class="logo" href="<?php echo base_url() ?>">
              <img src="<?php echo base_url() ?>gambar/sistem/logo.png" alt="">
            </a>
          </div>
          <!-- /Logo -->

          <!-- Search -->
          <div class="header-search">
            <form action="<?php echo base_url() ?>" method="get">
              <input class="input" type="text" name="cari" placeholder="Telusuri ..">
              <button class="search-btn"><i class="fa fa-search"></i></button>
            </form>
          </div>
          <!-- /Search -->
        </div>
        <div class="pull-right">
          <ul class="header-btns">
            
            <!-- Cart -->
            <li class="header-cart dropdown default-dropdown">

              <?php 
              if(isset($_SESSION['keranjang'])){
                $jumlah_isi_keranjang = count($_SESSION['keranjang']);
              }else{
                $jumlah_isi_keranjang = 0;
              }
              ?>

              <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                <div class="header-btns-icon">
                  <i class="fa fa-shopping-cart"></i>
                  <span class="qty"><?php echo $jumlah_isi_keranjang; ?></span>
                </div>
                <strong class="text-uppercase">List Pemesanan :</strong>
                <br>
                <?php 
                $total = 0;
                $jumlah_total = 0;
                if(isset($_SESSION['keranjang'])){
                  $jumlah_isi_keranjang = count($_SESSION['keranjang']);
                  for($a = 0; $a < $jumlah_isi_keranjang; $a++){
                    $id_produk = $_SESSION['keranjang'][$a]['produk'];
                    $jml = $_SESSION['keranjang'][$a]['jumlah'];
                    $i = $this->db->query("select * from produk where produk_id='$id_produk'")->row();
                    $total += $i->produk_harga*$jml;
                    $jumlah_total += $total;
                    $total = 0;
                  }
                }
                ?>
                <span><?php echo "Rp. ".number_format($jumlah_total)." ,-"; ?></span>
              </a>
              <div class="custom-menu" style="left: 100px;">
                <div id="shopping-cart">
                  <div class="shopping-cart-list">
                          <div class="product product-widget">
                            <div class="product-thumb">
                              <?php if($i->produk_foto1 == ""){ ?>
                                <img src="<?php echo base_url() ?>gambar/sistem/produk.png">
                              <?php }else{ ?>
                                <img src="<?php echo base_url() ?>gambar/produk/<?php echo $i->produk_foto1 ?>">
                              <?php } ?>
                            </div>  
                            <div class="product-body">
                              <h3 class="product-price"><?php echo "Rp. ".number_format($i->produk_harga) . " ,-"; ?></h3>
                              <h2 class="product-name"><a href="<?php echo base_url() ?>welcome/produk_detail/<?php echo $i->produk_id ?>"><?php echo $i->produk_nama ?></a></h2>
                            </div>
                            <a class="cancel-btn" href="<?php echo base_url() ?>welcome/keranjang_hapus?id=<?php echo $i->produk_id; ?>&redirect=keranjang"><i class="fa fa-trash"></i></a>
                          </div>

                          <?php

                        }
                      }else{
                        echo "<center>Keranjang Masih Kosong.</center>";
                      }
                      

                    }else{
                      echo "<center>Keranjang Masih Kosong.</center>";
                    }
                    ?>
                    
                  </div>
                  <div class="shopping-cart-btns">
                    <a class="main-btn" href="<?php echo base_url('welcome/keranjang') ?>">List Pemesanan</a>
                    <a class="primary-btn" href="<?php echo base_url('welcome/checkout') ?>">Bayar <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
              </div>
            </li>
            <!-- /Cart -->

            <?php 
            if(isset($_SESSION['customer_status'])){
              $id_customer = $_SESSION['customer_id'];
              $c = $this->db->query("select * from customer where customer_id='$id_customer'")->row();
              
              ?>
              <!-- Account -->
              <li class="header-account dropdown default-dropdown" style="min-width: 200px">
                <div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
                  <div class="header-btns-icon">
                    <i class="fa fa-user-o"></i>
                  </div>
                  <strong class="text-uppercase"><?php echo $c->customer_nama; ?> <i class="fa fa-caret-down"></i></strong>
                </div>
                <span><?php echo $c->customer_email; ?></span>
                <ul class="custom-menu" style="left: 100px;">
                  <li><a href="<?php echo base_url('welcome/customer') ?>"><i class="fa fa-user-o"></i> Akun Saya</a></li>
                  <li><a href="<?php echo base_url('welcome/customer_pesanan') ?>"><i class="fa fa-list"></i> Pesanan Saya</a></li>
                  <li><a href="<?php echo base_url('welcome/customer_password') ?>"><i class="fa fa-lock"></i> Ganti Password</a></li>
                  <li><a href="<?php echo base_url('welcome/customer_logout') ?>"><i class="fa fa-sign-out"></i> Keluar</a></li>
                </ul>
              </li>
              <!-- /Account -->
              <?php
            }else{
              ?>
              <li class="header-account dropdown default-dropdown">
                <a href="<?php echo base_url('welcome/masuk') ?>" class="text-uppercase main-btn">Login</a> 
                <a href="<?php echo base_url('welcome/daftar') ?>" class="text-uppercase primary-btn">Daftar</a> 
              </li>
              <?php
            }
            ?>

            <!-- Mobile nav toggle-->
            <li class="nav-toggle">
              <button class="nav-toggle-btn main-btn icon-btn"><i class="fa fa-bars"></i></button>
            </li>
            <!-- / Mobile nav toggle -->
          </ul>
        </div>
      </div>
      <!-- header -->
    </div>
    <!-- container -->
  </header>
  <!-- /HEADER -->

  <!-- NAVIGATION -->
  <div id="navigation">
    <!-- container -->
    <div class="container">
      <div id="responsive-nav">
        <!-- category nav -->
        <div class="category-nav show-on-click">
          <span class="category-header">Pilih Kategori <i class="fa fa-list"></i></span>
          <ul class="category-list">
            <?php 
            $data = $this->db->query("SELECT * FROM kategori")->result();
            foreach($data as $d){
              ?>
              <li><a href="<?php echo base_url() ?>welcome/produk_kategori/<?php echo $d->kategori_id; ?>"><?php echo $d->kategori_nama; ?></a></li>
              <?php 
            }
            ?>
            <li style="background: #999;"><a href="<?php echo base_url() ?>" style="color: white">Tampilkan Semua</a></li>
          </ul>
        </div>
        <!-- /category nav -->

        <!-- menu nav -->
        <div class="menu-nav">
          <span class="menu-header">Menu <i class="fa fa-bars"></i></span>
          <ul class="menu-list">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url(); ?>">Booking</a></li>
            <?php 
            if(!isset($_SESSION['customer_status'])){
              ?>
              <li><a href="<?php echo base_url(); ?>login">Login Admin</a></li>
              <?php 
            }
            ?>
          </ul>
        </div>
        <!-- menu nav -->
      </div>
    </div>
    <!-- /container -->
  </div>
  <!-- /NAVIGATION -->

















