<?php

/**
 * Acierno Carousell
 */

/**
 * Acierno Carousell Block Adminhtml Slider Grid Renderer Status
 *
 *
 * Renderer for status
 * @author Michele Acierno <michele.acierno@thinkopen.it>
 * @version 0.2.0
 * @package Cms
 */

class Acierno_Caros_Block_Adminhtml_Slider_Grid_Renderer_Status extends
Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        if($row->getData('status') == 0 )
        {
            return '<span class="grid-severity-minor" ><span>'.$this->__('Disabled').'</span></span>';
        }
        if($row->getData('status') == 1 )
        {
            return '<span class="grid-severity-notice" ><span>'.$this->__('Enabled').'</span></span>';
        }

        return '<span class="grid-severity-major" ><span>'.$this->__('Error').'</span></span>';

    }
}