<?php
/**
 * Created by PhpStorm.
 * User: skaarl
 * Date: 19/10/17
 * Time: 13.06
 */
class Acierno_Caros_Block_Adminhtml_Slider_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'slider_id';
        $this->_blockGroup      = 'acierno_caros';
        $this->_controller      = 'adminhtml_slider';
        $this->_mode            = 'edit';

        $modelTitle = $this->_getModelTitle();
        $this->_updateButton('save', 'label', $this->_getHelper()->__("Save $modelTitle"));
        $this->_addButton('saveandcontinue', array(
            'label'     => $this->_getHelper()->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";

        parent::__construct();
    }

    protected function _getHelper(){
        return Mage::helper('acierno_caros');
    }

    protected function _getModel(){
        return Mage::registry('current_model');
    }

    protected function _getModelTitle(){
        return 'Slider';
    }

    public function getHeaderText()
    {
        $model = $this->_getModel();
        $modelTitle = $this->_getModelTitle();
        if ($model && $model->getId()) {
           return $this->_getHelper()->__("Edit $modelTitle (ID: {$model->getId()})");
        }
        else {
           return $this->_getHelper()->__("New $modelTitle");
        }
    }


    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/index');
    }

    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', array($this->_objectId => $this->getRequest()->getParam($this->_objectId)));
    }

    /**
     * Get form save URL
     *
     * @deprecated
     * @see getFormActionUrl()
     * @return string
     */
    public function getSaveUrl()
    {
                $this->setData('form_action_url', 'save');
                return $this->getFormActionUrl();
    }


}
