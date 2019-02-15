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
 * Class CRM_Templateforward_ForwardHandler
 */
class CRM_Templateforward_ForwardHandler {

  /**
   * @param $page
   * @param $page_name
   */
  public static function forward(&$page, $page_name) {
    $config_values = CRM_Templateforward_Config::get_page_forward_data($page_name);
    if (empty($config_values)) {
      return;
    }
    $forward_target = "";
    foreach ($config_values as $key => $value) {
      if ($key == 'forward_target') {
        $forward_target = $value;
        continue;
      }
      if (CRM_Utils_Request::retrieveValue($key, 'String') != $value) {
        return;
      }
    }
    if (!empty($forward_target)) {
      CRM_Utils_System::redirect($forward_target);
    }
  }
}