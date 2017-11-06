<?php

require_once 'externalidkeeper.civix.php';
use CRM_Externalidkeeper_ExtensionUtil as E;

/**
 * Implements hook_civicrm_permission().
 *
 * @param array $permissions
 *
 * @link
 *   https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_permission/
 */
function externalidkeeper_civicrm_permission(&$permissions) {
  $prefix = ts('CiviCRM External ID Keeper') . ': ';
  $permissions['delete contacts with external ID values'] = array(
    $prefix . ts('delete contacts with external ID values'),
    ts('Grant this permission (in conjunction with "delete contacts") to administrators who need the ability to delete all contacts. Note: with the External ID Keeper extension installed, the "delete contacts" permission is changed to only allow users to delete contacts without external ID values.'),
  );
}

/**
 * Implements hook_civicrm_validateForm().
 *
 * @param string $formName
 * @param array $fields
 * @param array $files
 * @param $form
 * @param array $errors
 */
function externalidkeeper_civicrm_validateForm($formName, &$fields, &$files, &$form, &$errors) {
  // Check to see if we should process
  $userCanDeleteContactsWithExternalIds = CRM_Core_Permission::check('delete contacts with external ID values');
  $formIsContactDelete = in_array($formName, ['CRM_Contact_Form_Task_Delete']);
  $actionIsDelete = !$form->_restore;
  if ($userCanDeleteContactsWithExternalIds | !$formIsContactDelete | !$actionIsDelete) {
    return;
  }

  $contactsWithExternalIds = [];
  foreach ($form->_contactIds as $contactId) {
    $contactDetails = civicrm_api3('Contact', 'get', [
      'sequential' => 1,
      'return' => ['display_name', 'external_identifier'],
      'id' => $contactId,
    ])['values'][0];
    if (!empty($contactDetails['external_identifier'])) {
      $contactsWithExternalIds[] = $contactDetails;
    }
  }
  if ($contactsWithExternalIds) {
    $errorMessage = CRM_Core_Smarty::singleton()->fetchWith(
      'CRM/Externalidkeeper/ErrorMessages/DeleteContactsWithExternalIds.tpl',
      ['contacts' => $contactsWithExternalIds,]
    );
    $errors['external_identifier_present'] = 'External identifier present';
    CRM_Core_Session::setStatus($errorMessage, ts('Unable to delete contact(s)'), 'error');
  }
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function externalidkeeper_civicrm_config(&$config) {
  _externalidkeeper_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function externalidkeeper_civicrm_xmlMenu(&$files) {
  _externalidkeeper_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function externalidkeeper_civicrm_install() {
  _externalidkeeper_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function externalidkeeper_civicrm_postInstall() {
  _externalidkeeper_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function externalidkeeper_civicrm_uninstall() {
  _externalidkeeper_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function externalidkeeper_civicrm_enable() {
  _externalidkeeper_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function externalidkeeper_civicrm_disable() {
  _externalidkeeper_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function externalidkeeper_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _externalidkeeper_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function externalidkeeper_civicrm_managed(&$entities) {
  _externalidkeeper_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function externalidkeeper_civicrm_caseTypes(&$caseTypes) {
  _externalidkeeper_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function externalidkeeper_civicrm_angularModules(&$angularModules) {
  _externalidkeeper_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function externalidkeeper_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _externalidkeeper_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function externalidkeeper_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function externalidkeeper_civicrm_navigationMenu(&$menu) {
  _externalidkeeper_civix_insert_navigation_menu($menu, NULL, array(
    'label' => E::ts('The Page'),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _externalidkeeper_civix_navigationMenu($menu);
} // */
