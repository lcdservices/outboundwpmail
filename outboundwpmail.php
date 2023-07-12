<?php

require_once 'outboundwpmail.civix.php';
// phpcs:disable
use CRM_Outboundwpmail_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function outboundwpmail_civicrm_config(&$config) {
  _outboundwpmail_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function outboundwpmail_civicrm_xmlMenu(&$files) {
  _outboundwpmail_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function outboundwpmail_civicrm_install() {
  _outboundwpmail_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function outboundwpmail_civicrm_postInstall() {
  _outboundwpmail_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function outboundwpmail_civicrm_uninstall() {
  _outboundwpmail_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function outboundwpmail_civicrm_enable() {
  _outboundwpmail_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function outboundwpmail_civicrm_disable() {
  _outboundwpmail_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function outboundwpmail_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _outboundwpmail_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function outboundwpmail_civicrm_managed(&$entities) {
  _outboundwpmail_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Add CiviCase types provided by this extension.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function outboundwpmail_civicrm_caseTypes(&$caseTypes) {
  _outboundwpmail_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Add Angular modules provided by this extension.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function outboundwpmail_civicrm_angularModules(&$angularModules) {
  // Auto-add module files from ./ang/*.ang.php
  _outboundwpmail_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function outboundwpmail_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _outboundwpmail_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function outboundwpmail_civicrm_entityTypes(&$entityTypes) {
  _outboundwpmail_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function outboundwpmail_civicrm_themes(&$themes) {
  _outboundwpmail_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function outboundwpmail_civicrm_preProcess($formName, &$form) {
//
//}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
//function outboundwpmail_civicrm_navigationMenu(&$menu) {
//  _outboundwpmail_civix_insert_navigation_menu($menu, 'Mailings', [
//    'label' => E::ts('New subliminal message'),
//    'name' => 'mailing_subliminal_message',
//    'url' => 'civicrm/mailing/subliminal',
//    'permission' => 'access CiviMail',
//    'operator' => 'OR',
//    'separator' => 0,
//  ]);
//  _outboundwpmail_civix_navigationMenu($menu);
//}

/**
 * Implementation of hook_civicrm_alterMailer
 *
 * Replace the normal mailer with our custom mailer
 */
function outboundwpmail_civicrm_alterMailer(&$mailer, $driver, $params) {
  if (function_exists('wp_mail')) {
    $mailer = new CRM_Outboundwpmail_Mailer();
  }
}

function outboundwpmail_civicrm_alterMailParams(&$params, $context) {
  /*Civi::log()->debug(__FUNCTION__, [
    'params' => $params,
    'context' => $context,
  ]);*/

  //remove text; with wp_mail we don't have an easy way to append
  unset($params['messageTemplate']['msg_text']);
  unset($params['text']);
}