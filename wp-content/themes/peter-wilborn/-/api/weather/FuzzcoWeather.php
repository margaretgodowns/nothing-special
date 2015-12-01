<?php

require_once(dirname(dirname(__FILE__))."/cache/FuzzcoCache.php");

// Pulls weather from the YUI api

class FuzzcoWeather
{
	
	public function GetWeather($city, $state, $cacheDuration = 0.25)
	{
		
		$query = 'https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20woeid%20in%20(select%20woeid%20from%20geo.places(1)%20where%20text%3D%22';
		$query .= urlencode($city . ' ' . $state);
		$query .= '%22)&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys';

		$fileName = "weather-" . strtolower($city) . ".json";

  	if (FuzzcoCache::getInstance()->cacheIsGood($fileName, $cacheDuration)) {
			$weather = FuzzcoCache::getInstance()->readFromCache($fileName);
  	} else {
	  	$json = file_get_contents($query);
			$weather = json_decode($json);
			FuzzcoCache::getInstance()->writeToCache($fileName, $weather);
  	}
		
		return count($weather) > 0 ? $weather : '';

	}

}
	
?>