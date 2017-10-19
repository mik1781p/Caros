<?php
/**
 * Created by PhpStorm.
 * User: skaarl
 * Date: 19/10/17
 * Time: 12.52
 */ 
class Acierno_Caros_Helper_Data extends Mage_Core_Helper_Abstract {

    public function getJsBasedOnConfig()
    {
        $baseDir = Mage::getBaseDir() . DS . 'media' . DS . 'caros' ;
        $files = array();
        foreach (glob($baseDir.".js") as $file) {
            $files[] = $file;
        }
        return $files[0];
    }
}