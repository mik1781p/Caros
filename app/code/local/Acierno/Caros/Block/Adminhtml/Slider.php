<?php

/**
 * Acierno Carousell
 */

/**
 * Acierno_Caros_Block_Adminhtml_Slider
 *
 *
 * Backend Slider Block
 * @author Michele Acierno <michele.acierno@thinkopen.it>
 * @version 0.2.0
 * @package Cms
 */
class Acierno_Caros_Block_Adminhtml_Slider extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct()
    {

        $this->_blockGroup = 'acierno_caros';

        $this->_controller = 'adminhtml_slider';

        $this->_headerText = $this->__('Carousell Sliders');

        parent::__construct();
    }

    public function getCreateUrl()
    {
        return $this->getUrl('*/*/new');
    }

}

