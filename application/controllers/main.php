<?php  
/**
* 
*/
class Main extends CI_Controller
{
	
	function __construct()
	{
		parent:: __construct();
	}

	public function index(){
		$this->load->view('index');
	}

	public function get_price(){
        $url= "https://sandbox-api.uber.com/v1/estimates/price";
        $parameters = array(
            "start_latitude" => $this->input->post('start_latitude'),
            "start_longitude" => $this->input->post('start_longitude'),
            "end_latitude" => $this->input->post('end_latitude'),
            "end_longitude" => $this->input->post('end_longitude'),
        );
        $url.="?start_latitude=".$parameters['start_latitude'];
        $url.="&start_longitude=".$parameters['start_longitude'];
        $url.="&end_latitude=".$parameters['end_latitude'];
       	$url.="&end_longitude=".$parameters['end_longitude'];

       	// $test_url='https://api.uber.com/v1/estimates/price?start_latitude=37.7759792&start_longitude=-122.41823&end_latitude=38&end_longitude=-122';
       	$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "",
		  CURLOPT_HTTPHEADER => array(
		    'Authorization: Token gA6j4S1t5EEAZUrcy6Xplift8BEFXRc6Zxwai8CQ',

		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo ($response);
		}

	}

	public function get_time(){
		$url= "https://sandbox-api.uber.com/v1/estimates/time";
        $parameters = array(
            "start_latitude" => $this->input->post('start_latitude'),
            "start_longitude" => $this->input->post('start_longitude'),
        );
        $url.="?start_latitude=".$parameters['start_latitude'];
        $url.="&start_longitude=".$parameters['start_longitude'];

       	$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "",
		  CURLOPT_HTTPHEADER => array(
		    'Authorization: Token gA6j4S1t5EEAZUrcy6Xplift8BEFXRc6Zxwai8CQ',

		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo ($response);
		}
	}

	public function get_product(){
        $url= "https://sandbox-api.uber.com/v1/products";
        $parameters = array(
            "latitude" => $this->input->post('start_latitude'),
            "longitude" => $this->input->post('start_longitude'),
        );
        $url.="?latitude=".$parameters['latitude'];
        $url.="&longitude=".$parameters['longitude'];

       	$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "",
		  CURLOPT_HTTPHEADER => array(
		    'Authorization: Token gA6j4S1t5EEAZUrcy6Xplift8BEFXRc6Zxwai8CQ',

		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo ($response);
		}

	}

	public function direction(){
		$html = file_get_contents("https://maps.googleapis.com/maps/api/directions/json?origin="
			.urlencode($this->input->post('origin'))."&destination=".urlencode($this->input->post('destination'))."&sensor=false"
			."&key=AIzaSyBtg6vAefdIUTyG4qbysXi31a1tf6jIXQQ");
  	$this->output
       ->set_content_type('application/json')
       ->set_output($html);
	}

	public function geocode_start(){

		$html = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address="
			.urlencode($this->input->post('origin'))
			."&key=AIzaSyBtg6vAefdIUTyG4qbysXi31a1tf6jIXQQ");
  	$this->output
       ->set_content_type('application/json')
       ->set_output($html);

	}

	public function geocode_end(){

		$html = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address="
			.urlencode($this->input->post('destination'))
			."&key=AIzaSyBtg6vAefdIUTyG4qbysXi31a1tf6jIXQQ");
  	$this->output
       ->set_content_type('application/json')
       ->set_output($html);

	}

	public function get_weather(){
		$html = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q="
			.urlencode($this->input->post('destination'))
			."id=xinyzhang9&APPID=d3214ca78ab69134a0e9113918f698cb");
  	$this->output
       ->set_content_type('application/json')
       ->set_output($html);
	}

	

}
?>