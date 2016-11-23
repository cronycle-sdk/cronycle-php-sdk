<?php

namespace Cronycle;

use Cronycle\Services\Request;

final class CronycleAPI
{
	private $request;

	public function __construct()
	{
		$this->request = new Request();
	}

	public function logIn( string $email, string $password )
	{
		return $this->request->authenticate( $email, $password );
	}

	public function logOut()
	{
		return $this->request->logOut();
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