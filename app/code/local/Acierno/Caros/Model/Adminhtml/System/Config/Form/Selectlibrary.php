<?php
/**
 * Acierno Carousell
 */

/**
 * Acierno_Carousell_Model_Adminhtml_System_Config_Form_Selectlibrary
 *
 *
 * Acierno_Carousell_Model_Adminhtml_System_Config_Form_Selectlibrary
 *
 * Handles the possible libraries to load in the template for the carousell
 *
 * @author Michele Acierno <michele.acierno@thinkopen.it>
 * @version 0.2.0
 * @package Cms
 */

class Acierno_Caros_Model_Adminhtml_System_Config_Form_Selectlibrary extends Mage_Core_Model_Abstract
{
    public function toOptionArray()
    {
        return Mage::helper('acierno_caros')->getAllFiles();
    }
}

