<?php
namespace extensions\Mapper;
use phpDataMapper\phpDataMapper_Base as phpDataMapper_Base;

// User
class postMapper extends phpDataMapper_Base
{
    // Specify the data source (table for SQL adapters)
    protected $_datasource = "post";
 
    // Define your fields as public class properties
    public $id = array('type' => 'int', 'primary' => true, 'serial' => true);
    public $title = array('type' => 'string', 'required' => true);
    public $description = array('type' => 'text', 'required' => true);
    public $authorId = array('type' => 'int', 'required' => true);
    public $created_at = array('type' => 'datetime');
    public $updated_at = array('type' => 'datetime');
}