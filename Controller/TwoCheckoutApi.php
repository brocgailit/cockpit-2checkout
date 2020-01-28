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
		return $this->checkout->config['secretKey'];
	}

	public function orders() {
		if($this->req_is('post')) {
			$data = json_decode(file_get_contents('php://input'), true);
			return $this->checkout->post('orders/', $data);
		};
	}

}

?>