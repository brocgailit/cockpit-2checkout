<?php

namespace Checkout\Controller;

use \LimeExtra\Controller;
use Checkout\Controller\Endpoint;

class CheckoutApi extends Controller {
	private $checkout;
	private $config;

	public function __construct($options) {
		parent::__construct($options);

		$config = $this->app['config']['checkout'];
		$this->config = $config;

        $this->checkout = new Endpoint($config);
    }
    
    public function index() {
		return 'Authorization Required';
	}

	public function auth() {
		if($this->req_is('post')) {
			$data = json_decode(file_get_contents('php://input'), true);
			return $this->checkout->post('rs/authService', $data);
		};
	}

}

?>