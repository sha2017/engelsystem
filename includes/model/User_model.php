<?php

/**
 * Returns user by id.
 * @param $id UID
 */
function User($id) {
  $user_source = sql_select("SELECT * FROM `User` WHERE `UID`=" . sql_escape($id) . " LIMIT 1");
  if(count($user_source) > 0)
    return $user_source[0];
  return null;
}

/**
 * Returns User by api_key.
 * @param string $api_key User api key
 * @return Matching user, null or false on error
 */
function User_by_api_key($api_key) {
  $user = sql_select("SELECT * FROM `User` WHERE `api_key`='" . sql_escape($api_key) . "' LIMIT 1");
  if($user === false)
    return false;
  if (count($user) == 0)
    return null;
  return $user[0];
}

/**
 * Generates a new api key for given user.
 * @param User $user
 */
function User_reset_api_key($user) {
  $user['api_key'] = md5($user['Nick'] . time() . rand());
  sql_query("UPDATE `User` SET `api_key`='" . sql_escape($user['api_key']) . "' WHERE `UID`='" . sql_escape($user['UID']) . "' LIMIT 1");
  engelsystem_log("API key resetted.");
}

?>