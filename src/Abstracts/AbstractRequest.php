<?php

namespace Cronycle\Abstracts;

use Cronycle\Interfaces\CommonRequestInterface;
use Cronycle\Interfaces\TokenInterface;

class AbstractRequest implements CommonRequestInterface, TokenInterface
{
	protected $token;

	public function getToken()
	{
		return $this->token;
	}

	public function setToken( $token )
	{
		$this->token = $token;
	}

	public function getRequestUrl( $method, $params = [] )
	{
		$queryString = !empty( $params ) ? '?'.http_build_query( $params ) : '';
		return sprintf( '%s%s%s', static::API_URL, $method, $queryString );
	}

	public function getAuthorizationHeader()
	{
		return 'Authorization: Token auth_token='.$this->getToken();
	}
}