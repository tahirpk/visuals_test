<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {

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
		
		

               
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']     = '100';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';
		
		$this->load->library('upload', $config);
		require_once(APPPATH . 'libraries/2checkout/Twocheckout.php');
						
        $this->load->view('checkout_form');
              
				
	}
	
	public function tocheckout()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']     = '100';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';
		
		$this->load->library('upload', $config);
		require_once(APPPATH . 'libraries/2checkout/Twocheckout.php');
						
        $this->load->view('checkout_form');
              
		
	}
	
	public function successCheckout()
	{
		$this->load->model('checkout_model');
		require_once(APPPATH . 'libraries/2checkout/Twocheckout.php');
		Twocheckout::privateKey('FCF44591-9D4F-46DA-BEE1-1763D029D89E'); 
		Twocheckout::sellerId('901307958');
		Twocheckout::verifySSL(false); 
		Twocheckout::username('tahirpk');
		Twocheckout::password('Pakistan123');
		Twocheckout::sandbox(true);
		
		
		 $data=array(
            'makers'=>$this->input->post('makers'),
            'models'=>$this->input->post('models'),
            'years'=> $this->input->post('years'),            
            'autoConditions'=>$this->input->post('autoConditions'),);
			$result_id=$this->checkout_model->save($data);
			if($result_id!=false){
				echo 'value inserted in db'.$result_id;
			}else echo 'some thing is wrong with data.';
			
		try {
    	$charge = Twocheckout_Charge::auth(array(
        "merchantOrderId" => "123",
        "token"      => $this->input->post('token'),
        "currency"   => $this->input->post('currency'),
        "total"      => $this->input->post('amount'),
        "billingAddr" => array(
            "name" => 'Testing Tester',
            "addrLine1" => '123 Test St',
            "city" => 'Columbus',
            "state" => 'OH',
            "zipCode" => '43123',
            "country" => 'USA',
            "email" => 'tahirpk@gmail.com',
            "phoneNumber" => '555-555-5555'
        )
    ));

		if ($charge['response']['responseCode'] == 'APPROVED') {
			echo "Thanks for your Order! <br> Your Ad Detail is:<br>";
			$this->checkout_model->update($result_id);
			$ad_data=$this->checkout_model->get_info($result_id);
			echo $ad_data->makers;
			//print_r($ad_data);
			
			echo "<h3>Return Parameters:</h3>";
			echo "<pre>";
			print_r($charge);
			echo "</pre>";
	
		}
	} catch (Twocheckout_Error $e) {
		print_r($e->getMessage());
	}

	}
	
}
