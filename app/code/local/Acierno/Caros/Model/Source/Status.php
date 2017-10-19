<?php
/**
 * Acierno Carousell
 */

/**
 * Acierno_Carousell_Model_Source_Status
 *
 *
 * Acierno_Carousell_Model_Source_Status
 * Standard source for status, defines a binary choice for
 * enabled or disabled combo.
 *
 * @author Michele Acierno <michele.acierno@thinkopen.it>
 * @version 0.2.0
 * @package Cms
 */

class Acierno_Caros_Model_Source_Status
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 0,
                'label' => Mage::helper('acierno_caros')->__('Disabled')),
            array(
                'value' => 1,
                'label' => Mage::helper('acierno_caros')->__('Enabled'))
        );


    }


    public function toGridArray()
    {
        foreach ($this->toOptionArray() as $option) {
            $array[$option['value']] = $option['label'];
        }
        return $array;
    }

}