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
        $price_list=$this->insert_and_update_data_show();
        $data['price_list']=$price_list;
		$this->load->view('pixelPriceShow',$data);		
	}  

    function renderData(){      
        $price_list=$this->insert_and_update_data_show();
        echo json_encode($price_list);
    } 

    function insert_and_update_data_show() {
        $price_list = $this->pixel_price_model->get_price_list(5);       
        $needs_update = false;
    
        if (count($price_list) > 0) {
            $latest_price_details = $price_list[0];
            $last_update = strtotime($latest_price_details->added_on);           
            if (!$last_update || (time() - $last_update) >= 60) {              
                $needs_update = true;
            }
        } else {
            $needs_update = true;
        }
    
        if ($needs_update) {
            $new_price_details = $this->get_pixel_api_data();
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
            $price_list = $this->pixel_price_model->get_price_list(5);
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
				return $data;
			} else {
				echo 'JSON decode error: ' . json_last_error_msg();
				echo "\nRaw response:\n$response";
			}
		}
	}

}
