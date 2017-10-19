<?php

/**
 * Acierno Carousell
 */

/**
 * Acierno Carousell Adminhtml Block Slider
 *
 *
 * Backend Slider Block
 * @author Michele Acierno <michele.acierno@thinkopen.it>
 * @version 0.2.0
 * @package Cms
 */


class Acierno_Caros_Block_Slider extends Mage_Core_Block_Template
{

    /**
     * getSlides
     *
     * This method is meant to build the html structure to display
     * the carousell in the main page. It cycle all the selected
     * images and build a structure for it.
     *
     * Returns a string containgn the html to display in the associated
     * phtml.
     * @return string
     */
    public function getSlides()
    {
        $sliders = Mage::getModel('acierno_caros/slider')->getCollection()
        ->addFieldToFilter('status', array('eq' => 1));

        $baseDiv = '<div class="slideshow-con">';
        $baseClassDiv ='<div class="mySlides fade">';
        $clodeDiv ='</div>';
        $baseNextBefore =
            '<a class="prev" onclick="plusSlides(-1)">&#10094;</a>'.
            '<a class="next" onclick="plusSlides(1)">&#10095;</a>';
        $i=0;



        $total = $baseDiv;
        $temp="";

        foreach($sliders as $slide){
            $showtitle = $slide->getData('showtitle');
            $position  = $slide->getData('titleposition');
            $images= Mage::getModel('acierno_caros/images')->getCollection()
                ->addFieldToFilter('slider_id', array('slider_id' => $slide->getData('slider_id')));
            $title     = $slide->getData('name');


            foreach($images as $image){

                $temp = $temp.$baseClassDiv;
                    $link = Mage::getUrl($image->getData('path'));
                    $linkTes = str_replace('htdocs/', '', $link) ;
                    $linkTes=rtrim($linkTes,"/");
                    $temp = $temp.'<img src="'.$linkTes.'" style="width:100%">';
                    if($showtitle){
                        $temp = $temp.'<div class="'.$position.'">'.$title.'</div>';
                    }
                    $temp = $temp.$clodeDiv;
            }

        }

        $temp = $temp.$baseNextBefore.$clodeDiv;
        $total = $total.$temp;
        Mage::log($total);
        return $total;
    }
}

?>

