<?php
namespace service;

/**
 *
 */
class SitePath {

  const SITEPATH = '/PROJET-Back-End/deal-oo/';
  const PHOTOWEB = '/PROJET-Back-End/deal-oo/view/assets/photos/';

  public function sitePath() {
    return self::SITEPATH;
  }

  public function photoWeb() {
    return self::PHOTOWEB;
  }

}
