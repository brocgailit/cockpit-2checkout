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
		$result = '';
		$return = '';
		$signature = $_POST['HASH'];
		$body = '';
		ob_start();
		while(list($key, $val) = each($_POST)){
			$$key=$val;
			/* get values */
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
		return 'hello '.$body;
	}

	public function orders() {
		if($this->req_is('post')) {
			$data = json_decode(file_get_contents('php://input'), true);
			return $this->checkout->post('orders/', $data);
		};
	}

}

?>