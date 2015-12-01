<?php

require_once(dirname(dirname(__FILE__))."/fuzzco/FuzzcoCache.php");
require_once(dirname(__FILE__)."/vendor/instagram.class.php");

class FuzzcoInstagram extends Instagram {


  /*-------------------------------------------------
  
    Fuzzco Custom Methods
  
  ------------------------------------------------- */

  /**
   * Get Instagram media from a tag that client has commented on.
   *
   * @param integer [optional] $userId      ID of the Instagram user to return (Default: "self")
   * @param integer [optional] $limit       Limit of returned results (Default: 4)
   * @param string [optional] $size         Size of image returned ["thumb","small","full"] (Default: "small")
   * @param integer [optional] $cacheAge    Age of cache file in hours (Default: 2)
   * @return mixed
   */
  public function UserMedia($userId = "self", $limit = 4, $size = 'small', $shouldPrintPhotos = false, $cacheAge = 2) {
    
    // Set location & name of cache file.
    $fileName = "instagram-" . $userId . ".json";

    // Check to see if the cache file exists and it is younger than specified cache age.
    if (FuzzcoCache::getInstance()->cacheIsGood($fileName, $cacheAge)) {
      // If the cache file is good, then read from it instead.
      $user_photos = FuzzcoCache::getInstance()->readFromCache($fileName);
    } else {
      // If it's not good to use, then fetch the photos.
      $user_photos = $this->getUserMedia("self", $limit); $user_photos = $user_photos->data;

      // Write approved photos to cache file in JSON.
      FuzzcoCache::getInstance()->writeToCache($fileName, $user_photos);
    }

    if ($shouldPrintPhotos) {
      $this->printPhotos($user_photos, $size);
    } else {
      return $user_photos;
    }
  }

}