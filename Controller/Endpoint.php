<?php

namespace Checkout\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

class Endpoint {
	public $config;
	private $client;

	public function __construct($config) {
		$this->config = $config;
		$subdomain = $config['mode'] === 'production' ? 'www' : 'sandbox';
		$this->client = new Client([
			'base_uri' => "https://{$subdomain}.2checkout.com/checkout/api/1/{$config['sellerId']}/"
		]);
	}

	public function query($endpoint = '', $options = []) {
		$res = $this->client->request('GET', $endpoint, [
			'query' => Psr7\build_query($options)
		]);
		return json_decode($res->getBody(), true);
	}

	public function post($endpoint = '', $data) {
		$data['privateKey'] = $this->config['privateKey'];
		$data['sellerId'] = $this->config['sellerId'];
		$res = $this->client->request('POST', $endpoint, [
			'json' => $data
		]);
		return json_decode($res->getBody(), true);
	}

	public function renderResponse($res, $return_fn) {

		$status = $res->requestStatus;

		if ( !$status->success ) {
			return $status;		
		}

		return $return_fn($res);
	}

}

?>