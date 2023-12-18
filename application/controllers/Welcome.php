<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
	{
		// session_start();
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');

		$this->load->model('m_data');


		$file = $this->uri->segment(2);

		if(!isset($_SESSION['customer_status'])){
 			// halaman yg dilindungi jika customer belum login
			$lindungi = array('customer','customer_logout');
 			// periksa halaman, jika belum login ke halaman di atas, maka alihkan halaman
			if(in_array($file, $lindungi)){
				redirect(base_url());
			}
			if($file == "checkout"){
				redirect(base_url()."welcome/masuk?alert=login-dulu");
			}

		}else{
 			// halaman yg tidak boleh diakses jika customer sudah login
			$lindungi = array('masuk','daftar');
 			// periksa halaman, jika sudah dan mengakses halaman di atas, maka alihkan halaman
			if(in_array($file, $lindungi)){
				redirect(base_url()."welcome/customer");
			}
		}

		if($file == "checkout"){
			if(!isset($_SESSION['keranjang']) || count($_SESSION['keranjang']) == 0){
				redirect(base_url()."welcome/keranjang?alert=keranjang_kosong");
			}
		}

	}

	public function index()
	{	
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_index');
		$this->load->view('frontend/v_footer');
	}

	public function produk_detail($id)
	{
		$data['data'] = $this->db->query("select * from produk,kategori where kategori_id=produk_kategori and produk_id='$id'")->result();

		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_detail', $data);
		$this->load->view('frontend/v_footer');
	}

	public function produk_kategori($id)
	{
		$data['data'] = $this->db->query("select * from produk,kategori where kategori_id=produk_kategori and produk_id='$id'")->result();
		$data['k'] = $this->db->query("select * from kategori where kategori_id='$id'")->row();
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_kategori', $data);
		$this->load->view('frontend/v_footer');
	}


	public function keranjang()
	{
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_keranjang');
		$this->load->view('frontend/v_footer');
	}


	public function keranjang_hapus()
	{

		$id_produk = $_GET['id'];
		$redirect = $_GET['redirect'];

		if(isset($_SESSION['keranjang'])){

			for($a=0;$a<count($_SESSION['keranjang']);$a++){
				if($_SESSION['keranjang'][$a]['produk'] == $id_produk){
					unset($_SESSION['keranjang'][$a]);
					sort($_SESSION['keranjang']);
				}
			}
		}

		if($redirect == "index"){
			$r = "";
		}elseif($redirect == "detail"){
			$r = "welcome/produk_detail/".$id_produk;
		}elseif($redirect == "keranjang"){
			$r = "welcome/keranjang";
		}

		redirect(base_url().$r);

	}


	public function keranjang_masukkan()
	{

		$id_produk = $_GET['id'];
		$redirect = $_GET['redirect'];

		$d = $this->db->query("select * from produk,kategori where kategori_id=produk_kategori and produk_id='$id_produk'")->row();
		
		if(isset($_SESSION['keranjang'])){
			$jumlah_isi_keranjang = count($_SESSION['keranjang']);
			$sudah_ada = 0;
			for($a = 0;$a < $jumlah_isi_keranjang; $a++){
				// cek apakah produk sudah ada dalam keranjang
				if($_SESSION['keranjang'][$a]['produk'] == $id_produk){
					$sudah_ada = 1;
				}
			}
			if($sudah_ada == 0){
				$_SESSION['keranjang'][$jumlah_isi_keranjang] = array(
					'produk' => $id_produk,
					'jumlah' => 1
				);
			}
		}else{
			$_SESSION['keranjang'][0] = array(
				'produk' => $id_produk,
				'jumlah' => 1
			);
		}

		if($redirect == "index"){
			$r = "";
		}elseif($redirect == "detail"){
			$r = "welcome/produk_detail/".$id_produk;
		}elseif($redirect == "keranjang"){
			$r = "welcome/keranjang";
		}

		redirect(base_url().$r);
	}



	public function keranjang_update()
	{

		$produk = $this->input->post('produk');
		$jumlah = $this->input->post('jumlah');

		$jumlah_isi_keranjang = count($_SESSION['keranjang']);

		for($a = 0;$a < $jumlah_isi_keranjang; $a++){

			$_SESSION['keranjang'][$a] = array(
				'produk' => $produk[$a],
				'jumlah' => $jumlah[$a]
			);

		}
		redirect(base_url().'welcome/keranjang');
	}



	public function daftar()
	{
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_daftar');
		$this->load->view('frontend/v_footer');
	}

	public function daftar_act()
	{
		
		$nama  = $this->input->post('nama');
		$email = $this->input->post('email');
		$hp = $this->input->post('hp');
		$alamat = $this->input->post('alamat');
		$password = md5($this->input->post('password'));
		// echo $email;
		$cek_email = $this->db->query("select * from customer where customer_email='$email'");
		if($cek_email->num_rows() > 0){
			redirect(base_url().'welcome/daftar?alert=duplikat');
		}else{
			$data = array(
				'customer_nama' => $nama,
				'customer_email' => $email,
				'customer_hp' => $hp,
				'customer_alamat' => $alamat,
				'customer_password' => $password
			);
			$this->m_data->insert_data($data,'customer');
			redirect(base_url().'welcome/masuk?alert=terdaftar');
		}

	}


	public function masuk()
	{
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_masuk');
		$this->load->view('frontend/v_footer');
	}

	public function masuk_act()
	{
		
		// menangkap data yang dikirim dari form
		$email = $this->input->post('email');
		$password = md5($this->input->post('password'));

		$login = $this->db->query("SELECT * FROM customer WHERE customer_email='$email' AND customer_password='$password'");
		$cek = $login->num_rows();

		if($cek > 0){
			$data = $login->row();

			// hapus session yg lain, agar tidak bentrok dengan session customer
			unset($_SESSION['id']);
			unset($_SESSION['nama']);
			unset($_SESSION['username']);
			unset($_SESSION['status']);

			// buat session customer
			$_SESSION['customer_id'] = $data->customer_id;
			$_SESSION['customer_status'] = "login";
			redirect(base_url()."welcome/customer");
		}else{
			redirect(base_url()."welcome/masuk?alert=gagal");
		}


	}


	public function checkout()
	{
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_checkout');
		$this->load->view('frontend/v_footer');
	}

	public function checkout_act()
	{

		$id_customer = $_SESSION['customer_id'];
		$tanggal = date('Y-m-d');
		$nama = $this->input->post('nama');
		$hp = $this->input->post('hp');
		$alamat = $this->input->post('alamat');
		$kabupaten = $this->input->post('kabupaten');
		$total_bayar = $this->input->post('total_bayar');

		$data = array(
			'invoice_tanggal' => $tanggal,
			'invoice_customer' => $id_customer,
			'invoice_nama' => $nama, 	
			'invoice_hp' => $hp, 	
			'invoice_alamat' => $alamat,
			'invoice_kabupaten' => $kabupaten,
			'invoice_total_bayar' => $total_bayar,
			'invoice_status' => '0',
			'invoice_bukti' => '0', 
		);

		$this->m_data->insert_data($data, 'invoice');

		$last_id = $this->db->insert_id();
		$invoice = $last_id;
		$jumlah_isi_keranjang = count($_SESSION['keranjang']);
		for($a = 0; $a < $jumlah_isi_keranjang; $a++){
			$id_produk = $_SESSION['keranjang'][$a]['produk'];
			$jml = $_SESSION['keranjang'][$a]['jumlah'];


			$isi = $this->db->query("select * from produk where produk_id='$id_produk'");
			$i = $isi->row();

			$produk = $i->produk_id;
			$jumlah = $_SESSION['keranjang'][$a]['jumlah'];
			$harga = $i->produk_harga;

			$data = array(
				'transaksi_invoice' => $invoice,
				'transaksi_produk' => $produk,
				'transaksi_jumlah' => $jumlah, 	
				'transaksi_harga' => $harga
			);

			$this->m_data->insert_data($data, 'transaksi');
			unset($_SESSION['keranjang'][$a]);
		}

		redirect(base_url()."welcome/customer_pesanan?alert=sukses");
	}



	public function customer()
	{
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_customer');
		$this->load->view('frontend/v_footer');
	}

	public function customer_logout(){

		unset($_SESSION['customer_id']);
		unset($_SESSION['customer_status']);

		redirect(base_url()."welcome");
	}

	public function customer_password(){
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_customer_password');
		$this->load->view('frontend/v_footer');
	}

	public function customer_password_act(){
		$id = $_SESSION['customer_id'];
		$password = md5($this->input->post('password'));

		$where = array(
			'customer_id' => $id
		);

		$data = array(
			'customer_password' => $password
		);

		$this->m_data->update_data($where, $data, 'customer');

		redirect(base_url()."welcome/customer_password?alert=sukses");
	}


	public function customer_pesanan(){
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_customer_pesanan');
		$this->load->view('frontend/v_footer');
	}

	public function customer_invoice(){
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_customer_invoice');
		$this->load->view('frontend/v_footer');
	}

	public function customer_invoice_cetak(){
		$this->load->view('frontend/v_customer_invoice_cetak');
	}


	public function customer_pembayaran(){
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_customer_pembayaran');
		$this->load->view('frontend/v_footer');
	}

	public function customer_pembayaran_act(){

		$id = $this->input->post('id');

		$config['encrypt_name'] = TRUE;
		$config['upload_path']   = './gambar/bukti_pembayaran/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';

		$this->load->library('upload', $config);

		if($this->upload->do_upload('bukti')){
			$bukti = $this->upload->do_upload('bukti');
			$gambar1 = $this->upload->data();
			$bukti1 = $gambar1['file_name'];

			// hapus gambar lama
			$lama = $this->db->query("select * from invoice where invoice_id='$id'");
			$l = $lama->row();
			$foto = $l->invoice_bukti;

			@chmod('./gambar/bukti_pembayaran/'.$foto, 0777);
			@unlink('./gambar/bukti_pembayaran/'.$foto);

			$where = array(
				'invoice_id' => $id
			);

			$data = array(
				'invoice_bukti' => $bukti1,
				'invoice_status' => '1'
			);

			$this->m_data->update_data($where, $data, 'invoice');

			redirect(base_url()."welcome/customer_pesanan?alert=upload");

		}else{
			redirect(base_url()."welcome/customer_pesanan?alert=gagal");
		}

	}


	public function notfound()
	{
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_notfound');
		$this->load->view('frontend/v_footer');
	}
}
