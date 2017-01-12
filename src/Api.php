<?php

namespace Cronycle;

use Cronycle\Request;

final class Api
{
	private $request;

	public function __construct( $token = null )
	{
		$this->request = new Request( $token );
	}

	/**
	 * Method allows to sign in with email/password
	 *
	 * @param $email
	 * @param $password
	 * @return array API call response
	 */
	public function logIn( $email, $password )
	{
		return $this->request->login( $email, $password );
	}

	/**
	 * Method allows to sign in with google
	 *
	 * @param $callback
	 * @return array API call response
	 * @throws \Exception
	 */
	public function logInWithGoogle( $callback )
	{
		return $this->request->logInSocial( 'google_oauth2', $callback );
	}

	/**
	 * Method allows to sign in with twitter
	 *
	 * @param $callback
	 * @return array API call response
	 * @throws \Exception
	 */
	public function logInWithTwitter( $callback )
	{
		return $this->request->logInSocial( 'twitter2', $callback );
	}

	/**
	 * Method allows to set auth token for further api requests
	 *
	 * @param $token
	 */
	public function useAccount( $token )
	{
		$this->request->setToken( $token );
	}

	/**
	 * Method allows to log user out from the system, true/false returned
	 *
	 * @return bool
	 */
	public function logOut()
	{
		return $this->request->logOut();
	}

	/**
	 * Method allows to get boards list
	 *
	 * @return array API call response
	 */
	public function getBoardsList()
	{
		return $this->request->queryResource( '/v5/topic_boards/' );
	}

	/**
	 * Method allows to get board details
	 *
	 * @param $id
	 * @return array API call response
	 */
	public function getBoardDetails( $id )
	{
		return $this->request->queryResource( sprintf( '/v5/topic_boards/%d', $id ) );
	}

	/**
	 * Method allows to get board articles
	 *
	 * @param $id
	 * @param array $params
	 * @return array API call response
	 */
	public function getBoardArticles( $id, $params = [] )
	{
		return $this->request->queryResource( sprintf( '/v5/topic_boards/%d/tiles', $id ), $params );
	}
}
