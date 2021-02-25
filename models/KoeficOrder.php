<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "koefic_order".
 *
 * @property int $id
 * @property float $value
 * @property int $id_obl
 * @property int $id_creator
 * @property int $date_create
 */
class KoeficOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'koefic_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'value', 'id_obl', 'id_creator', 'date_create'], 'required'],
            [['id', 'id_obl', 'id_creator', 'date_create'], 'integer'],
            [['value'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'value' => Yii::t('app', 'Коефіціент'),
            'id_obl' => Yii::t('app', 'Обленерго'),
            'id_creator' => Yii::t('app', 'Хто задав'),
            'date_create' => Yii::t('app', 'Дата Створення'),
        ];
    }
}
