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
    
    public function index($order_number = '') {

		return $this->checkout->query($order_number, [
			'orderStatus' => $this->app->param('orderStatus'),
			'search' => $this->app->param('search'),
			'productCode' => $this->app->param('productCode'),
			'minTourStartTime' => $this->app->param('minTourStartTime'),
			'maxTourStartTime' => $this->app->param('maxTourStartTime'),
			'updatedSince' => $this->app->param('updatedSince'),
			'minDateCreated' => $this->app->param('minDateCreated'),
			'maxDateCreated' => $this->app->param('maxDateCreated'),
			'resellerReference' => $this->app->param('resellerReference'),
			'limit' => $this->app->param('limit') ?: 100,
			'offset' => $this->app->param('offset') ?: 0,
		]);
	}

	public function auth() {
		if($this->req_is('post')) {
			$data = json_decode(file_get_contents('php://input'), true);
			return $this->checkout->post('quote', $data);
		};
	}

}

?>