# CRONYCLE PHP SDK (v1.0-alpha)


Cronycle php sdk provides basic functionality for communication with Cronycle API.


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

Every API request (except log in) requires Authorization header with a valid token to be passed. Otherwise handler will 
throw an exception with an error message and 403 status code.  


###Log in: 
 
__Parameters:__  
email - string, requried, user account email
password - string, requried, user account password
  
__Response:__  
$accountsDetails - array  
 
<pre>
$accounts = $API->logIn( 'email', 'password' );
</pre>

###Log out: 
 
__Parameters:__  
no parameters
  
__Response:__  
no response  
 
<pre>
$API->logOut();
</pre>

###Getting boards list:

__Parameters:__  
no parameters
  
__Response:__  
boardList - array  

<pre>
$boards = $API->getBoardsList();
</pre>

###Getting single board details:  

__Parameters:__  
boarId - integer, required, board id  
  
__Response:__  
boardDetails - array    

<pre>
$board = $API->getBoardDetails( $boardId );
</pre>

###Getting board articles list:  

__Parameters:__  
boarId - integer, required, board id  
params - array, optional, list of extra parameters for a call
<ul>
	<li>per_page - Number of links to return per page, if a value of 0 is provided then all links for the topic_board are returned Example: 25. Default: 25.</li>
	<li>page - Page number to return, and only takes effect if the per_page value is greater than 0 Example: 1. Default: 1.</li>
	<li>max_timestamp - Timestamp to limit the latest link (<= max_timestamp) (based on the addition to the topic board)</li>
	<li>min_timestamp - Timestamp to limit the earliest link (=> min_timestamp) (based on the addition to the topic board)</li>
	<li>before_timestamp - TTimestamp to limit the list of the links similar to max_timestamp, except that links which match the timestamp are not returned (< before_timestamp) (based on the addition to the topic board)</li>
	<li>include_links - Indicates whether the links should be loaded and included or not Default: false.</li>
	<li>clean_links - Will parse out img, strong, br tags as well as blank p, figure, a tags. Note caching is disabled if this parameter is used.</li>
	<li>clean_description - Will clean all html tags from article description. Note caching is disabled if this parameter is used.</li>
	<li>search_text - Searches text on article tiles, note tiles, and titles of file tiles</li>
	<li>contributor_ids - Filter by users who created a tile, must be a comma separated list of user ids (eg. 1,2,3)</li>
	<li>tags - Filter by tags attached to the tile, must be a comma separated list of tags (eg. red,blue,green)</li>
	<li>sort_by - Sorting and additional filtering. Must be one of (published_date, notes_only, articles_only, comment_count, engagement)</li>
	<li>last_visited - If this is provided AND it's more recent than the existing last_visited date for this user, then the users last_visited date is updated. If this is provided AND it's less recent than the existing last_visited date for this user, then the users last_visited date is not updated. If the value is not provided then the last_visited is set to the current time. In this way the last_visited time can only be advanced. Currently the last_visited value does not affect any tile attributes, but does change the new_items counts on the topic_board index endpoint</li>
</ul>
  
__Response:__  
boardArticlesList - array  
  
<pre>
$articles = $API->getBoardArticles( $boardId, $params );
</pre>


## 3. Demonstration account

You can use demonstration account details below to start working with the SDK:  
 
__E-mail__: demosdk@cronycle.com  
__Password__: lifeafterboards2016  


## 4. Skeleton application

https://github.com/cronycle/cronycle-php-sdk-demo