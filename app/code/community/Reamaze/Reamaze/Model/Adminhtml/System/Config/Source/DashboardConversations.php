<?php
/**
 * Dashboard Conversations lists config
 *
 * @author Reamaze
 */
class Reamaze_Reamaze_Model_Adminhtml_System_Config_Source_DashboardConversations {
  protected $_options;

  public function toOptionArray($isMultiselect=false)
  {
    $options = array();
    foreach(Mage::helper('reamaze_reamaze')->getDashboardConversations() as $id => $label)
    {
      $options[]= array('value' => $id, 'label' => $label);
    };

    return $options;
  }
}
