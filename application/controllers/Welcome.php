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
        // $this->load->helper('cookie');
		// setcookie('api_hit', '1', time() + 60);		

		$this->load->view('welcome_message');	

	}

	// public function ex()
	// {
    //     $this->load->helper('cookie');	

	// 	echo '<pre>';
	// 	print_r(setcookie('api_hit')); die;

	// 	$this->load->view('welcome_message');	

	// }

	// public function index() {
		
	// 	// session_start();

	// 	// Set a session variable
	// 	$_SESSION['user'] = 10;
	
	// 	// Set session expiration to 60 seconds
	// 	if (isset($_SESSION['CREATED'])) {
	// 		if (time() - $_SESSION['CREATED'] > 5) {
	// 			// Session started more than 60 seconds ago
	// 			session_unset();     // Unset $_SESSION variables
	// 			session_destroy();   // Destroy the session
	// 		}
	// 	} else {
	// 		$_SESSION['CREATED'] = time();
	// 	}
	
	// 	// Optionally, you can regenerate the session ID to prevent fixation attacks
	// 	if (!isset($_SESSION['LAST_ACTIVITY']) || (time() - $_SESSION['LAST_ACTIVITY'] > 60)) {
	// 		session_regenerate_id(true); // Regenerate session ID and delete old session
	// 		$_SESSION['LAST_ACTIVITY'] = time(); // Update last activity time
	// 	}

	// 	$this->load->view('welcome_message');
	// }
	
	// public function ex() {
	// 	echo '<pre>';
	// 	print_r($_SESSION);	
	// 	die;  // Terminate script execution after checking the cookie
	// }



	






}
