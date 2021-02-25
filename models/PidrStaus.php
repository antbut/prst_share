<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pidr_staus".
 *
 * @property int $id
 * @property string $title
 * @property string $url
 */
class PidrStaus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pidr_staus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'title', 'url'], 'required'],
            [['id'], 'integer'],
            [['url'], 'string'],
            [['title'], 'string', 'max' => 250],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'url' => Yii::t('app', 'Url'),
        ];
    }
}
