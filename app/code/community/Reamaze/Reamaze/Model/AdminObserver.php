<?php
/**
 * Reamaze admin observer
 * @author Reamaze
 */
class Reamaze_Reamaze_Model_AdminObserver {
  public function afterConfigSaved(Varien_Event_Observer $observer) {
    if (Mage::helper('reamaze_reamaze')->getAccountName()) {
      Mage::getModel('core/config')->saveConfig('reamaze_reamaze/setup_completed', true);
      Mage::getModel('core/config')->saveConfig('reamaze_reamaze/setup_incomplete', false);
    } else {
      Mage::getModel('core/config')->saveConfig('reamaze_reamaze/setup_completed', false);
      Mage::getModel('core/config')->saveConfig('reamaze_reamaze/setup_incomplete', true);
    }

    Mage::getConfig()->reinit();
  }

  public function coreBlockAbstractPrepareLayoutAfter(Varien_Event_Observer $observer)
  {
    if (Mage::app()->getFrontController()->getAction()->getFullActionName() === 'adminhtml_dashboard_index')
    {
      $block = $observer->getBlock();
      if ($block->getNameInLayout() === 'dashboard')
      {
        $block->getChild('diagrams')->setUseAsDashboardHook(true);
        $block->getChild('grids')->setUseAsDashboardHook(true);
      }
    }
  }

  public function coreBlockAbstractToHtmlBefore(Varien_Event_Observer $observer)
  {
    if (Mage::app()->getFrontController()->getAction()->getFullActionName() === 'adminhtml_dashboard_index')
    {
      if ($observer->getBlock()->getUseAsDashboardHook())
      {
        $helper = Mage::helper('reamaze_reamaze');

        if ($observer->getBlock()->getBlockAlias() === 'diagrams' && Mage::getStoreConfig(Mage_Adminhtml_Block_Dashboard::XML_PATH_ENABLE_CHARTS)) {
          $enabledCharts = $helper->getEnabledDashboardCharts();
          $allCharts = $helper->getDashboardCharts();

          if (count($enabledCharts) > 0) {
            foreach($enabledCharts as $chart_id) {
              $chartBlock = $observer->getBlock()->getLayout()
                ->createBlock('core/template')
                ->setName('reamaze_adminhtml_dashboard_chart_'.$chart_id)
                ->setTemplate('reamaze/reamaze/adminhtml_dashboard_chart.phtml')
                ->setData('chart_id', $chart_id);

              $observer->getBlock()->addTab($chart_id, array(
                'label'     => $allCharts[$chart_id],
                'content'   => $chartBlock->toHtml()
              ));
            }
          }
        } else if ($observer->getBlock()->getBlockAlias() === 'grids') {
          $enabledConversations = $helper->getEnabledDashboardConversations();
          $allConversations = $helper->getDashboardConversations();

          if (count($enabledConversations) > 0) {
            foreach($enabledConversations as $conversations_id) {
              $conversationsBlock = $observer->getBlock()->getLayout()
                ->createBlock('core/template')
                ->setName('reamaze_adminhtml_dashboard_conversations_'.$conversations_id)
                ->setTemplate('reamaze/reamaze/adminhtml_dashboard_conversations.phtml')
                ->setData('conversations_id', $conversations_id);

              switch ($conversations_id) {
                case 'unresolved':
                  $conversationsBlock->setData('filter', 'unresolved');
                  break;
                case 'assigned_to_me':
                  $conversationsBlock->setData('filter', 'me');
                  break;
              }

              $observer->getBlock()->addTab($conversations_id, array(
                'label'     => $allConversations[$conversations_id],
                'content'   => $conversationsBlock->toHtml()
              ));
            }
          }
        }
      }
    }
  }
}