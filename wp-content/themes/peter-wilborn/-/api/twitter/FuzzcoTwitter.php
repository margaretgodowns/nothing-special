<?php

require_once(dirname(dirname(__FILE__))."/fuzzco/FuzzcoCache.php");
require_once('tmhOAuth.php');
require_once('tmhUtilities.php');

class FuzzcoTwitter
{
    /*
        These values come from the 'Fuzzco Twitter Feed' app on the @gargantic account.
        They previously came from an app which has previously been called 'Self Assembler', 'Fast Fives', and others.
    */
	private $twitterUrl = 'https://twitter.com/';
	private $consumerKey = 'caXhSEVu5GEuyrTbRMjANyBh7';
	private $consumerSecret = 'OU6aJJaU17AjAVD4ZrYnQC1eaNvR8Z43GUu3AgLmnIwKanwvR7';
	private $userToken = "712608542-Qp0SfA1mY3xVI5yXgKeBpY9e4wyhwxRROO73luhs";
	private $userSecret = "HST8tWU6rWae6hEUMqtdvQ5WgjG0F44ufmq8zSURwsXIt";

	public function __construct($theUserToken, $theUserSecret)
	{   
        /*
            Once upon a time these were set to the parameter values. We think that code path is dead
            at this point but are nervous about removing them from a compatibility perspective. This
            is a good place to look if gets aren't working.
        */
		$this->userToken = $userToken; //$theUserToken;
		$this->userSecret = $userSecret; //$theUserSecret;
	}

	/*-------------------------------------------------
  
  	Fuzzco Custom Methods

	------------------------------------------------- */
	
	public function GetTweets($username = 'fuzzco', $count = 5, $cacheDuration = 2, $includeRetweets = 0, $excludeReplies = 1)
	{
		$args = array(
			'include_entities' => '1',
			'include_rts'      => $includeRetweets,
			'exclude_replies'  => $excludeReplies,
			'screen_name'      => '@' . $username,
			'count'            => $count
		);

		$fileName = "twitter-" . $username . ".json";

    if (FuzzcoCache::getInstance()->cacheIsGood($fileName, $cacheDuration)) {
			$tweets = FuzzcoCache::getInstance()->readFromCache($fileName);
    } else {
			$tweets = $this->MakeRequest('1.1/statuses/user_timeline', $args);
			FuzzcoCache::getInstance()->writeToCache($fileName, $tweets);
    }
		
		return count($tweets) > 0 ? $tweets : '';
	}

	/*-------------------------------------------------
  
    	Make Request

  	------------------------------------------------- */
	
	private function MakeRequest($endpoint, $args)
	{
		$response = '';
		
		$tmhOAuth = new tmhOAuth(array(
			'consumer_key'    => $this->consumerKey,
			'consumer_secret' => $this->consumerSecret,
			'user_token'      => $this->userToken,
			'user_secret'     => $this->userSecret,
		));
        
		$code = $tmhOAuth->request('GET', $tmhOAuth->url($endpoint), $args);
        
		if ($code == 200)
		{
			$response = json_decode($tmhOAuth->response['response'], true);
	  	}
	  	else
	  	{
	  		print_r("<!-- TWITTER ERROR: ". $tmhOAuth->response['response'] ." -->");
	  	}
	  	
	  	return $response;
	}

	/*-------------------------------------------------
  
    	Misc. Formatting

  	------------------------------------------------- */
	
	public function TweetUrl($username, $tweetId)
	{
		return $this->twitterUrl . str_replace('@', '', $username) . '/status/' . $tweetId;
	}
	
	public function FormatTweetText($text)
	{
	    // Convert URLs into links
	    $text = preg_replace("#(https?://([-a-z0-9]+\.)+[a-z]{2,5}([/?][-a-z0-9!\#()/?&+]*)?)#i", "<a href='$1' target='_blank'>$1</a>", $text);
	    // Convert protocol-less URLs into links
	    $text = preg_replace("#(?!https?://|<a[^>]+>)(^|\s)(([-a-z0-9]+\.)+[a-z]{2,5}([/?][-a-z0-9!\#()/?&+.]*)?)\b#i", "$1<a href='http://$2'>$2</a>", $text);
	    // Convert @mentions into follow links
	    $text = preg_replace("#(?!https?://|<a[^>]+>)(^|\s)(@([_a-z0-9\-]+))#i", "$1<a href=\"http://twitter.com/$3\" title=\"Follow $3\" target=\"_blank\">@$3</a>", $text);
	    // Convert #hashtags into tag search links
	    $text = preg_replace("#(?!https?://|<a[^>]+>)(^|\s)(\#([_a-z0-9\-]+))#i", "$1<a href='http://twitter.com/search?q=%23$3' title='Search tag: $3' target='_blank'>#$3</a>", $text);
	    
	    return $text;
	}
	
	public function TimeDifference($date)
	{
	    if(empty($date))
	    {
	    	return "No date provided";
	    }
	    
	    $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	    $lengths = array("60","60","24","7","4.35","12","10");
	    
	    $now = time();
	    $unix_date = strtotime($date);
	    
	       // check validity of date
	    if(empty($unix_date))
	    {   
	        return "Bad date";
	    }
	 
	    // is it future date or past date
	    if($now > $unix_date) {   
	        $difference     = $now - $unix_date;
	        $tense         = "ago";
	        
	    } else {
	        $difference     = $unix_date - $now;
	        $tense         = "from now";
	    }
	    
	    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
	        $difference /= $lengths[$j];
	    }
	    
	    $difference = round($difference);
	    
	    if($difference != 1) {
	        $periods[$j].= "s";
	    }
	    
	    return "$difference $periods[$j] {$tense}";
	}
}
	
?>