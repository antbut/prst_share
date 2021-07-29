<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "objekt_log".
 *
 * @property int $id
 * @property int $date
 * @property int $id_user
 * @property int $id_objekt
 * @property int $id_obl
 * @property string $changet_colum
 * @property int $coment
 */
class ObjektLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'objekt_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'date', 'id_user', 'id_objekt', 'id_obl', 'changet_colum', 'coment'], 'required'],
            [['id', 'date', 'id_user', 'id_objekt', 'id_obl', 'coment'], 'integer'],
            [['changet_colum'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'id_user' => 'Id User',
            'id_objekt' => 'Id Objekt',
            'id_obl' => 'Id Obl',
            'changet_colum' => 'Changet Colum',
            'coment' => 'Coment',
        ];
    }
}
