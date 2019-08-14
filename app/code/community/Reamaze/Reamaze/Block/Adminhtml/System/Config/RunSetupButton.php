<?php
/**
 * frontend model for run setup button
 *
 * @author Reamaze
 */
class Reamaze_Reamaze_Block_Adminhtml_System_Config_RunSetupButton extends Mage_Adminhtml_Block_System_Config_Form_Field
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
    $originalData = $element->getOriginalData();
    $button = $this->getLayout()->createBlock('adminhtml/widget_button')
      ->setData(array(
          'html_id'   => 'run-setup',
          'label'     => $originalData['button_label'],
          'onclick'   => "window.location.href='" . Mage::helper("adminhtml")->getUrl('adminhtml/reamaze_admin/setup') . "'"
        )
      );

    return '<span style="margin-right: 10px;">or</span>' . $button->toHtml();
  }
}