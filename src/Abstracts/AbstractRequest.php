<?php

namespace Cronycle\Abstracts;

use Cronycle\Interfaces\TokenInterface;

class AbstractRequest implements TokenInterface
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
}