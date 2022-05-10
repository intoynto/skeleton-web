<?php

/**
 * Helper replace hebat-app
 */

 /**
  * path_base
  */
if(!function_exists("floatval_toleransi"))
{
  /**
   * toleransi float val
   * @param $value you must b float
   * @param $digit toleransi digit
   */
  function floatval_toleransi($value, int $digit=10)
  {
       $value=floatval($value);
       return round($value,$digit);
  }
}
if(!function_exists('path_vendor')){ function path_vendor      ($path=''){ return realpath(__DIR__."/../").DIRECTORY_SEPARATOR.$path; }}
if(!function_exists('path_base')){ function path_base      ($path=''){ return realpath(__DIR__."/../").DIRECTORY_SEPARATOR.$path; }}
if(!function_exists('path_public')){ function path_public      ($path=''){ return realpath(__DIR__."/../public").DIRECTORY_SEPARATOR.$path; }}

if(!function_exists('path_app')){  function path_app       ($path=''):string { return path_base("app".DIRECTORY_SEPARATOR."{$path}"); }}
if(!function_exists('path_routes')){  function path_routes    ($path=''):string { return path_app("Routing".DIRECTORY_SEPARATOR."{$path}"); }}
if(!function_exists('path_view')){  function path_view    ($path=''):string { return path_app("Views".DIRECTORY_SEPARATOR."{$path}"); }}

if(!function_exists('url_public')){   function url_public   ($path=''):string { return url_base("{$path}"); }}