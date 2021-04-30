<?php

namespace simplerest\models\schemas;

use simplerest\core\interfaces\ISchema;

### IMPORTS

class NetworksSchema implements ISchema
{ 
	### TRAITS
	
	function get(){
		return [
			'table_name'	=> 'networks',

			'id_name'		=> 'id',

			'attr_types'	=> [
				'id' => 'INT',
				'name' => 'STR',
				'lang' => 'STR',
				'country' => 'STR',
				'keywords' => 'STR',
				'description' => 'STR',
				'strategy' => 'STR',
				'created_at' => 'STR'
			],

			'nullable'		=> ['id', 'country', 'keywords', 'description'],

			'rules' 		=> [
				'name' => ['max' => 30],
				'lang' => ['max' => 2],
				'country' => ['max' => 2],
				'keywords' => ['max' => 2000],
				'description' => ['max' => 255],
				'strategy' => ['max' => 30]
			]
		];
	}	
}

