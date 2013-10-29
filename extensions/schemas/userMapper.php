<?php
namespace extensions\Mapper;
use phpDataMapper\phpDataMapper_Base as phpDataMapper_Base;

// User
class userMapper extends phpDataMapper_Base
{
    // Specify the data source (table for SQL adapters)
    protected $_datasource = "user";
 
    // Define your fields as public class properties
    public $id = array('type' => 'int', 'primary' => true, 'serial' => true);
    public $name = array('type' => 'string', 'required' => true);
    public $firstname = array('type' => 'string', 'required' => true);
    public $email = array('type' => 'string', 'required' => true);
    public $password = array('type' => 'string', 'required' => true);
    public $created_at = array('type' => 'datetime');
    public $updated_at = array('type' => 'datetime');
    
    public $post = array(
    		'type' => 'relation',
    		'relation' => 'HasMany',
    		'mapper' => 'postMapper',
    		'where' => array('author'=>'entity.id')
    );
}