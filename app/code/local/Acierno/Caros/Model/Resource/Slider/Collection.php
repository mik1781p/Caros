<?php
/**
 * Created by PhpStorm.
 * User: skaarl
 * Date: 19/10/17
 * Time: 12.53
 */ 
class Acierno_Caros_Model_Resource_Slider_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('acierno_caros/slider');
    }

}