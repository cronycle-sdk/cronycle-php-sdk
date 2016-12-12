<?php

namespace Tests;

use Cronycle\Api;

class ApiTest extends \PHPUnit_Framework_TestCase
{
	const DEMO_ACCOUNT = [
		'email'     => 'demosdk@cronycle.com',
		'password'  => 'lifeafterboards2016',
	];

	private $api;

	public function __construct()
	{
		$this->api = new Api();
	}

	public function test()
	{
		// Log in
		$accounts = $this->api->logIn( self::DEMO_ACCOUNT['email'], self::DEMO_ACCOUNT['password'] );
		$token = isset( $accounts[0]['auth_token'] ) ? $accounts[0]['auth_token'] : null;
		$this->assertNotEquals( null, $token );

		if ( !$token ) return;
		$this->api->useAccount( $token );

		// Get boards
		$boards = $this->api->getBoardsList();
		$boardId = isset( $boards[0]['id'] ) ? $boards[0]['id'] : null;
		$this->assertNotEquals( null, $boardId );

		if ( !$boardId ) return;

		// Get board details
		$board = $this->api->getBoardDetails( $boardId );
		$this->assertNotEquals( null, isset( $board['topic_board']['id'] ) ? $board['topic_board']['id'] : null );

		// Get board articles
		$articles = $this->api->getBoardArticles( $boardId );
		$this->assertArrayHasKey( 0, $articles );
	}
}