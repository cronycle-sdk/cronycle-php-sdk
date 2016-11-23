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

	public function logIn( string $email, string $password )
	{
		return $this->request->login( $email, $password );
	}

	public function useAccount( string $token )
	{
		$this->request->setToken( $token );
	}

	public function logOut()
	{
		$this->request->logOut();
	}

	public function getBoardsList()
	{
		return $this->request->queryResource( '/v5/topic_boards/' );
	}

	public function getBoardDetails( int $id )
	{
		return $this->request->queryResource( sprintf( '/v5/topic_boards/%d', $id ) );
	}

	public function getBoardArticles( int $id )
	{
		return $this->request->queryResource( sprintf( '/v5/topic_boards/%d/tiles', $id ) );
	}
}