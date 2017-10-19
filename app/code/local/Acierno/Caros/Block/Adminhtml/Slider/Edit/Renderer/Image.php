<?php
/**
 * Created by PhpStorm.
 * User: skaarl
 * Date: 19/10/17
 * Time: 13.39
 */

class Acierno_Caros_Block_Adminhtml_Slider_Edit_Renderer_Image extends Varien_Data_Form_Element_Image{
    //make your renderer allow "multiple" attribute
    public function getHtmlAttributes(){
        return array_merge(parent::getHtmlAttributes(), array('multiple'));
    }
}