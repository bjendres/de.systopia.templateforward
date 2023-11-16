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
      else if ($key == 'mailing_profiles') {
        $contact_id = CRM_Utils_Request::retrieve('cid', 'Integer');
        $subscribe_id = CRM_Utils_Request::retrieve('sid', 'Integer');
        $hash = CRM_Utils_Request::retrieve('h', 'String');

        if (!$contact_id ||
          !$subscribe_id ||
          !$hash) {
          Civi::log()->debug("[de.systopia.templateforward] invalid url Parameters. ContactId: {$contact_id}, subscriberId: {$subscribe_id}, Hash: {$hash}");
          return;
        }
        $se = &CRM_Mailing_Event_BAO_Subscribe::verify(
          $contact_id,
          $subscribe_id,
          $hash
        );
        if (!$se) {
          Civi::log()->debug("[de.systopia.templateforward] Verification of CRM_Mailing_Event_BAO_Subscribe failed. ContactId: {$contact_id}, subscriberId: {$subscribe_id}, Hash: {$hash}");
          return;
        }
        $group_id = $se->group_id;
        foreach ($value as $mailing_profile_key => $mailing_profile_value) {
          if ($mailing_profile_value['group_id'] == $group_id) {
            $forward_target = $mailing_profile_value['profile_forward'];
            if (!empty($forward_target)) {
              CRM_Utils_System::redirect($forward_target);
            }
            Civi::log()->debug("[de.systopia.templateforward] Invalid forward target '{$forward_target}' for groupId: {$group_id}");
            return;
          }
        }
        Civi::log()->debug("[de.systopia.templateforward] No valid group found for request. GroupID: {$group_id}");
      }
      else if (CRM_Utils_Request::retrieveValue($key, 'String') != $value) {
        return;
      }
    }
    if (!empty($forward_target)) {
      CRM_Utils_System::redirect($forward_target);
    }
  }
}
