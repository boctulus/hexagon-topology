<?php

namespace simplerest\models;

use simplerest\core\Model;
use simplerest\libs\ValidationRules;
use simplerest\models\schemas\NetworksSchema;

class NetworksModel extends Model
{ 
	protected $hidden   = [];
	protected $not_fillable = [];

    function __construct(bool $connect = false){
        parent::__construct($connect, new NetworksSchema());
	}	

	/*
	function onRead(int $count){
		var_dump($this->dd());
	}
	*/
}

