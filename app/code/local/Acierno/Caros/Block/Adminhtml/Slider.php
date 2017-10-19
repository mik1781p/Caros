<?php
/**
 * Created by PhpStorm.
 * User: skaarl
 * Date: 19/10/17
 * Time: 13.06
 */
class Acierno_Caros_Block_Adminhtml_Slider extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct()
    {

        //Quale sarà il block group da utilizzare
        $this->_blockGroup = 'acierno_caros';

        //Quale controller sarà utilizzato
        $this->_controller = 'adminhtml_slider';

        //Settiamo l'header text con con traduzione
        $this->_headerText = $this->__('Carousell Sliders');

        //richiamiamo il construct del padre
        parent::__construct();
    }

    public function getCreateUrl()
    {
        return $this->getUrl('*/*/new');
    }

}

