<?php

namespace Cronycle\Interfaces;

interface TokenInterface
{
	public function getToken();
	public function setToken( $token );
	public function getAuthorizationHeader();
}