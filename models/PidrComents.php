<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pidr_coments".
 *
 * @property int $id
 * @property int $id_obj
 * @property int $date_create
 * @property int $id_creator
 * @property string $coment
 */
class PidrComents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pidr_coments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_obj', 'date_create', 'id_creator', 'coment'], 'required'],
            [['id_obj', 'date_create', 'id_creator'], 'integer'],
            [['coment'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_obj' => Yii::t('app', 'Id Obj'),
            'date_create' => Yii::t('app', 'Date Create'),
            'id_creator' => Yii::t('app', 'Id Creator'),
            'coment' => Yii::t('app', 'Coment'),
        ];
    }
}
