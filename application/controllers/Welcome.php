<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function test()
	{
		$this->load->view('check');
	}

	// public function get_pixel_data() {
	// 	// echo 'hh'; die;
	// 	$url = 'https://io.pixelsoftwares.com/task_php_api.php';
	// 	$token = 'ab4086ecd47c568d5ba5739d4078988f';
	// 	$symbol = 'BTCUSDT';

	// 	$ch = curl_init($url);
	// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// 	curl_setopt($ch, CURLOPT_POST, true);
	// 	curl_setopt($ch, CURLOPT_POSTFIELDS, ['symbol' => $symbol]);
	// 	curl_setopt($ch, CURLOPT_HTTPHEADER, [
	// 		'token: ' . $token,
	// 	]);

	// 	$response = curl_exec($ch);
	// 	curl_close($ch);

	// 	if ($response === false) {
	// 		echo 'Curl error: ' . curl_error($ch);
	// 	} else {
	// 		$data = json_decode($response, true);
	// 		if (json_last_error() === JSON_ERROR_NONE) {
	// 			// echo '<pre>';
	// 			// print_r($data); die;
	// 			return $data;
	// 		} else {
	// 			echo 'JSON decode error: ' . json_last_error_msg();
	// 			echo "\nRaw response:\n$response";
	// 		}
	// 	}
	// }

	function live_price_show(){
		// echo 'check live_price'; die;
		$this->load->library('session');
		// $this->load->view('price_list');
		$this->load->view('price_list_old');

	}


}
