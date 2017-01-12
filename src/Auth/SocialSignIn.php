<?php

namespace Cronycle\Auth;

final class SocialSignIn
{
	const ALLOWED_PROVIDERS = [ 'google_oauth2', 'twitter2' ];

	public static function validateProvider( $provider )
	{
		return in_array( $provider, self::ALLOWED_PROVIDERS );
	}
}