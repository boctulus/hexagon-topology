<?php

namespace simplerest\models\schemas;

use simplerest\core\interfaces\ISchema;

### IMPORTS

class Api-keysSchema implements ISchema
{ 
	### TRAITS
	
	function get(){
		return [
			'table_name'	=> 'api-keys',

			'id_name'		=> NULL,

			'attr_types'	=> [

			],

			'nullable'		=> [],

			'rules' 		=> [

			]
		];
	}	
}

