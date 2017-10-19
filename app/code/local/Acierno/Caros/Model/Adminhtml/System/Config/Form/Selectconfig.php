<?php
/**
 * Acierno Carousell
 */

/**
 * Acierno_Carousell_Model_Adminhtml_System_Config_Form_Selectconfig
 *
 *
 * Acierno_Carousell_Model_Adminhtml_System_Config_Form_Selectconfig
 *
 * This form select defines the two possibile alternative for the
 * display, as fullwidth or wrapped.
 *
 * @author Michele Acierno <michele.acierno@thinkopen.it>
 * @version 0.2.0
 * @package Cms
 */

class Acierno_Caros_Model_Adminhtml_System_Config_Form_Selectconfig
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 'fullwidth',
                'label' => 'Full Width'
            ),
            array(
                'value' => 'bootstrap',
                'label' => 'Wrapped'
            )

        );
    }
}