<?php

namespace Checkout\Controller;

use \LimeExtra\Controller;
use Checkout\Controller\Endpoint;

class CheckoutApi extends Controller {
	private $checkout;

	public function __construct($options) {
		parent::__construct($options);
        $this->checkout = new Endpoint($this->app['config']['checkout']);
    }
    
    public function index() {
		return 'Authorization Required';
	}

	public function authorize() {
		if($this->req_is('post')) {
			$data = json_decode(file_get_contents('php://input'), true);
			return $this->checkout->post('rs/authService', $data);
		};
	}

}

?>