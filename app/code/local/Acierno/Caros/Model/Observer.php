<?php
/**
 * Acierno Caros
 */

/**
 * Acierno_Caros_Model_Observer
 *
 *
 * Acierno_Caros_Model_Observer
 * This is the observer associated with our cron job
 * (This is not Actually and observer, because it is
 * called instead of triggered, so the name is just
 * to remember it's particular function)
 *
 * @author Michele Acierno <michele.acierno@thinkopen.it>
 * @version 0.2.0
 * @package Cms
 */



class Acierno_Caros_Model_Observer {


    /**
     * setSliderTimeBased
     *
     * This method is meant to check and handle, as a cron
     * job, the date avaible for a slider. It checks the current
     * time with the from-to selected for the slider.
     * If the current date is within the from-to dates, the slider
     * is actived, instead is set to disable.
     *
     * returns nothing
     */
    public function setSliderTimeBased()
    {
        $model  = Mage::getModel('acierno_caros/slider');
        $sliders= $model->getCollection();
        $currentDate = strtotime( Mage::getSingleton('core/date')->gmtDate());
        foreach($sliders as $slider){
            $tempStart= strtotime($slider->getData('active_from'));
            $tempEnd=strtotime($slider->getData('active_to'));
            if(($tempStart<=$currentDate) && ($tempEnd>=$currentDate))
            {
                $slider->setData('status',true);
            }else{
                $slider->setData('status',false);
            }
            $slider->save();
        }

    }
}

?>