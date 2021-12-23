<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "expense_type".
 *
 * @property int $id
 * @property string $title
 * @property int $order
 * @property string|null $comment
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $creator_id
 * @property int|null $modifier_id
 *
 * @property User $creator
 * @property Expense[] $expenses
 * @property User $modifier
 */
class ExpenseType extends BaseActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'expense_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['order', 'status', 'creator_id', 'modifier_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'comment'], 'string', 'max' => 255],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
            [['modifier_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['modifier_id' => 'id']],
        ];
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
     * Gets query for [[Expenses]].
     *
     * @return \yii\db\ActiveQuery|\common\models\activeQueries\ExpenseQuery
     */
    public function getExpenses()
    {
        return $this->hasMany(Expense::className(), ['expense_type_id' => 'id']);
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
     * @return \common\models\activeQueries\ExpenseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\activeQueries\ExpenseQuery(get_called_class());
    }
}
