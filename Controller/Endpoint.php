<?php

namespace Checkout\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;

class Endpoint {
	public $private_key;
	private $client;

	public function __construct($base_uri, $private_key) {
		$this->private_key = $private_key;
		$this->client = new Client([
			'base_uri' => $base_uri
		]);
	}

	public function query($endpoint = '', $options = []) {
		$res = $this->client->request('GET', $endpoint, [
			'query' => Psr7\build_query($options)
		]);
		return json_decode($res->getBody(), true);
	}

	public function post($endpoint = '', $data) {
		$data['privateKey'] = $this->privateKey;
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