<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "distrikt_pidr".
 *
 * @property int $id
 * @property string $title
 * @property int $id_pidr
 * @property int $id_obl
 */
class DistriktPidr extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'distrikt_pidr';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'id_pidr', 'id_obl'], 'required'],
            [['title'], 'string'],
            [['id_pidr', 'id_obl'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Район',
            'id_pidr' => 'Підрядник',
            'id_obl' => 'Обленерго',
        ];
    }
}
