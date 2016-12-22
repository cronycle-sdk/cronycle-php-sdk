<?php

namespace Cronycle;

use Cronycle\Abstracts\AbstractRequest;

final class Request extends AbstractRequest
{
	const API_URL = 'https://api.cronycle.com';

	public function __construct( $token = null )
	{
		$this->setToken( $token );
	}

	public function logIn( $email, $password )
	{
		$params = [
			'user' => [
				'email'     => $email,
				'password'  => $password,
			],
		];

		$ch = curl_init( $this->getRequestUrl( '/v3/sign_in.json' ) );
		curl_setopt_array( $ch, [
			CURLOPT_POST	        => count( $params ),
			CURLOPT_POSTFIELDS	    => json_encode( $params ),
			CURLOPT_RETURNTRANSFER  => true,
			CURLOPT_HTTPHEADER 		=> [
				'Content-Type: application/json',
			],
		] );
		$result = curl_exec( $ch );
		curl_close( $ch );

		return json_decode( $result, true );
	}

	public function logOut()
	{
		$ch = curl_init( $this->getRequestUrl( '/v3/sign_out.json' ) );
		curl_setopt_array( $ch, [
			CURLOPT_CUSTOMREQUEST   => 'DELETE',
			CURLOPT_HTTPHEADER 		=> [
				'Content-Type: application/json',
				$this->getAuthorizationHeader(),
			],
		] );
		curl_exec( $ch );
		curl_close( $ch );
	}

	public function authenticate()
	{
		if ( !$this->getToken() )
			throw new \Exception( 'Authentication failed...', 403 );
	}

	public function queryResource( $method, $params = [] )
	{
		$this->authenticate();

		$ch = curl_init( $this->getRequestUrl( $method, $params ) );
		curl_setopt_array( $ch, [
			CURLOPT_RETURNTRANSFER  => true,
			CURLOPT_HTTPHEADER 		=> [
				'Cache-Control: no-cache',
				'Content-Type: application/json',
				$this->getAuthorizationHeader(),
			],
		] );
		$result = curl_exec( $ch );
		curl_close( $ch );

		return json_decode( $result, true );
	}

	public function requestResource( $method, $params )
	{
		$this->authenticate();

		$ch = curl_init( $this->getRequestUrl( $method ) );
		curl_setopt_array( $ch, [
			CURLOPT_POST	        => count( $params ),
			CURLOPT_POSTFIELDS	    => json_encode( $params ),
			CURLOPT_RETURNTRANSFER  => true,
			CURLOPT_HTTPHEADER 		=> [
				'Content-Type: application/json',
				$this->getAuthorizationHeader(),
			],
		] );
		$result = curl_exec( $ch );
		curl_close( $ch );

		return json_decode( $result, true );
	}
}