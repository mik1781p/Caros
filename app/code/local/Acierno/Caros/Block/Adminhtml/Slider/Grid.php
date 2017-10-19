<?php
/**
 * Created by PhpStorm.
 * User: skaarl
 * Date: 19/10/17
 * Time: 13.06
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
