<?php
namespace Bss\Training\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

/**
 * Class Ranges
 */
class EarnPointRate extends AbstractFieldArray
{

    /**
     * Prepare to render
     *
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn(
            'earn_point_rate',
            [
                'label' => __('Earn Point Rate'),
                'class' => 'required-entry validate-number validate-greater-than-zero admin__control-text'
            ]
        );
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * Prepare existing row data object
     *
     * @param \Magento\Framework\DataObject $row
     * @return void
     */
    protected function _prepareArrayRow(\Magento\Framework\DataObject $row)
    {
        $optionExtraAttr = [];
        $row->setData(
            'option_extra_attrs',
            $optionExtraAttr
        );
    }
}
