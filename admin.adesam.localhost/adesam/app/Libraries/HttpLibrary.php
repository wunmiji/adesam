<?php


namespace App\Libraries;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;


class HttpLibrary
{


	public function list($url)
	{

	}

	public function example()
	{
		$client = new Client();

		$response = $client->get('http://worldtimeapi.org/api/ip');

		$body = $response->getBody()->getContents();

		$data = json_decode($body, true);

		d($data);
	}

	public function retrieve($url, $headers = null)
	{
		try {
			$client = new Client([
				'headers' => $headers
			]);

			$response = $client->get($url);
			return $response->getBody();
		} catch (ClientException $e) {
			\Sentry\captureException($e);
		}

	}

	public function delete($url, $id)
	{

	}

	public function create($url, $headers, $body)
	{
		try {
			$client = new Client([
				'headers' => $headers
			]);

			$response = $client->post($url, ['body' => $body]);

			if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201)
				return $response->getBody();
			else
				return null;
		} catch (ClientException $e) {
			\Sentry\captureException($e);
		}
	}

	public function update($url, $id, $json)
	{

	}


}









