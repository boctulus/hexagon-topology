<?php

namespace simplerest\models;

use simplerest\core\Model;
use simplerest\libs\ValidationRules;
use simplerest\models\schemas\LinksSchema;
use simplerest\libs\Factory;

class LinksModel extends Model
{ 
	protected $hidden   = [];
	protected $not_fillable = [];

    function __construct(bool $connect = false){
        parent::__construct($connect, new LinksSchema());
	}	

	/*
	function onRead(int $count){
		dd($_GET);
		dd(Factory::request()->getQuery('fields'), 'FIELDS');	

		dd($this->getWhere());
	}
	*/
}

