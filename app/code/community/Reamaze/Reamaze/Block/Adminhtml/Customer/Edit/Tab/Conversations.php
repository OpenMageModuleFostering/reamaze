<?php
/**
 * Dashboard Conversations lists config
 *
 * @author Reamaze
 */
class Reamaze_Reamaze_Block_Adminhtml_Customer_Edit_Tab_Conversations
  extends Mage_Adminhtml_Block_Template
  implements Mage_Adminhtml_Block_Widget_Tab_Interface {

  public function getTabLabel() {
    return Mage::helper('reamaze_reamaze')->__('Conversations');
  }

  public function getTabTitle() {
    return Mage::helper('reamaze_reamaze')->__('Conversations');
  }

  public function canShowTab() {
    if (Mage::registry('current_customer')->getId()) {
      return true;
    }
    return false;
  }

  public function isHidden() {
    if (Mage::registry('current_customer')->getId()) {
      return false;
    }
    return true;
  }

  public function getCustomer()
  {
    if (!$this->_customer) {
        $this->_customer = Mage::registry('current_customer');
    }
    return $this->_customer;
  }
}