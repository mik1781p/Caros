<?php
/**
 * Created by PhpStorm.
 * User: skaarl
 * Date: 19/10/17
 * Time: 13.06
 */
class Acierno_Caros_Block_Adminhtml_Slider_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _getModel(){
        return Mage::registry('current_model');
    }

    protected function _getHelper(){
        return Mage::helper('acierno_caros');
    }

    protected function _getModelTitle(){
        return 'Slider';
    }

    protected function _prepareForm()
    {
        $model  = $this->_getModel();
        $modelTitle = $this->_getModelTitle();
        $form   = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save'),
            'method'    => 'post',
            'enctype'  => 'multipart/form-data'
        ));

        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => $this->_getHelper()->__("$modelTitle Information"),
            'class'     => 'fieldset-wide',
        ));

        if ($model && $model->getId()) {
            $modelPk = $model->getResource()->getIdFieldName();
            $fieldset->addField($modelPk, 'hidden', array(
                'name' => $modelPk,
            ));
        }

        $fieldset = $form->addFieldset(
            'general',
            array(
                'legend' => $this->__('General Information'),
                'class'  => 'fieldset-wide'
            )
        );

        $fieldset->addField(
            'name',
            'text',
            array(
                'name' =>'name',
                'label'=> $this->__('Name'),
                'title'=> $this->__('Name'),
                'required' => true
            )
        );

        $fieldset->addField(
            'titleposition',
            'select',
            array(
                'name' =>'titleposition',
                'label'=> $this->__('Position'),
                'title'=> $this->__('Position'),
                'values'=> Mage::getModel('acierno_caros/source_position')->toOptionArray(),
                'required' => false
            )
        );

        $fieldset->addField(
            'destination',
            'select',
            array(
                'name' =>'destination',
                'label'=> $this->__('Destination'),
                'title'=> $this->__('Destination'),
                'values'=> Mage::getModel('acierno_caros/source_destination')->toOptionArray(),
                'required' => false
            )
        );

        $fieldset->addField(
            'showtitle',
            'select',
            array(
                'name' =>'showtitle',
                'label'=> $this->__('Show Title'),
                'title'=> $this->__('Show Title'),
                'values'=> Mage::getModel('acierno_caros/source_status')->toOptionArray(),
                'required' => false
            )
        );


        $dateFormatIso = Mage::app()->getLocale()->getDateFormat(
            Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
        );


        $fieldset->addField(
            'active_from',
            'date',
            array(
                'name' =>'active_from',
                'label'=> $this->__('Active from'),
                'title'=> $this->__('Active from'),
                'format'=> $dateFormatIso,
                'required' => false
            )
        );

        $fieldset->addField(
            'active_to',
            'date',
            array(
                'name' =>'active_to',
                'label'=> $this->__('Active to'),
                'title'=> $this->__('Active to'),
                'format'=> $dateFormatIso,
                'required' => false
            )
        );

        $fieldset->addField(
            'status',
            'select',
            array(
                'name' =>'status',
                'label'=> $this->__('Status'),
                'title'=> $this->__('Status'),
                'values'=> Mage::getModel('acierno_caros/source_status')->toOptionArray(),
                'required' => false
            )
        );

        $fieldset->addType('image', Mage::getConfig()->getBlockClassName('acierno_caros/adminhtml_slider_edit_renderer_image'));
        $fieldset->addField('image', 'image', array(
            'name'      => 'image[]', //declare this as array. Otherwise only one image will be uploaded
            'multiple'  => 'multiple', //declare input as 'multiple'
            'label'     => Mage::helper('acierno_caros')->__('design Image'),
            'title'     => Mage::helper('acierno_caros')->__('design Image'),
            'required'  => false
        ));


        //populate with slider data


        if($this->getRequest()->getParam('slider_id')){
            $model = Mage::getModel('acierno_caros/slider')
                ->load($this->getRequest()->getParam('slider_id'));
            $form->setValues($model);
        }

        if($model){
            $form->setValues($model->getData());
        }
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
