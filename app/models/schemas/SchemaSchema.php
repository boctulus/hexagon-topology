<?php

namespace simplerest\models\schemas;

use simplerest\core\interfaces\ISchema;

### IMPORTS

class SchemaSchema implements ISchema
{ 
	### TRAITS
	
	function get(){
		return [
			'table_name'	=> 'schema',

			'id_name'		=> NULL,

			'attr_types'	=> [

			],

			'nullable'		=> [],

			'rules' 		=> [

			]
		];
	}	
}

