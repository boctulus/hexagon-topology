<?php

namespace simplerest\models;

use simplerest\core\Model;
use simplerest\libs\DB;
use simplerest\models\schemas\WebhooksSchema;
use simplerest\libs\Factory;

class WebhooksModel extends Model
{ 
	protected $hidden   = [];
	protected $not_fillable = [];

    function __construct(bool $connect = false){
        parent::__construct($connect, new WebhooksSchema());
	}	

	function onCreating(array &$data)
	{
		parse_str($data['conditions'], $conditions);

		$entity = $data['entity'];
		$entity_instance = DB::table($data['entity']);
		
		$fields = $entity_instance->getAttr();
		$cond_fields = array_keys($conditions);

		foreach($cond_fields as $cf){
			if (!in_array($cf, $fields)){
				Factory::response()->sendError('Data validation error', 400, "Some condition refers to '$cf' but it's unknown in $entity");
			}
		}

		//$rules  = $entity_instance->getRules();
	}
}

