<?php

namespace Cronycle;

use Cronycle\Abstracts\AbstractRequest;
use Cronycle\Auth\SocialSignIn;

final class Request extends AbstractRequest
{
	const API_URL = 'https://api.cronycle.com';

	public function __construct( $token = null )
	{
		$this->setToken( $token );
	}

	/**
	 * Method allows user to log in with certain email and password parameters
	 *
	 * @param $email
	 * @param $password
	 *
	 * @return array API call response
	 */
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

	/**
	 * Method allows user to log in via certain 3rd party application
	 *
	 * Supported social sign ins are: google, twitter
	 *
	 * @param $provider
	 * @param $callback
	 * @return array API call response
	 * @throws \Exception
	 */
	public function logInSocial( $provider, $callback )
	{
		if ( !SocialSignIn::validateProvider( $provider ) )
			throw new \Exception( 'Not supported social sign in provider...', 400 );

		$ch = curl_init( $this->getRequestUrl( sprintf( '/auth/%s?%s=%s', $provider, $provider == 'twitter2' ? 'd' : 'state', $callback ) ) );
		curl_setopt_array( $ch, [
			CURLOPT_FOLLOWLOCATION => true,
		] );
		$response = curl_exec( $ch );
		curl_close( $ch );

		return json_decode( $response, true );
	}

	/**
	 * Method provides post auth validation for social sign in
	 *
	 * @param $provider
	 * @param $ticket
	 */
	public function postAuth( $provider, $ticket )
	{
		if ( !SocialSignIn::validateProvider( $provider ) )
			throw new \Exception( 'Not supported social sign in provider...', 400 );

		$ch = curl_init( $this->getRequestUrl( sprintf( '/v5/auth/%s/post-auth?ticket=%s', $provider, $ticket ) ) );
		curl_setopt_array( $ch, [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
		] );
		$response = curl_exec( $ch );
		curl_close( $ch );

		return json_decode( $response, true );
	}

	/**
	 * Method allows to log user our from the system
	 */
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
		$httpCode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
		curl_close( $ch );

		return $httpCode == 200 ? true : false;
	}

	/**
	 * Method allows to authenticate user in the system
	 *
	 * @throws \Exception
	 */
	public function authenticate()
	{
		if ( !$this->getToken() )
			throw new \Exception( 'Authentication failed...', 403 );
	}

	/**
	 * Method allows to query API resource
	 *
	 * @param $method
	 * @param array $params
	 * @return array API call response
	 */
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

	/**
	 * Method allows to request API resource
	 *
	 * @param $method
	 * @param $params
	 * @return array API call response
	 */
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