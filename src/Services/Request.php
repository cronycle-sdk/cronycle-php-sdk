<?php

namespace Cronycle\Services;

final class Request
{
	const API_URL = 'https://api.cronycle.com';

	public function authenticate( $email, $password )
	{
		$params = [
			'user' => [
				'email'     => $email,
				'password'  => $password,
			],
		];

		$ch = curl_init( self::API_URL.'/v3/sign_in.json' );
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

		return $result;
	}

	public function logOut( $authToken )
	{
		$ch = curl_init( self::API_URL.'/v3/sign_out.json' );
		curl_setopt_array( $ch, [
			CURLOPT_CUSTOMREQUEST   => 'DELETE',
			CURLOPT_RETURNTRANSFER  => true,
			CURLOPT_HTTPHEADER 		=> [
				'Content-Type: application/json',
				'Authorization: Token auth_token='.$authToken,
			],
		] );
		$result = curl_exec( $ch );
		$info = curl_getinfo( $ch );
		curl_close( $ch );

		return [
			'code'  => $info['http_code'],
			'body'  => $result,
		];
	}

	public function queryResource( $method )
	{
		$ch = curl_init( self::API_URL.$method );
		curl_setopt_array( $ch, [
			CURLOPT_RETURNTRANSFER  => true,
			CURLOPT_HTTPHEADER 		=> [
				'Cache-Control: no-cache',
				'Content-Type: application/json',
				'Authorization: '.$this->request->getHeader( 'Authorization' )[0],
			],
		] );
		$result = curl_exec( $ch );
		curl_close( $ch );

		return $result;
	}

	public function requestResource( $method, $params )
	{
		$data = json_encode( $params );

		$ch = curl_init( self::API_URL.$method );
		curl_setopt_array( $ch, [
			CURLOPT_POST	        => count( $data ),
			CURLOPT_POSTFIELDS	    => $data,
			CURLOPT_RETURNTRANSFER  => true,
			CURLOPT_HTTPHEADER 		=> [
				'Content-Type: application/json',
				'Authorization: '.$this->request->getHeader( 'Authorization' )[0],
			],
		] );
		$result = curl_exec( $ch );
		curl_close( $ch );

		return $result;
	}
}