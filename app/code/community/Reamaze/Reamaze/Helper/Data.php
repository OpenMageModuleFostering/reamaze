<?php
/**
 * Data helper
 *
 * not used at the moment but admin barfs without this
 *
 * @author Reamaze
 */
class Reamaze_Reamaze_Helper_Data extends Mage_Core_Helper_Data {
  const XML_PATH_ACCOUNT_NAME             = 'reamaze_reamaze/account/account_name';

  const XML_PATH_SSO_KEY                  = 'reamaze_reamaze/account/sso_key';

  const XML_PATH_DASHBOARD_CHARTS         = 'reamaze_reamaze/adminhtml_dashboard_widgets/charts';

  const XML_PATH_DASHBOARD_CONVERSATIONS  = 'reamaze_reamaze/adminhtml_dashboard_widgets/conversations';

  const XML_PATH_JS_POPUP_TRIGGER         = 'reamaze_reamaze/integration/js_popup_trigger';

  const XML_PATH_JS_EMBED_CONTAINER       = 'reamaze_reamaze/integration/js_embed_container';

  private static $dashboardCharts = array(
    'response_time' => 'Response Time',
    'volume' => 'Response Volume',
    'staff' => 'Staff Response'
  );

  private static $dashboardConversations = array(
    'unresolved' => 'Unresolved Conversations',
    'assigned_to_me' => 'Conversations Assigned To Me'
  );

  public function getAccountName($store = null) {
    return Mage::getStoreConfig(self::XML_PATH_ACCOUNT_NAME, $store);
  }

  public function getSSOKey($store = null) {
    return Mage::getStoreConfig(self::XML_PATH_SSO_KEY, $store);
  }

  public function getAuthKey($userId, $store = null) {
    return hash('sha256', $userId . ':' . $this->getSSOKey($store));
  }

  public function getDomain() {
    return Mage::getStoreConfig('reamaze_reamaze/domain');
  }

  public function getUrlForPath($path = '/') {
    return 'http' . (Mage::app()->getStore()->isCurrentlySecure() ? 's' : '') . '://'
      . $this->getDomain()
      . $path;
  }

  public function isSetupComplete() {
    return Mage::getStoreConfig('reamaze_reamaze/setup_completed');
  }

  public function getSetupCallbackUrl() {
    return Mage::helper('adminhtml')->getUrl('reamaze_reamaze/Adminhtml_main/setupCallback');
  }

  public function getEnabledDashboardCharts($store = null) {
    return array_filter(explode(',', Mage::getStoreConfig(self::XML_PATH_DASHBOARD_CHARTS, $store)));
  }

  public function getEnabledDashboardConversations($store = null) {
    return array_filter(explode(',', Mage::getStoreConfig(self::XML_PATH_DASHBOARD_CONVERSATIONS, $store)));
  }

  public function getDashboardConversations() {
    return self::$dashboardConversations;
  }

  public function getDashboardCharts() {
    return self::$dashboardCharts;
  }

  public function getJSEmbedContainer($store = null) {
    return Mage::getStoreConfig(self::XML_PATH_JS_EMBED_CONTAINER, $store);
  }

  public function getJSPopupTrigger($store = null) {
    return Mage::getStoreConfig(self::XML_PATH_JS_POPUP_TRIGGER, $store);
  }
}