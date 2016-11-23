# CRONYCLE PHP SDK (v1.0-alpha)
=============

Cronycle php sdk provides basic php library for communication with Cronycle API.


## 1. Installation

Cronycle PHP SDK library is aimed to be installed via composer by adding the following lines into you composer.json 
file.  

<pre>
{  
  "repositories": [  
    {  
      "type": "vcs",  
      "url": "https://github.com/cronycle/cronycle-php-sdk"  
    }  
  ],  
  "require": {  
    "cronycle/cronycle-php-sdk": "dev-master"  
  }  
}
</pre>    

When composer dependencies installed just require autoload file and you are ready to use SDK!
 
<pre>
require_once __DIR__.'/vendor/autoload.php'

$API = new \Cronycle\Api();
$accounts = $API->logIn( 'email', 'password' );
$token = $accounts[0]['auth_token']; // choose first from multiple accounts
$API->useAccount( $token );

...
</pre>  

Once you have authenticated user, you can keep token in the current session and initialize API at any time as follows:
 
<pre>
require_once __DIR__.'/vendor/autoload.php'

$API = new \Cronycle\Api( $token );
...
</pre>


## 2. Basic usage

Every API requests (except log in) requires Authorization header with a valid token to be passed. Otherwise handler will 
thrown an exception with error message and 403 status code.  


__Log in, log out:__ 
 
<pre>
$accounts = $API->logIn( 'email', 'password' );
$API->logOut();
</pre>

__Getting boards list:__

<pre>
$boards = $API->getBoardsList();
</pre>

__Getting single board details:__

<pre>
$board = $API->getBoardDetails( $boardId );
</pre>

__Getting board articles list:__  

<pre>
$articles = $API->getBoardArticles( $boardId );
</pre>


## 3. Demo account

You can use demonstration details below to get your first experience with SDK:  
 
__E-mail__: demosdk@cronycle.com  
__Password__: lifeafterboards2016  
