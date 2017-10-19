#Carousel Readme

##Description

Hello again! This is a study purpose module, focused on
the Grid/Form aspect of Magento. Basically is Carousel
handler, meant to handle images and sliders in a specific
period of time. A CronJob determines if a Carousel is meant
to be active and sets it (or them) active.
Remember that this is a study module, so some parts may
be a bit lacky, but let's start with the fun!

##Use

1) Install the module
2) Configure the module, enabling it in the admin panel and deciding which library we want to upload
3) Let's go in CMS->Sliders to create our slider
4) Create a new slider, compiling every field in there 
5) Let's go in the homepage and enjoy our sliders! 

Seems easy, doesnt? Well it is not so simple as we may thing.
Let's start analyzing the configuration files.

##Configuration
As we did for the previous modules, in this module too we will 
analyze only the most important parts, for a more basic view you
shall go to the Helloworld Module, or instead for a different 
view the Coupon Module.

    /app/code/local/Acierno/Caros/etc/config.xml

This is the main configuration file, let's take a look

        <models>
            <acierno_caros>
                <class>Acierno_Caros_Model</class>
                <resourceModel>acierno_caros_resource</resourceModel>
            </acierno_caros>
            <acierno_caros_resource>
                <class>Acierno_Caros_Model_Resource</class>
                <entities>
                    <slider>
                        <table>slider</table>
                    </slider>
                    <images>
                        <table>images</table>
                    </images>
                </entities>
            </acierno_caros_resource>
        </models>
        
Let's start talking about the Models: models are meant to manipulate
data and handing them, but a module file alone is pretty much pointless
without datas, right? So we must define our data and be able to 
handle theme. That's why we declare a resource: a resource is the 
Magento way to declare possible entities for our database, in our module
we declare two entities: images and sliders (after we will analyze more
in deep theme) related to the our model. So this obligate us to 
define basically three things: 
1) The model
2) The resource
3) The collection

The first is, for now, a dummy class, meant to identify what are
we handling. The second one is the resource, the "core" of our model
in the database. Laest,but not least, is the Collection, an "easy"
way to fast retrive our data. 
Remember: each entites NEEDS it's own model, resource and Collection
to be "alive".

So, we declared our entites, what now? Well we should initialize theme.
The "good" way is, obviusly, though the config file. We define a 
setup for our 

    <resources>
        <acierno_caros_setup>
            <setup>
                <module>Acierno_Caros</module>
            </setup>
        </acierno_caros_setup>
    </resources>
    
Our setup must be locate under the module path (Acierno/Caros)
in the sql folder in this specific way

    Acierno/Caros/sql/acierno_caros_setup/install-0.1.0.php
    
The folder is, as we see, declared in the resources setup. The name
of the file is a convention. Remember, the last numbers are the
version declared for the module. 


    <admin> <!-- backend -->
        <routers>
            <acierno_caros>
                <use>admin</use>
                <args>
                    <module>Acierno_Caros</module>
                    <frontName>acierno_caros</frontName>
                </args>
            </acierno_caros>
        </routers>
    </admin>
    
After we have the admin section, we want to handle our module 
through the admin section and, to be more specific, we need to 
create a grid and a form for it. This is our very first step, declaring
the frontName that will be used in the backoffice by our module.
After we will give it the permissions (adminhtml.xml)

    <crontab>
        <jobs>
            <import>
                <schedule>
                    <cron_expr>*/1 * * * *</cron_expr>
                </schedule>
                <run>
                    <model>acierno_caros/observer::setslidertimebased</model>
                </run>
            </import>
        </jobs>
    </crontab>
    
And here we are, what are we watching to? Well this is the Magento way to declare
a Cron Task. Magento has it's own jobs, we want to add a method that, in
a general amount of time, will be runned (a check for our slider)
Basically we are telling magento that in the model folder, there is a 
file (observer), in this file - when the time comes - the method 
setslidertimebased will be called and will run. We may define the 
time too with cron_expr.

    
    /app/local/Acierno/Caros/etc/adminhtml.xml
    
In this configuration file  we shall define the permissions of our module.
in the first part we declare that CMS will have a child, Caros, that
has a children on it's own which calls to an action.


        <cms>
            <children>
                <acierno_caros>
                    <title>Caros</title>
                    <sort_order>90</sort_order>
                    <children>
                        <acierno_caros_slider>
                            <title>Sliders</title>
                            <sort_order>10</sort_order>
                            <action>acierno_caros/adminhtml_slider</action>
                        </acierno_caros_slider>
                    </children>
                </acierno_caros>
            </children>
        </cms>
        
The second part is pretty much  similar to Helloworld configuration, we declare
that our module has the permissions to create a child of config, the 
elements of it are specified in the system.xml file.


##Installation

A special mension in this guide goes to the install file, let's take a peek.

    <?php
    /**
     * Acierno Carousell
     */
    
    /**
     * Acierno Carousell Installer
     *
     * MySQL Installer.
     * @author Michele Acierno <michele.acierno@thinkopen.it>
     * @version 0.1.0
     * @package Cms
     */
    
    /* @var Mage_Core_Model_Resource_Setup $installer */
    
    
    $installer = $this;
    
    $installer->startSetup();
    
    $table = $installer->getConnection()
        ->newTable($installer->getTable('acierno_caros/slider'))
        ->addColumn(
            'slider_id',
            Varien_Db_Ddl_Table::TYPE_INTEGER,
            null,
            array('primary'=>true,'identity'=>true,'nullable'=>false),
            'Slider Id'
        )->addColumn(
            'name',
            Varien_Db_Ddl_Table::TYPE_TEXT,
            64,
            array('nullable'=>false),
            'Slider name'
        )->addColumn(
            'images_id',
            Varien_Db_Ddl_Table::TYPE_INTEGER,
            null,
            array('nullable'=>false),
            'Image ids, the "-" char will define difference'
        )->addColumn(
            'destination',
            Varien_Db_Ddl_Table::TYPE_TEXT,
            64,
            array('nullable'=>false),
            'Image ids, the "," char will define difference'
        )->addColumn(
            'status',
            Varien_Db_Ddl_Table::TYPE_BOOLEAN,
            null,
            array('nullable'=>false),
            'Image status'
        )->addColumn(
            'showtitle',
            Varien_Db_Ddl_Table::TYPE_BOOLEAN,
            null,
            array('nullable'=>false),
            'Shows or not the title'
        )->addColumn(
            'titleposition',
            Varien_Db_Ddl_Table::TYPE_TEXT,
            64,
            array('nullable'=>false),
            'Position of the title'
        )->addColumn(
            'active_from',
            Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
            null,
            array('default'=>Varien_Db_Ddl_Table::TIMESTAMP_INIT),
            'Slider uploaded at'
        )->addColumn(
            'active_to',
            Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
            null,
            array('default'=>Varien_Db_Ddl_Table::TIMESTAMP_INIT_UPDATE),
            'Slider updated at'
        )->addColumn(
            'created_at',
            Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
            null,
            array('default'=>Varien_Db_Ddl_Table::TIMESTAMP_INIT),
            'Slider uploaded at'
        )->addColumn(
            'updated_at',
            Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
            null,
            array('default'=>Varien_Db_Ddl_Table::TIMESTAMP_INIT_UPDATE),
            'Slider updated at'
        );
    
    
    $tableLookup= $installer->getConnection()
        ->newTable($installer->getTable('acierno_caros/images'))
        ->addColumn(
            'images_id',
            Varien_Db_Ddl_Table::TYPE_INTEGER,
            null,
            array('primary'=>true,'identity'=>true,'nullable'=>false),
            'Slider Id'
        )->addColumn(
            'slider_id',
            Varien_Db_Ddl_Table::TYPE_INTEGER,
            null,
            array('nullable'=>false),
            'Image ids, the "-" char will define difference'
        )->addColumn(
            'path',
            Varien_Db_Ddl_Table::TYPE_TEXT,
            256,
            array('nullable'=>false,
            'Slider path for images'
            ));
    
    $installer->getConnection()->createTable($table);
    $installer->getConnection()->createTable($tableLookup);
    $installer->endSetup();
    
Our system is based by two particular tables declared in this 
installation: the sliders table and the images table.
How it works? So the Slider table contains the main data for 
the slider (Id, show time,  show title and so on).
The Image table instead is a reference table, here we define
basically three thing:

1) The identity of the image
2) The owner of the image (slider_id)
3) And the path of the image (where it is stored)

So we might understand how it will go, we must handle this 
structure though our module, let's continue.

##Block, Grid and Form

This is another of the main focuses of this module. we must 
give the user a way to manipulate sliders and images and this
is the way. A Grid is a matrix, define by columns and datas, that
rappresents a view on the data. Here we may want to edit/delete or 
create new sliders, but let's be more specific.
    
    Acierno/Caros/Block/Adminhtml
    
Why this path? Because we are creating ad adminhtml element. The first
file that we encounter is Slider.php 

    Acierno/Caros/Block/Adminhtml/Slider.php
        
    <?php
    
    /**
     * Acierno Carousell
     */
    
    /**
     * Acierno_Caros_Block_Adminhtml_Slider
     *
     *
     * Backend Slider Block
     * @author Michele Acierno <michele.acierno@thinkopen.it>
     * @version 0.2.0
     * @package Cms
     */
    class Acierno_Caros_Block_Adminhtml_Slider extends Mage_Adminhtml_Block_Widget_Grid_Container {
    
        public function __construct()
        {
    
            $this->_blockGroup = 'acierno_caros';
    
            $this->_controller = 'adminhtml_slider';
    
            $this->_headerText = $this->__('Carousell Sliders');
    
            parent::__construct();
        }
    
        public function getCreateUrl()
        {
            return $this->getUrl('*/*/new');
        }
    
    }

This block is pretty simple, as important. We are declaring 
the group of our block, it's controller and the header text.
And most important it is the Container for our Grid, in fact this
will be filled with the grid file.

    <?php
    /**
     * Acierno Carousell
     */
    
    /**
     * Acierno_Caros_Block_Adminhtml_Slider_Grid
     *
     *
     * Backend Slider Grid
     * @author Michele Acierno <michele.acierno@thinkopen.it>
     * @version 0.2.0
     * @package Cms
     */
    class Acierno_Caros_Block_Adminhtml_Slider_Grid extends Mage_Adminhtml_Block_Widget_Grid {
    
        public function __construct()
        {
            parent::__construct();
            $this->setId('slider_id');
            $this->setDefaultSort('slider_id');
            $this->setDefaultDir('asc');
            $this->setSaveParametersInSession(true);
        }
    
        protected function _prepareCollection()
        {
            $collection = Mage::getModel('acierno_caros/slider')->getCollection();
            $this->setCollection($collection);
            return parent::_prepareCollection();
        }
    
        protected function _prepareColumns()
        {
    
            $this->addColumn('slider_id',
                array(
                    'index' => 'slider_id',
                    'header' => $this->__('ID'),
                    'width' => 50,
                    'type' => 'number'
                )
            );
    
            $this->addColumn('name',
                array(
                    'index' => 'name',
                    'header' => $this->__('Name'),
                )
            );
    
            $this->addColumn('destination',
                array(
                    'index' => 'destination',
                    'header' => $this->__('Destination'),
                )
            );
    
            $this->addColumn('titleposition',
                array(
                    'index' => 'titleposition',
                    'header' => $this->__('Title Position'),
                )
            );
            $this->addColumn('active_from',
                array(
                    'index' => 'active_from',
                    'header' => $this->__('Active from'),
                )
            );
            $this->addColumn('active_to',
                array(
                    'index' => 'active_to',
                    'header' => $this->__('Active to'),
                )
            );
    
    
            $this->addColumn('showtitle',
                array(
                    'index' => 'showtitle',
                    'header' => $this->__('Show Title'),
                    'type'  => 'options',
                    'options' => Mage::getModel('acierno_caros/source_status')->toGridArray(),
                    'renderer'=> 'acierno_caros/adminhtml_slider_grid_renderer_status'
                )
            );
    
            $this->addColumn('status',
                array(
                    'index' => 'status',
                    'header' => $this->__('Status'),
                    'type'  => 'options',
                    'options' => Mage::getModel('acierno_caros/source_status')->toGridArray(),
                    'renderer'=> 'acierno_caros/adminhtml_slider_grid_renderer_status'
                )
            );
    
            $this->addColumn('actions',
                array(
                    'header' => $this->__('Actions'),
                    'width' => 100,
                    'type' => 'action',
                    'getter' => 'getId',
                    'actions' => array(
                        array(
                            'caption' => $this->__('Edit'),
                            'url' => array('base' => '*/*/edit'),
                            'field' => 'slider_id'
                        ),
                        array(
                            'caption' => $this->__('Delete'),
                            'url' => array('base' => '*/*/delete'),
                            'field' => 'slider_id',
                            'confirm' => $this->__('Are you sure you want to delete this?')
                        ),
                    ),
                    'filter' => false,
                    'sortable'=> false,
                    'index' => 'stores',
                    'is_system' => true
    
                )
            );
    
            
            
            return parent::_prepareColumns();
        }
    
        public function getRowUrl($row)
        {
           return $this->getUrl('*/*/edit', array('id' => $row->getId()));
        }
    
        }

So, what's so  important about this file? Is the way we look at our grid.
We start overring the construct method, declaring what is the id 
of the entity handled (slider_id) and then we start preparing the collection.

Here we call the Model associated with the entity, fetching it's entries
in the database

        $collection = Mage::getModel('acierno_caros/slider')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
        
we may want to do something before preparing the columns, or not,  but in my 
case i just wanted to set the collection for the grid.

After we have the _prepareColumns method, this is the core of the grid, here 
we define what will be showed to the user. The way is simple, 
we add as many columns as we need, respecting the sytax: the column
name and the  datas associated with it 

        $this->addColumn('slider_id',
            array(
                'index' => 'slider_id',
                'header' => $this->__('ID'),
                'width' => 50,
                'type' => 'number'
            )
        );
        
A particular mention is for status and actions. Status is, as we define, a
binary choice: Enabled or Disable. But in our system is a boolean, how do
we render it in a way that is more comprensible? This is a way: we create
a Renderer and associate it with the options, the renderer will have the 
duty to associate the value with it's representation.


        $this->addColumn('actions',
            array(
                'header' => $this->__('Actions'),
                'width' => 100,
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => $this->__('Edit'),
                        'url' => array('base' => '*/*/edit'),
                        'field' => 'slider_id'
                    ),
                    array(
                        'caption' => $this->__('Delete'),
                        'url' => array('base' => '*/*/delete'),
                        'field' => 'slider_id',
                        'confirm' => $this->__('Are you sure you want to delete this?')
                    ),
                ),
                'filter' => false,
                'sortable'=> false,
                'index' => 'stores',
                'is_system' => true

            )
        );
        
Actions, instead, is a little bit more complicated. it defines 
a column that recalls to method of the controller. Each method 
that we define here must be handled in the controller action and
should follow the logic of the dataflow (in our case the multiple
eliminations of files and cascade in the image table)

    public function getRowUrl($row)
        {
           return $this->getUrl('*/*/edit', array('id' => $row->getId()));
        }
        
getRowUrl is a simple click and edit shortcut for the clicked row.

###Form and Tabs
This is the Edit domain, here we start handling all the manipulation process.
We start by defining the Form which shall contain the input and, possibly, the
Tabs associated with it. 
Tabs.php is a pretty simple file 


    <?php
    
    /**
     * Acierno Carousell
     */
    
    /**
     * Acierno Carousell Block Adminhtml Slider Edit Tabs
     *
     *
     * Backend Slider Adminhtml form for tabs sliders
     * Main Helper
     * @author Michele Acierno <michele.acierno@thinkopen.it>
     * @version 0.2.0
     * @package Cms
     */
    
    class Acierno_Caros_Block_Adminhtml_Slider_Edit_Tabs extends
    Mage_Adminhtml_Block_Widget_Tabs
    {
        /**
         * _construct
         */
        public function _construct()
        {
            parent::_construct();
            $this->setId('slider_edit_tabs'); // nome della tab
            $this->setDestElementId('slider_edit_form'); //Il contenuto della tab
        }
    
    
        protected function _beforeToHtml()
        {
            $this->addTab(
                'Slider Details',
                array(
                    'label' => $this->__('Details'),
                    'title' => $this->__('Details'),
    
                )
            );
            parent::_beforeToHtml();
        }


It defines the tab name and it's content. Notice that 
the name MUST be declared this way
    
    entityname_edit_tabs
    
Why? Probably a hard coded piece of code in the core... 


The Form instead is a bit more complicated than tabs. We will analyze 
only the most important parts of this file, for a deeper look go to 
the file.

    Acierno/Caros/Block/Adminhtml/Slider/Edit/Form.php
    
The start by preparing the form

        $model  = $this->_getModel();
        $modelTitle = $this->_getModelTitle();
        $form   = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save'),
            'method'    => 'post',
            'enctype'  => 'multipart/form-data'
        ));

We get the model associated with the form (we already) declared it
in the Block file. After we retrive the title and, in the end, create
a new form. This form shall be an edit_form, with the save
action (goes to the controller associated) that uses the 
post method and handles multiple datas (this allowes the handling 
of files).

After, add after add, we add each field that we need. A notable 
part is the images one


        $fieldset->addType('image', Mage::getConfig()->getBlockClassName('acierno_caros/adminhtml_slider_edit_renderer_image'));
        $fieldset->addField('image', 'image', array(
            'name'      => 'image[]', //declare this as array. Otherwise only one image will be uploaded
            'multiple'  => 'multiple', //declare input as 'multiple'
            'label'     => Mage::helper('acierno_caros')->__('design Image'),
            'title'     => Mage::helper('acierno_caros')->__('design Image'),
            'required'  => false
        ));
        
To add multiple images field, we must add the type, define as a merge of arrays ( Take
a look to the rendeder for the images ) and define a field 
that takes an array as name, and an input defined as multiple. This will
tell magento that we are gonna handle multiple files with this field.

When we are ready to go, we set use for the container and set the form.

     $form->setUseContainer(true);
            $this->setForm($form);
    
            return parent::_prepareForm();
        }
        

##The controller

Now we created the grid and the form, we declared specific functions (as saving, removing and 
creating new entries). How do we handle them? With the controller.
Each action must be attached to a specific function in the controler
associated with the grid, the SliderController.php file is our controller.

    Acierno/Caros/controllers/Adminhtml/SliderController.php
    
This is a huge file, it contains all the behaviours and method to 
handle the most important processes of our grid, let's analyze the two 
most important methods here define: 

- saveAction
- removeAction

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

So, a bit of code isnt it? It's flow is basically like this:

1) Checks if it has all the params he needs, if not informs the 
user and goes back.
2) Saves the data collected from the Fields in to the model fields and 
save them
3) Calls fileSaving, which has the responsibility to handle the saving 
of file. It creates(if does not exist, new slider) a folder in which all
the present and future images are stored. In addition creates a new reference
in the image table, linking the path of the image to the slider id, to be
able to retrive the data. 
4) If all went good, goes back with a success message. 


The second, and most imporant,part of this controller is the delete action.


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

The remove is divided in three parts: 
1) The remove of the sliders from it's table.
2) The remove of the images associated to the slider in the image table
3) The remove of the folder associated with the slider

This is done separating the logic in three different methods.
In the first one (deleteAction) we retrive the ID of the slider
that we want to delete, passing it to the second method,the cascateDelete.
CascateDelete searches in the image collection, filtering by slider_id, retriving
all the images associated with the slider. After the reference remove, we can 
remove, recursively, the folder associated with the slider.

And thats it! 


##Ending

This is the Caros  module, an overview on it, i hope you liked it and see you in the 
next magento module!