<?php

namespace simplerest\models\schemas;

use simplerest\core\interfaces\ISchema;

### IMPORTS

class ApiKeysSchema implements ISchema
{ 
	### TRAITS
	
	function get(){
		return [
			'table_name'	=> 'api_keys',

			'id_name'		=> NULL,

			'attr_types'	=> [

			],

			'nullable'		=> [],

			'rules' 		=> [

			]
		];
	}	
}

