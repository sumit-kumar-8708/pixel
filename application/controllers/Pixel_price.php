<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pixel_price extends CI_Controller {

    function __construct()
    {
        // echo 'hello'; die;
        parent::__construct();
        // $this->load->library('Api');
        $this->load->model('pixel_price_model');
        date_default_timezone_set('Asia/Kolkata');
    }

	public function index()
	{
        // echo 'hh'; die;
        $price_list=$this->check_price_and_update();
        $data['price_list']=$price_list;
		// $this->load->view('price_list',$data);
		$this->load->view('price_list_old',$data);
	}

    // function ajax_get_price(){
    //     // echo 'hello ajax'; die;
    //     $price_list=$this->check_price_and_update();
    //     echo json_encode($price_list);
    // }

    function renderData(){
        // echo 'hello ajax'; die;
        $price_list=$this->check_price_and_update();
        echo json_encode($price_list);
    }

    function check_price_and_update(){
        $price_list=$this->pixel_price_model->get_price_list(6);
        // echo '<pre>';
        // print_r($price_list); die;
        if(count($price_list)>0){
            $latest_price_details=$price_list[0];
            $price=$latest_price_details->bidPrice;
            $last_update=strtotime($latest_price_details->added_on);
            // echo time()-$last_update;die;
            if(!$last_update || (time()-$last_update)>=60){
                //after 60 sec
                $new_price_details=$this->get_pixel_api_data();                
                $post_data=[
                    "symbol"=>$new_price_details['data']['symbol'],
                    "bidPrice"=>$new_price_details['data']['bidPrice'],
                    "bidQty"=>$new_price_details['data']['bidQty'],
                    "askPrice"=>$new_price_details['data']['askPrice'],
                    "askQty"=>$new_price_details['data']['askQty'],
                    "time"=>$new_price_details['data']['time'],
                    "added_on"=>date("Y-m-d H:i:s"),
                ];
                $this->pixel_price_model->add_price($post_data);
                $price_list=$this->pixel_price_model->get_price_list(6);
                return $price_list;
            }else{
                return $price_list;
            }
        }else{
            //add price
            // echo 'jj'; die;
            $new_price_details=$this->get_pixel_api_data();           

            $post_data=[
                "symbol"=>$new_price_details['data']['symbol'],
                "bidPrice"=>$new_price_details['data']['bidPrice'],
                "bidQty"=>$new_price_details['data']['bidQty'],
                "askPrice"=>$new_price_details['data']['askPrice'],
                "askQty"=>$new_price_details['data']['askQty'],
                "time"=>$new_price_details['data']['time'],
                "added_on"=>date("Y-m-d H:i:s"),
            ];
            // echo 'hh';
            // echo '<pre>';
            // print_r($post_data); die;
            $this->pixel_price_model->add_price($post_data);           
            $price_list=$this->pixel_price_model->get_price_list(6);
            return $price_list;
        }
    }

    public function get_pixel_api_data() {
		// echo 'hh'; die;
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
				// echo '<pre>';
				// print_r($data); die;
				return $data;
			} else {
				echo 'JSON decode error: ' . json_last_error_msg();
				echo "\nRaw response:\n$response";
			}
		}
	}







    public function what(){
        echo 'gg'; die;
       return 'hello';
    }

}
