<?php

namespace simplerest\models\schemas;

use simplerest\core\interfaces\ISchema;

### IMPORTS

class HooksSchema implements ISchema
{ 
	### TRAITS
	
	function get(){
		return [
			'table_name'	=> 'hooks',

			'id_name'		=> 'id',

			'attr_types'	=> [
				'id' => 'INT',
				'name' => 'STR',
				'entity' => 'STR',
				'op' => 'STR',
				'conditions' => 'STR',
				'callback' => 'STR',
				'belongs_to' => 'INT',
				'created_at' => 'STR',
				'created_by' => 'INT',
				'updated_at' => 'STR',
				'updated_by' => 'INT',
				'deleted_at' => 'STR',
				'deleted_by' => 'INT'
			],

			'nullable'		=> ['id', 'name', 'op', 'conditions', 'belongs_to', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'],

			'rules' 		=> [
				'name' => ['max' => 50],
				'entity' => ['max' => 50],
				'callback' => ['max' => 255]
			]
		];
	}	
}

