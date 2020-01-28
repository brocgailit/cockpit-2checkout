<?php

namespace TwoCheckout\Controller;

use \LimeExtra\Controller;
use TwoCheckout\Controller\Endpoint;

class TwoCheckoutApi extends Controller {
	private $checkout;

	public function __construct($options) {
		parent::__construct($options);
        $this->checkout = new Endpoint($this->app['config']['2checkout']);
    }
    
    public function index() {
		return 'Authorization Required';
	}

	public function ipn() {
		$pass = $this->checkout->config['secretKey'];
		$signature = $_POST['HASH'];
		$result = '';
		$return = '';
		$body = '';
		ob_start();
		while(list($key, $val) = each($_POST)){
			$$key=$val;
			if($key != "HASH"){
					if(is_array($val)) {
						$result .= ArrayExpand($val);
					}	else{
							$size = strlen(StripSlashes($val));
							$result .= $size.StripSlashes($val);
					}
				}
		}
		$body = ob_get_contents();
		ob_end_flush();
		$date_return = date('YmdGis');
		$return = strlen($_POST["IPN_PID"][0]).$_POST["IPN_PID"][0].strlen($_POST["IPN_PNAME"][0]).$_POST["IPN_PNAME"][0];
		$return .= strlen($_POST["IPN_DATE"]).$_POST["IPN_DATE"].strlen($date_return).$date_return;

		function ArrayExpand($array){
			$retval = "";
			for($i = 0; $i < sizeof($array); $i++){
					$size        = strlen(StripSlashes($array[$i]));
					$retval    .= $size.StripSlashes($array[$i]);
			}
			return $retval;
		}

		function hmac ($key, $data){
			$b = 64; // byte length for md5
			if (strlen($key) > $b) {
					$key = pack("H*",md5($key));
			}
			$key  = str_pad($key, $b, chr(0x00));
			$ipad = str_pad('', $b, chr(0x36));
			$opad = str_pad('', $b, chr(0x5c));
			$k_ipad = $key ^ $ipad ;
			$k_opad = $key ^ $opad;
			return md5($k_opad  . pack("H*",md5($k_ipad . $data)));
		 }

		 $hash =  hmac($pass, $result); /* HASH for data received */
		 $body .= $result."\r\n\r\nHash: ".$hash."\r\n\r\nSignature: ".$signature."\r\n\r\nReturnSTR: ".$return;

		 if($hash == $signature){
			/* ePayment response */
			$result_hash =  hmac($pass, $return);
			return "Verified OK! <EPAYMENT>".$date_return."|".$result_hash."</EPAYMENT>";
			/* Begin automated procedures (START YOUR CODE)*/
	
		}else{
				/* warning email */
				mail("broc@heavycraft.io","BAD IPN Signature", $body,"");
				return 'Error';
		}

	}

	public function orders() {
		if($this->req_is('post')) {
			$data = json_decode(file_get_contents('php://input'), true);
			return $this->checkout->post('orders/', $data);
		};
	}

}

?>