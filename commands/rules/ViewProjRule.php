<?php
namespace app\rules;
 
use yii\rbac\Rule;
use app\model\User;
use app\model\Main;
use app\model\Organizations;
 
class ViewProjRule extends Rule
{
    public $name = 'isYouProject'; // Имя правила
 
    public function execute($user_id, $item, $params)
    {   
    	if(\Yii::$app->user->can('contractor') ){
            $id_pidr=Main::findOne($params['id_prod'])->pidr;
        } 
    	if($params['id_prod'] == $user_id){
    		return true;
    	}else{
    		return false;
    	}
       
    }
}

?>