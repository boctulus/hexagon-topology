<?php

namespace simplerest\models;

use simplerest\core\Model;
use simplerest\libs\ValidationRules;
use simplerest\models\schemas\HooksSchema;

class HooksModel extends Model
{ 	
	protected $hidden   = [];
	protected $not_fillable = [];

    function __construct(bool $connect = false){
        parent::__construct($connect, new HooksSchema());

		$this->registerOutputMutator('operations', function(int $val){ 
			$arr = [];

			if ($val & 8){
				$arr[] = "show";
				$val -= 8;
			}

			if ($val & 4){
				$arr[] = "create";
				$val -= 4;
			}

			if ($val & 2){
				$arr[] = "update";
				$val -= 2;
			}

			if ($val & 1){
				$arr[] = "delete";
				$val -= 1;
			}

			if ($val !== 0){
				throw new \Exception("Unknow operation for WebHook - code $val");
			}

			return $arr; 
		});
	}	
	
}

