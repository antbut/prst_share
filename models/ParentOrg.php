<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "parent_org".
 *
 * @property int $id_pidr
 * @property int $id_obl
 */
class ParentOrg extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parent_org';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pidr', 'id_obl'], 'required'],
            [['id_pidr', 'id_obl'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pidr' => Yii::t('app', 'Id Pidr'),
            'id_obl' => Yii::t('app', 'Id Obl'),
        ];
    }

    static public  function GetCostemerObl($id_obl){        // найти подрядчиков обла
        $obls=ParentOrg::find()->where(['id_obl'=>$id_obl])->all();
        $data = ArrayHelper::toArray($obls,['app\models\ParentOrg'=>['id_pidr']]);
        $data=ArrayHelper::getColumn($data, 'id_pidr');
        return $data;
    }

    static public  function GetOblPidr($id_pidr){

        $obls=ParentOrg::find()->where(['id_pidr'=>$id_pidr])->all();
        
      //  $data=$obls;
        $data = ArrayHelper::toArray($obls,['app\models\ParentOrg'=>['id_obl']]);
        $data=ArrayHelper::getColumn($data, 'id_obl');
        return $data;
    }
}
