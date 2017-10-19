<?php
/**
 * Created by PhpStorm.
 * User: skaarl
 * Date: 19/10/17
 * Time: 13.05
 */
class Acierno_Caros_Adminhtml_SliderController extends Mage_Adminhtml_Controller_Action {
    /**
     * indexAction
     */
    public function indexAction()
    {

        $this->loadLayout();
        $this->renderLayout();

    }
    /**
     * newAction
     */
    public function newAction()
    {
        $this->_forward('edit');
    }


    /**
     * editAction
     */
    public function editAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function saveAction()
    {
        //prepare model
        if($this->getRequest()->getParam('slider_id')){
            $model= Mage::getModel('acierno_caros/slider')
                ->load($this->getRequest()->getParam('slider_id'));
            if(!$model instanceof Acierno_Carosl_Model_Slider){
                Mage::getSingleton('adminhtml/session')->addError($this->__('There was an error during the Slider loading'));
                return $this->_redirect('*/*/');
            }
        }else{
            $model= Mage::getModel('acierno_caros/slider');
        }

        //verify name


        if(!$this->getRequest()->getParam('name')){
            Mage::getSingleton('adminhtml/session')->addError($this->__('Some required fields are missing: name'));
            return $this->_redirect('*/*/edit/', array('slider_id' =>
                $this->getRequest()->getParam('slider_id')));
        }


        //save the object

        try{

            $model->setData('destination', $this->getRequest()->getParam('destination'));
            $model->setData('titleposition', $this->getRequest()->getParam('titleposition'));
            $model->setShowtitle($this->getRequest()->getParam('showtitle') == 1 ? 1:0);
            $model->setPosition($this->getRequest()->getParam('position'));
            $model->setActiveFrom($this->getRequest()->getParam('active_from'));
            $model->setActiveTo($this->getRequest()->getParam('active_to'));
            $model->setName($this->getRequest()->getParam('name'));
            $model->setStatus($this->getRequest()->getParam('status') == 1 ? 1:0);
            $model->save();

            $this->fileSaving($model,$this->getRequest()->getParam('slider_id'));

        }catch(Exception $e){

            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($this->__('There was an error while saving the slider'));
            return $this->_redirect('*/*/edit/', array('slider_id' =>
                $this->getRequest()->getParam('slider_id')));
        }
        Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The slider was successfully saved'));
        return $this->_redirect('*/*/');

    }


    private function fileSaving($model)
    {

        $id = $model->getId();
        if ($data = $this->getRequest()->getPost()) {
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'][0] != '') {
                try {

                    $path = Mage::getBaseDir() . DS . 'media' . DS . 'caros' . DS . 'images' . DS . $id;  //desitnation directory
                    $i = 0;

                    if (!file_exists(Mage::getBaseDir() . DS . 'media' . DS . 'caros' . DS . 'images')) {
                        mkdir(Mage::getBaseDir() . DS . 'media' . DS . 'caros' . DS . 'images');
                    }
                    if (!file_exists($path)) {
                        mkdir($path);
                    }



                    foreach ($_FILES['image']['name'] as $singleimage) {

                    $imageHandle = Mage::getModel('acierno_caros/images');
                    $imageCollection = $imageHandle->getCollection();

                        $uploader = new Varien_File_Uploader(
                            array(
                                'name' => $_FILES['image']['name'][$i],
                                'type' => $_FILES['image']['type'][$i],
                                'tmp_name' => $_FILES['image']['tmp_name'][$i],
                                'error' => $_FILES['image']['error'][$i],
                                'size' => $_FILES['image']['size'][$i]
                            )
                        );
                        $fname = $_FILES['image']['name'][$i]; //file name
                        $uploader->setAllowCreateFolders(true); //for creating the directory if not exists
                        $uploader->setAllowRenameFiles(false);
                        $uploader->setFilesDispersion(false);

                        $uploader->save($path, $singleimage);


                        //Start to link to the lookup table
                        $imageHandle->setData('slider_id', $id);
                        $imageHandle->setData('path', $path . DS . $fname);
                        $imageHandle->save();


                        $i++;
                    }
                } catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('acierno_caros')->__($fname . " Invalid file format"));
                    var_dump($e); die;
                    $this->_redirect('*/*/');
                    return false;
                }

            } else {
                if (isset($data['image']['delete']) && $data['image']['delete'] == 1)
                    $data['image_main'] = '';
                else
                    unset($data['image']);
            }

            return true;
        }
    }

    public function deleteAction()
    {

        //Load object
        $slider = Mage::getModel('acierno_caros/slider')->load($this->getRequest()->getParam('slider_id'));

        if(!$slider || !$slider->getId())
        {
            Mage::getSingleton('adminhtml/session')->addError($this->__('There was an error during the slider loading'));
            return $this->_redirect('*/*/');
        }

        //delete $slider
        try{
            $id = $slider->getId();
            $this->cascateDelete($id);
            $slider->delete();



        } catch(Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($this->__('There was an error during the slider deleting'));
            return $this->_redirect('*/*/');

        }
        Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The slider was successfully deleted'));
        return $this->_redirect('*/*/');
    }

    private function cascateDelete($id){

        $model = Mage::getModel('acierno_caros/images');
        $collection = $model->getCollection()->addFieldToFilter('slider_id', array('slider_id' => $id));
        foreach ($collection as $ccitem) {
            $ccitem->delete();
        }
        $dir = Mage::getBaseDir() . DS . 'media' . DS . 'caros' . DS . 'images'. DS .$id;
        $this->rrmdir($dir);


    }

    private function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir."/".$object))
                        rrmdir($dir."/".$object);
                    else
                        unlink($dir."/".$object);
                }
            }
            rmdir($dir);
        }
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('acierno_caros');
    }
}