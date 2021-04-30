<?php

namespace simplerest\models\schemas;

use simplerest\core\interfaces\ISchema;

### IMPORTS

class LinksSchema implements ISchema
{ 
	### TRAITS
	
	function get(){
		return [
			'table_name'	=> 'links',

			'id_name'		=> 'id',

			'attr_types'	=> [
				'id' => 'INT',
				'domain_id' => 'INT',
				'tier' => 'INT',
				'line' => 'INT',
				'domain_to_link' => 'INT',
				'do_follow' => 'INT',
				'linked_count' => 'INT',
				'max_count' => 'INT',
				'updated_at' => 'STR'
			],

			'nullable'		=> ['id', 'do_follow', 'max_count'],

			'rules' 		=> [

			]
		];
	}	
}

