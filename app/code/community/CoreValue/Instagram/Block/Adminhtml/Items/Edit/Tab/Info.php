<?php
class CoreValue_Instagram_Block_Adminhtml_Items_Edit_Tab_Info extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $helper = Mage::helper('corevalueinstagram');
        $model = Mage::registry('current_item');

        $form = new Varien_Data_Form();

        $this->setForm($form);

        $fieldset = $form->addFieldset('item_form', array('legend' => $helper->__('Post Information')));

        $fieldset->addField('sort_order', 'select', array(
            'label' => $helper->__('Sort Order'),
            'required' => true,
            'name' => 'corevalue_instagram_item[sort_order]',
            'values' => $this->getSortOrderValues()
        ));

        $fieldset->addField('enabled', 'select', array(
            'label' => $helper->__('Enabled'),
            'required' => true,
            'name' => 'corevalue_instagram_item[enabled]',
            'values' => $this->getEnabledValues()
        ));

        $fieldset->addField('instagram_caption', 'textarea', array(
            'label' => $helper->__('Descripton'),
            'required' => true,
            'name' => 'corevalue_instagram_item[instagram_caption]'
        ));

        $form->setValues($model->getData());
    }

    private function getSortOrderValues()
    {
        $result = array();
        $start = 0;
        $settings = Mage::helper('corevalueinstagram/instagram')->getSettings();
        $end = $settings['{count}'];

        for ($i = $start; $i <= $end; $i++) {
            $result[] = array(
                'label' => $i,
                'value' => $i
            );
        }

        return $result;
    }
    
    private function getEnabledValues()
    {
        return array(
            array('label' => 'Yes', 'value' => 1),
            array('label' => 'No', 'value' => 0)
        );
    }
}