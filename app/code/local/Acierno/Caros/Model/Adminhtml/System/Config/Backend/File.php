<?php
/**
 * Acierno Carousell
 */

/**
 * Acierno_Carousell_Model_Adminhtml_System_Config_Backend_File
 *
 *
 * Acierno_Carousell_Model_Adminhtml_System_Config_Backend_File
 * Extends the backend file class from magento core, it defines the
 * allowed extensions for the upload in the configuration panel
 *
 * @author Michele Acierno <michele.acierno@thinkopen.it>
 * @version 0.2.0
 * @package Cms
 */

class Acierno_Caros_Model_Adminhtml_System_Config_Backend_File extends
    Mage_Adminhtml_Model_System_Config_Backend_File
{
    protected function _getAllowedExtensions(){
        return array('value' => 'js');
    }
}