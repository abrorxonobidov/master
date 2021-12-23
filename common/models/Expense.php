<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "expense".
 *
 * @property int $id
 * @property int $expense_type_id
 * @property string $date_time
 * @property int $price Сўмда
 * @property string|null $comment
 * @property int $order
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $creator_id
 * @property int|null $modifier_id
 *
 * @property User $creator
 * @property ExpenseType $expenseType
 * @property User $modifier
 */
class Expense extends BaseActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'expense';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['expense_type_id', 'price', 'status'], 'required'],
            [['expense_type_id', 'price', 'order', 'status', 'creator_id', 'modifier_id'], 'integer'],
            [['date_time', 'created_at', 'updated_at'], 'safe'],
//            ['date_time', 'default', 'value' => date('Y-m-d H:i:s')],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_CANCELLED, self::STATUS_DRAFT]],
            [['comment'], 'string', 'max' => 255],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
            [['expense_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ExpenseType::className(), 'targetAttribute' => ['expense_type_id' => 'id']],
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
            'expense_type_id' => Yii::t('app', 'Ҳаражат тури'),
            'date_time' => Yii::t('app', 'Ҳарж қилинган сана'),
            'price' => Yii::t('app', 'Ҳарж миқдори'),
        ]);
    }

    public function beforeSave($insert)
    {
        if ($this->date_time)
            $this->date_time = date('Y-m-d H:i:s', strtotime($this->date_time));

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
     * Gets query for [[ExpenseType]].
     *
     * @return \yii\db\ActiveQuery|\common\models\activeQueries\ExpenseTypeQuery
     */
    public function getExpenseType()
    {
        return $this->hasOne(ExpenseType::className(), ['id' => 'expense_type_id']);
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

    public static function statusList()
    {
        return [self::STATUS_ACTIVE => "Актив", self::STATUS_DRAFT => "Қоралама", self::STATUS_CANCELLED => "Бекор қилинган",];
    }

    public function getStatusName()
    {
        return @self::statusList()[$this->status];
    }

    public static function statusColorList()
    {
        return [self::STATUS_ACTIVE => "success", self::STATUS_DRAFT => "black", self::STATUS_CANCELLED => "danger",];
    }

    public function getStatusColor()
    {
        return @self::statusColorList()[$this->status];
    }

    public static function getStatusListButtons($id, $route)
    {
        $menu = [];
        foreach (self::statusList() as $status => $label) {
            $menu[] = ['label' => $label, 'url' => ['/expense/set-status', 'route' => $route, 'status' => $status, 'id' => $id], 'linkOptions' => ['class' => 'btn btn-default']];
        }
        return $menu;
    }
}
