<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sys_param".
 *
 * @property string $name
 * @property int $tupe
 * @property int|null $vall_int
 * @property string|null $vall_char
 * @property string $deskription
 */
class SysParam extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sys_param';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'tupe', 'deskription'], 'required'],
            [['tupe', 'vall_int'], 'integer'],
            [['name', 'vall_char', 'deskription'], 'string', 'max' => 250],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'tupe' => Yii::t('app', 'Tupe'),
            'vall_int' => Yii::t('app', 'Vall Int'),
            'vall_char' => Yii::t('app', 'Vall Char'),
            'deskription' => Yii::t('app', 'Deskription'),
        ];
    }

   static public function GetParam($param_name){
        $par_temp=SysParam::findOne(['name'=>$param_name]);

        if($par_temp){
            switch ($par_temp->tupe){
                case 0:
                    $par_temp=$par_temp->vall_int;
                break;
                case 1:
                    $par_temp=$par_temp->vall_char;
                break;
            }
        }else{
            $par_temp='This parametr does not exist';
        }
        return $par_temp;
    }
    static public function SetParam($param_name, $value){
        
        $par_temp=SysParam::findOne(['name'=>$param_name]);

        if($par_temp){
            switch ($par_temp->tupe){
                case 0:
                    $par_temp->vall_int=$value;
                break;
                case 1:
                    $par_temp->vall_char=$value;
                break;
            }
            $par_temp->save(false);

            $par_return=true;
        }else{
            $par_return='This parametr does not exist';
        }
        return $par_return;
    }
}
