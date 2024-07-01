<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pixel_price extends CI_Controller {

    function __construct()
    {       
        parent::__construct();       
        $this->load->model('pixel_price_model');
        date_default_timezone_set('Asia/Kolkata');
    }

	public function index()
	{ 
		$this->load->view('pixelPriceShow');		
	}  

    function renderData(){      
        $price_list=$this->insert_and_update_data_show();
        echo json_encode($price_list);
    } 

    function insert_and_update_data_show() {
        $price_list = $this->pixel_price_model->get_price_list(3);       
        $needs_update = 0;
    
        if (count($price_list) > 0) {
            $latest_price_details = $price_list[0];
            $last_update = strtotime($latest_price_details->added_on);           
            if (!$last_update || (time() - $last_update) >= 60) {              
                $needs_update = 1;
            }else{
                //time is less to 1 min
                echo 'time is less to 1 min'; die;
                $price_list = $this->pixel_price_model->get_price_list(3); 
            }
        }
    
        if ($needs_update) {
            // echo 'true'; die;

            $new_price_details = $this->get_pixel_api_data();
            if ($new_price_details) {
                $post_data = [
                    "symbol" => $new_price_details['data']['symbol'],
                    "bidPrice" => $new_price_details['data']['bidPrice'],
                    "bidQty" => $new_price_details['data']['bidQty'],
                    "askPrice" => $new_price_details['data']['askPrice'],
                    "askQty" => $new_price_details['data']['askQty'],
                    "time" => $new_price_details['data']['time'],
                    "added_on" => date("Y-m-d H:i:s"),
                ];
                $this->pixel_price_model->add_price($post_data);
               
                $price_list = $this->pixel_price_model->get_price_list(3);
            } else {               
                echo 'Failed to get data from API';
            }
        }else{
            // echo 'false'; die;
            $new_price_details = $this->get_pixel_api_data();

            if ($new_price_details) {
                $post_data = [
                    "symbol" => $new_price_details['data']['symbol'],
                    "bidPrice" => $new_price_details['data']['bidPrice'],
                    "bidQty" => $new_price_details['data']['bidQty'],
                    "askPrice" => $new_price_details['data']['askPrice'],
                    "askQty" => $new_price_details['data']['askQty'],
                    "time" => $new_price_details['data']['time'],
                    "added_on" => date("Y-m-d H:i:s"),
                ];
                $this->pixel_price_model->add_price($post_data);

               
                $price_list = $this->pixel_price_model->get_price_list(3);
            } else {              
                echo 'Failed to get data from API';
            }
           
        }
    
        return $price_list;
    }
    

    public function get_pixel_api_data() {		
		$url = 'https://io.pixelsoftwares.com/task_php_api.php';
		$token = 'ab4086ecd47c568d5ba5739d4078988f';
		$symbol = 'BTCUSDT';

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, ['symbol' => $symbol]);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'token: ' . $token,
		]);

		$response = curl_exec($ch);
		curl_close($ch);

		if ($response === false) {
			echo 'Curl error: ' . curl_error($ch);
		} else {
			$data = json_decode($response, true);
			if (json_last_error() === JSON_ERROR_NONE) {			
				if ($data['status'] == 1) {
                    return $data;
                } else {
                    echo 'API error'; die;
                }
			} else {
				echo 'JSON decode error: ' . json_last_error_msg();
				echo "\nRaw response:\n$response";
			}
		}
	}

    // public function get_pixel_api_data() {
    //     $url = 'https://io.pixelsoftwares.com/task_php_api.php';
	// 	$token = 'ab4086ecd47c568d5ba5739d4078988f';
	// 	$symbol = 'BTCUSDT';
    
    //     $ch = curl_init($url);
    
    //     // Set cURL options for POST request and data transfer
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, ['symbol' => $symbol]);
    
    //     // token Set authorization header
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //         'token: ' . $token,
    //     ]);
    
    //     $response = curl_exec($ch);
    
    //     // Handle cURL errors
    //     if ($response === false) {
    //         echo 'Curl error: ' . curl_error($ch);
    //         curl_close($ch);
    //         return false; // Indicate error
    //     } else {
    //         curl_close($ch);
    //     }
    
    //     // Decode JSON response and validate data structure
    //     $data = json_decode($response, true);
    //     if (json_last_error() !== JSON_ERROR_NONE) {
    //         echo 'JSON decode error: ' . json_last_error_msg();
    //         echo "\nRaw response:\n$response";
    //         return false; // Indicate error
    //     }
    
    //     // Implement specific API validation logic here (replace with your checks)
    //     if (!isset($data['status']) || !isset($data['data'])) {
    //         echo 'Invalid API response format';
    //         return false; // Indicate error
    //     }
    
    //     // Check for API success status and handle errors (replace with API-specific checks)
    //     if ($data['status'] !== 'success') {
    //         if (isset($data['message'])) {
    //             echo 'API error: ' . $data['message'];
    //         } else {
    //             echo 'API error (unknown)';
    //         }
    //         return false; // Indicate error
    //     }
    
    //     // If validation and error checks pass, return the valid data
    //     return $data;
    // }
    

}
