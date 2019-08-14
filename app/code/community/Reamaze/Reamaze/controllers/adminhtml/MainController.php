<?php
/**
 * Main admin controller
 *
 * @author Reamaze
 */

class Reamaze_Reamaze_Adminhtml_MainController extends Mage_Adminhtml_Controller_Action {

  /**
   * Init actions
   * @return Reamaze_Reamaze_adminhtml_MainController
   */
  protected function _initAction() {
    $this->loadLayout()
      ->_setActiveMenu('reamaze/dashboard')
      ->_addBreadCrumb('Reamaze', 'Reamaze')
      ->_addBreadCrumb('Dashboard', 'Dashboard');

    return $this;
  }

  public function indexAction($actionPath='') {
    $this->_title('Reamaze')
      ->_title('Dashboard');

    $this->_initAction();
    $this->getLayout()->getBlock('reamaze_main')->setData('actionPath', $actionPath);
    $this->renderLayout();
  }

  public function dashboardAction() {
    $this->indexAction();
  }

  public function reportsAction() {
    $this->indexAction('reports/volume');
  }

  public function kbAction() {
    $this->indexAction('articles');
  }

  public function contactsAction() {
    $this->indexAction('users');
  }

  public function settingsAction() {
    $this->indexAction('settings');
  }

  public function setupAction() {
    $this->_title('Reamaze')
      ->_title('Setup');

    $this->_initAction();
    $this->renderLayout();
  }

  public function setupCallbackAction() {
    $sso = $this->getRequest()->getParam('sso');
    $accountName = $this->getRequest()->getParam('account_name');

    Mage::getModel('core/config')->saveConfig('reamaze_reamaze/account/account_name', $accountName);
    Mage::getModel('core/config')->saveConfig('reamaze_reamaze/account/sso_key', $sso);
    Mage::getModel('core/config')->saveConfig('reamaze_reamaze/setup_completed', true);
    Mage::getModel('core/config')->saveConfig('reamaze_reamaze/setup_incomplete', false);
    Mage::getConfig()->reinit();

    $this->getResponse()->setBody('<html><body><script>top.location.href="' . Mage::helper('adminhtml')->getUrl('reamaze_reamaze/Adminhtml_main/dashboard') . '";</script></body></html>');
  }
}