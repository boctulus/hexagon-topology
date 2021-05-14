<?php

namespace boctulus\grained_acl;

use simplerest\libs\DB;
use simplerest\libs\Factory;
use simplerest\libs\Url;

class Acl extends \simplerest\core\Acl
{
    protected $roles = [];
    protected $role_perms = [];
    protected $role_ids   = [];
    protected $role_names = [];
    protected $sp_permissions = []; 
    protected $current_role;
    protected $guest_name = 'guest';


    public function __construct() { 
        $this->config = Factory::config();
        $this->setup();
    }

 
    protected function setup(){        
        $api_key = $this->config['api_key-admin'];

        // get all available sp_permissions
        if ($this->config['api-sp_permissions'] !== null)
        {
            $res = Url::consume_endpoint($this->config['api-sp_permissions'] . '?pageSize=50', 'GET', null, $api_key);
            
            if ($res['status_code'] != 200){
                Factory::response()->sendError("Interal Server error", 500);
            }

            $data = $res['data'];

            $this->sp_permissions = array_column($data, 'name');
        } else {    
            $this->sp_permissions = DB::table('sp_permissions')->pluck('name');
        }

        // get all available roles  
        if ($this->config['api-roles'] !== null)
        {
            $res = Url::consume_endpoint($this->config['api-roles'] . '?pageSize=50', 'GET', null, $api_key);
            
            if ($res['status_code'] != 200){
                Factory::response()->sendError("Interal Server error", 500);
            }

            $data = $res['data'];

            $this->roles = $data;
        } else {
            $this->roles = DB::table('roles')->get();
        }        

        foreach($this->roles as $rr){
            $this->role_names[] = $rr['name'];
            $this->role_ids[]   = $rr['id'];
        }
    }

    public function addRole(string $role_name, $role_id = NULL) {
        $create = true;

        if (in_array($role_id, $this->role_ids)){
            $create = false;

            foreach ($this->roles as $rr){
                if ($rr['id'] == $role_id && $rr['name'] != $role_name){
                    throw new \Exception("Role id '$role_id' can not be repetead. Trying to assign to '$role_name' but it was used for '{$rr['name']}' and it should be UNIQUE.");      
                }
            }
        }

        if (in_array($role_name, $this->role_names)){
            $create = false;
            
            foreach ($this->roles as $rr){
                if ($rr['id'] != $role_id && $rr['name'] == $role_name){
                    if ($role_id != NULL) {
                        throw new \Exception("Role name '$role_name' can not be repetead. Trying to assign to id '$role_id' but it was used for '{$rr['id']}' and it should be UNIQUE.");  
                    }
                       
                }
            }
        }

        if ($role_name == 'guest'){
            $this->guest_name = 'guest';
        }

        if ($create){
            if ($this->config['api-roles']){
                Factory::response()->sendError('Forbidden', 403, 'Roles can not be written from here');
            } else {    
                $role_id = DB::table('roles')->create([
                    'id'   => $role_id,
                    'name' => $role_name
                ]);
            }
        }
        
        $this->role_ids[]   = $role_id;
        $this->role_names[] = $role_name;
        
        $this->role_perms[$role_name] = [
                            'role_id' => $role_id,
                            'sp_permissions' => [],
                            'tb_permissions' => []
        ];

        $this->current_role = $role_name; 

        return $this;
    }

    
    // Not in interfaces neither needed 

    public function hasRole(string $role){
        return in_array($role, $this->roles);
    }

    public function hasAnyRole(array $authorized_roles){
        $authorized = false;
        foreach ((array) $this->roles as $role)
            if (in_array($role, $authorized_roles))
                $authorized = true;

        return $authorized;        
    }

    public function getSpPermissions(){
        return $this->sp_permissions;
    }


}

