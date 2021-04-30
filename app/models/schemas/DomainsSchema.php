<?php

namespace simplerest\models\schemas;

use simplerest\core\interfaces\ISchema;

### IMPORTS

class DomainsSchema implements ISchema
{ 
	### TRAITS
	
	function get(){
		return [
			'table_name'	=> 'domains',

			'id_name'		=> 'id',

			'attr_types'	=> [
				'id' => 'INT',
				'domain' => 'STR',
				'sub' => 'STR',
				'sub_type' => 'STR',
				'lang' => 'STR',
				'country' => 'STR',
				'registered_at' => 'STR',
				'registrar' => 'STR',
				'niche' => 'STR',
				'keywords' => 'STR',
				'server' => 'STR',
				'api_key' => 'STR',
				'cms' => 'STR',
				'adsense' => 'STR',
				'alexa_rank' => 'INT',
				'network_id' => 'INT',
				'created_at' => 'STR'
			],

			'nullable'		=> ['id', 'sub', 'sub_type', 'country', 'registered_at', 'registrar', 'niche', 'keywords', 'server', 'api_key', 'cms', 'alexa_rank', 'created_at'],

			'rules' 		=> [
				'domain' => ['max' => 30],
				'sub' => ['max' => 30],
				'lang' => ['max' => 2],
				'country' => ['max' => 2],
				'registrar' => ['max' => 30],
				'niche' => ['max' => 30],
				'keywords' => ['max' => 2000],
				'server' => ['max' => 30],
				'api_key' => ['max' => 200],
				'cms' => ['max' => 30],
				'adsense' => ['max' => 30]
			]
		];
	}	
}

