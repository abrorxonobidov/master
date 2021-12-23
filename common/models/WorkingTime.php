<?php

namespace common\models;

use common\helpers\DebugHelper;
use Yii;

/**
 * This is the model class for table "working_time".
 *
 * @property int $id
 * @property string|null $begin_time
 * @property string|null $end_time
 * @property string|null $begin_comment
 * @property string|null $end_comment
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $creator_id
 * @property int|null $modifier_id
 *
 * @property User $creator
 * @property User $modifier
 */
class WorkingTime extends BaseActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'working_time';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['begin_time', 'end_time', 'created_at', 'updated_at'], 'safe'],
            [['begin_comment', 'end_comment'], 'string'],
            [['status', 'creator_id', 'modifier_id'], 'integer'],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
            [['modifier_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['modifier_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('app', 'ID'),
            'begin_time' => Yii::t('app', 'Иш бошланиш вақти'),
            'end_time' => Yii::t('app', 'Иш тугашвақти'),
            'begin_comment' => Yii::t('app', 'Иш бошланиш вақтига изоҳ'),
            'end_comment' => Yii::t('app', 'Иш тугаш вақтига изоҳ'),
        ]);
    }

    public function beforeSave($insert)
    {
        if ($this->begin_time)
            $this->begin_time = date('Y-m-d H:i:s', strtotime($this->begin_time));

        if ($this->end_time)
            $this->end_time = date('Y-m-d H:i:s', strtotime($this->end_time));

        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[Creator]].
     *
     * @return \yii\db\ActiveQuery|\common\models\activeQueries\UserQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }

    /**
     * Gets query for [[Modifier]].
     *
     * @return \yii\db\ActiveQuery|\common\models\activeQueries\UserQuery
     */
    public function getModifier()
    {
        return $this->hasOne(User::className(), ['id' => 'modifier_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\activeQueries\WorkingTimeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\activeQueries\WorkingTimeQuery(get_called_class());
    }
}
