<?php
/**
 * Acierno Carousell
 */

/**
 * Acierno_Carousell_Model_Source_Position
 *
 *
 * Acierno_Carousell_Model_Source_Position
 * This position source defines the position of the text to
 * overlay to the image in the slider, in this version there
 * are four possible location (with the associated CSS in skin)
 *
 * @author Michele Acierno <michele.acierno@thinkopen.it>
 * @version 0.2.0
 * @package Cms
 */


class Acierno_Caros_Model_Source_Position
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 'up left',
                'label' => Mage::helper('acierno_caros')->__('Up Left')),
            array(
                'value' => 'up right',
                'label' => Mage::helper('acierno_caros')->__('Up Right')),
            array(
                'value' => 'bottom left',
                'label' => Mage::helper('acierno_caros')->__('Bottom Left')),
            array(
                'value' => 'bottom right',
                'label' => Mage::helper('acierno_caros')->__('Bottom Right')),

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