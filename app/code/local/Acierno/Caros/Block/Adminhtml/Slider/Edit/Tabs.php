<?php

/**
 * Acierno Carousell
 */

/**
 * Acierno Carousell Block Adminhtml Slider Edit Tabs
 *
 *
 * Backend Slider Adminhtml form for tabs sliders
 * Main Helper
 * @author Michele Acierno <michele.acierno@thinkopen.it>
 * @version 0.2.0
 * @package Cms
 */

class Acierno_Caros_Block_Adminhtml_Slider_Edit_Tabs extends
Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * _construct
     */
    public function _construct()
    {
        parent::_construct();
        $this->setId('slider_edit_tabs'); // nome della tab
        $this->setDestElementId('slider_edit_form'); //Il contenuto della tab
    }


    protected function _beforeToHtml()
    {
        $this->addTab(
            'Slider Details',
            array(
                'label' => $this->__('Details'),
                'title' => $this->__('Details'),

            )
        );
        parent::_beforeToHtml();
    }
}