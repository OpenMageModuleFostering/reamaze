<?php
/**
 * frontend model for help me link
 *
 * @author Reamaze
 */
class Reamaze_Reamaze_Block_Adminhtml_System_Config_HelpMe extends Mage_Adminhtml_Block_System_Config_Form_Field
{
  protected function _construct()
  {
    parent::_construct();
  }

  public function render(Varien_Data_Form_Element_Abstract $element)
  {
    $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
    return parent::render($element);
  }

  protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
  {
    $block = $this->getLayout()
      ->createBlock('core/template')
      ->setName('reamaze_adminhtml_system_config_helpme')
      ->setTemplate('reamaze/reamaze/system/config/helpme.phtml')
      ->setData('js_path', $this->getJsPath());

      return $block->toHtml();
  }

  private function getJsPath()
  {
    return Mage::helper('reamaze_reamaze')->getUrlForPath('/assets/reamaze.js');
  }
}