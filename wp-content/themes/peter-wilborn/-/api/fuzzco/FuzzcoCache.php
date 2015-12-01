<?php

/*-------------------------------------------------
  
  CACHING

------------------------------------------------- */

class FuzzcoCache {

  private static $instance;
  private $cacheFilePath;

  private function __construct() {
    $this->cacheFilePath = dirname(dirname(__FILE__)) . "/cache/";
    if (!file_exists($this->cacheFilePath)) mkdir($this->cacheFilePath, 0777, true);
  }

  public static function getInstance() {
    if ( is_null( self::$instance ) )
    {
      self::$instance = new self();
    }
    return self::$instance;
  }

  /**
   * Returns whether the cache is good to use or not
   *
   * @param string $fileName     The name of the file you'd like to check
   * @param object $cacheAge     Age of cache file in hours
   * @return boolean
   */

  public function cacheIsGood($fileName, $cacheAge) {
    $file = $this->cacheFilePath.$fileName;
    return file_exists($file) && (time()-filemtime($file) < $cacheAge * 3600);
  }

  /**
   * Parse data to JSON and write to cache file
   *
   * @param string $fileName     The name of the file you'd like to write
   * @param object $data         The data you'd like to write
   * @return boolean
   */

  public function writeToCache($fileName, $data) {
    
    $file = $this->cacheFilePath.$fileName;
    
    $fp = fopen($file, 'w');
    $didWrite = fwrite($fp, json_encode($data));
    fclose($fp);

    return $didWrite;
  }

  /**
   * Read data from cache and parse the JSON into objects
   *
   * @param string $fileName     Name of the file you'd like to read
   * @return objects
   */

  public function readFromCache($fileName) {
    $file = $this->cacheFilePath.$fileName;
    return json_decode(file_get_contents($file));
  }
  
}