<?php
/**
 * JS block
 *
 * @author Reamaze
 */
class Reamaze_Reamaze_Block_Js extends Mage_Core_Block_Template {
  public function getJsPath() {
    return Mage::helper('reamaze_reamaze')->getUrlForPath('/assets/reamaze.js');
  }

  public function getSupportJson() {
    $reamazeHelper = Mage::helper('reamaze_reamaze');
    $support = array(
      'account'     => $reamazeHelper->getAccountName()
    );

    if (Mage::getSingleton('customer/session')->isLoggedIn()) {
      $customer = Mage::getSingleton('customer/session')->getCustomer();

      $customerData = $this->_getCustomerData($customer);

      $support['user'] = array(
        'id'    => $customer->getId(),
        'email' => $customer->getEmail(),
        'name' => $customer->getName(),
        'authkey' => $reamazeHelper->getAuthKey($customer->getId(), $customer->getEmail()),
        'data' => $customerData
      );
    }

    $support['ui'] = array(
      'popup' => array(
        'trigger' => $reamazeHelper->getJSPopupTrigger()
      ),
      'embed' => array(
        'container' => $reamazeHelper->getJSEmbedContainer()
      ),
      'mailbox' => array(
        'enabled' => false
      ),
      'widget' => true
    );

    return Mage::helper('core')->jsonEncode($support);
  }

  private function _getCustomerData($customer)
  {
    $data = array();

    try {
      $customerTotals = Mage::getResourceModel('sales/sale_collection')
        ->setCustomerFilter($customer)
        ->load()
        ->getTotals();

      if ($customerLifetimeSales = $customerTotals->getLifetime()) {
        $data['Total Sales'] = Mage::helper('core')->formatCurrency($customerLifetimeSales, false);
      }

      if ($customerAvgSale = $customerTotals->getAvgSale()) {
        $data['Avg Sale'] = Mage::helper('core')->formatCurrency($customerAvgSale, false);
      }
    } catch (Exception $e) {}

    $customerPrimaryBillingAddress = $customer->getPrimaryBillingAddress();

    if ($customerPrimaryBillingAddress) {
      if ($city = $customerPrimaryBillingAddress->getCity()) {
        $data['City'] = $city;
      }

      if ($state = $customerPrimaryBillingAddress->getRegion()) {
        $data['State'] = $state;
      }

      if ($zip = $customerPrimaryBillingAddress->getPostcode()) {
        $data['Zipcode'] = $zip;
      }

      if ($country = $customerPrimaryBillingAddress->getCountryModel()->getName()) {
        $data['Country'] = $country;
      }
    }

    return $data;
  }

  protected function _toHtml()
  {
      if (!Mage::helper('reamaze_reamaze')->isSetupComplete()) {
          return '';
      }
      return parent::_toHtml();
  }
}