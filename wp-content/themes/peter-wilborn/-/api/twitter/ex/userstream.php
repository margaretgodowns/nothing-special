<?php

/**
 * Very basic User Streams example. In production you would store the
 * received tweets in a queue or database for later processing.
 *
 * Although this example uses your user token/secret, you can use
 * the user token/secret of any user who has authorised your application.
 *
 * Instructions:
 * 1) If you don't have one already, create a Twitter application on
 *      https://dev.twitter.com/apps
 * 2) From the application details page copy the consumer key and consumer
 *      secret into the place in this code marked with (YOUR_CONSUMER_KEY
 *      and YOUR_CONSUMER_SECRET)
 * 3) From the application details page copy the access token and access token
 *      secret into the place in this code marked with (A_USER_TOKEN
 *      and A_USER_SECRET)
 * 4) In a terminal or server type:
 *      php /path/to/here/userstream.php
 * 5) To stop the Streaming API either press CTRL-C or, in the folder the
 *      script is running from type:
 *      touch STOP
 *
 * @author themattharris
 */

function my_streaming_callback($data, $length, $metrics) {
  echo $data .PHP_EOL;
  return file_exists(dirname(__FILE__) . '/STOP');
}

require '../tmhOAuth.php';
require '../tmhUtilities.php';

$tmhOAuth = new tmhOAuth(array(
  'consumer_key'    => 'd0e6OZX6NwrWpnBH1zeMg',
  'consumer_secret' => 'tofViEY9HkB2jVFFJenVM9GsxjLVFjDGb3vPM1PQ',
  'user_token'      => '493406798-gUfpCacjuRr46mjGYL8MtltEpxuJDAeL6VV9Fck1',
  'user_secret'     => 'JdpKCArJbcBp7Dxsqvy5rVxubir7g0XaYlq7nLV0',
));

$code = $tmhOAuth->request('GET', $tmhOAuth->url('1.1/statuses/user_timeline'), array(
	  'include_entities' => '1',
	  'include_rts'      => '0',
	  'screen_name'      => '@BOLDCommGroup',
	  'count'            => 20,
	));
	
	$tweets = array();
	
	if ($code == 200)
	{
		$tweets = json_decode($tmhOAuth->response['response'], true);
  	}
  	
  	print_r($code);
	
	print_r($tweets);

/*
$method = "https://userstream.twitter.com/2/user.json";
$params = array(
  // parameters go here
);
$tmhOAuth->streaming_request('POST', $method, $params, 'my_streaming_callback', false);

// output any response we get back AFTER the Stream has stopped -- or errors
tmhUtilities::pr($tmhOAuth);
*/