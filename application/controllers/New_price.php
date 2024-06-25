<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class New_price extends CI_Controller {

    function __construct()
    {       
        parent::__construct();       
        $this->load->model('new_model');
        date_default_timezone_set('Asia/Kolkata');
    }

    public function index()
    { 
        // echo 'hh'; die; 
        $this->load->view('pixelPriceShow');        
    }  

    function renderData(){      
        $price_list = $this->insert_and_update_data_show();
        echo json_encode($price_list);
    } 

    function insert_and_update_data_show() {
        $price_list = $this->new_model->get_price_list(3);       
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
            $last_api_call = $this->new_model->get_last_api_call();
            if ($last_api_call && (time() - strtotime($last_api_call->last_call)) < 60) {
                // If the last API call was within 60 seconds, return the current price list
                return $price_list;
            }
            
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
                $this->new_model->add_price($post_data);
                $this->new_model->update_last_api_call();

                $price_list = $this->new_model->get_price_list(3);
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
    
}

?>
