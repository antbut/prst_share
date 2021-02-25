<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "objekt_status".
 *
 * @property int $id
 * @property string $title
 * @property string $icon_url
 */
class ObjektStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'objekt_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'title', 'icon_url'], 'required'],
            [['id'], 'integer'],
            [['icon_url'], 'string'],
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
            'icon_url' => Yii::t('app', 'Icon Url'),
        ];
    }
}
