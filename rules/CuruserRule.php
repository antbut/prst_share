<?php
namespace app\rules;
 
use yii\rbac\Rule;
 
class CuruserRule extends Rule
{
    public $name = 'isCurentUser'; // Имя правила
 
    public function execute($user_id, $item, $params)
    {
    	if($params['id_user'] == $user_id){
    		return true;
    	}else{
    		return false;
    	}
       
    }
}

?>