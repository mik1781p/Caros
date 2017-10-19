<?php
/**
 * Acierno Carousell
 */

/**
 * Acierno_Carousell_Model_Source_Destination
 *
 *
 * Acierno_Carousell_Model_Source_Destination
 *
 * This destination source defines the possible destination for the
 * carousell, in this version the only possible destination is the
 * homepage
 *
 * @author Michele Acierno <michele.acierno@thinkopen.it>
 * @version 0.2.0
 * @package Cms
 */

class Acierno_Caros_Model_Source_Destination
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 'homepage',
                'label' => Mage::helper('acierno_caros')->__('Homepage'))
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