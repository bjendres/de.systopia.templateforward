<?php

/*-------------------------------------------------------+
| Systopia Template Forwarder                            |
| Copyright (C) 2019 SYSTOPIA                            |
| Author: P. Batroff (batroff@systopia.de)               |
| http://www.systopia.de/                                |
+--------------------------------------------------------+
| This program is released as free software under the    |
| Affero GPL license. You can redistribute it and/or     |
| modify it under the terms of this license which you    |
| can read by viewing the included agpl.txt or online    |
| at www.gnu.org/licenses/agpl.html. Removal of this     |
| copyright header is strictly prohibited without        |
| written permission from the original author(s).        |
+--------------------------------------------------------*/

/**
 * Class CRM_Templateforward_Config
 */
class CRM_Templateforward_Config {

  // optionaly, to speed things up $pages array can be set statically
  // Other config files won't be parsed then!
  private static $pages;

  /**
   * get forwarding pages form config files and cach them in self::$pages
   */
  private static function get_forward_pages() {
    $config_directory = array_diff(scandir(__DIR__ . "/../../resources/"), array('..', '.'));
    foreach ($config_directory as $c_file) {
      // exclude example.json
      if ($c_file == 'example.json') {
        continue;
      }
      try {
        $f_data = json_decode(file_get_contents(__DIR__ . "/../../resources/{$c_file}"), TRUE);
        foreach ($f_data as $name => $data) {
          self::$pages[$name] = $data;
        }
      } catch (Exception $e) {
        Civi::log()->debug("[de.systopia.forwardtemplate] Error parsing config file {$c_file}. Message: {$e->getMessage()}");
      }
    }
  }

  /**
   * @param $page_name
   *
   * @return array
   */
  public static function get_page_forward_data($page_name) {
    if (empty(self::$pages)) {
      self::get_forward_pages();
    }
    foreach (self::$pages as $page => $values) {
      if ($page == $page_name) {
        return $values;
      }
    }
    return [];
  }

  /**
   * @param $page_name
   *
   * @return bool
   */
  public static function has_forward($page_name) {
    if (empty(self::$pages)) {
      self::get_forward_pages();
    }
    if (array_key_exists($page_name, self::$pages)) {
      return TRUE;
    }
    return FALSE;
  }

}