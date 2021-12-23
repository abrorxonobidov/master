<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "income_product_link".
 *
 * @property int $id
 * @property int $income_id
 * @property int $product_id
 * @property int $amount
 * @property int $price
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $creator_id
 * @property int|null $modifier_id
 *
 * @property User $creator
 * @property Income $income
 * @property User $modifier
 * @property Product $product
 */
class IncomeProductLink extends BaseActiveRecord
{
    public $total_price;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'income_product_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'amount', 'price'], 'required'],
            [['income_id', 'product_id', 'amount', 'price', 'status', 'creator_id', 'modifier_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_CANCELLED, self::STATUS_DRAFT]],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
            [['income_id'], 'exist', 'skipOnError' => true, 'targetClass' => Income::className(), 'targetAttribute' => ['income_id' => 'id']],
            [['modifier_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['modifier_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),[
            'id' => Yii::t('app', 'ID'),
            'income_id' => Yii::t('app', 'Кирим ИД рақами'),
            'product.title' => Yii::t('app', 'Маҳсулот'),
            'product_id' => Yii::t('app', 'Маҳсулот'),
            'amount' => Yii::t('app', 'Миқдори'),
            'price' => Yii::t('app', 'Сотиб олинган нархи'),
            'total_price' => Yii::t('app', 'Сумма'),
        ]);
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
     * Gets query for [[Income]].
     *
     * @return \yii\db\ActiveQuery|\common\models\activeQueries\IncomeQuery
     */
    public function getIncome()
    {
        return $this->hasOne(Income::className(), ['id' => 'income_id']);
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
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery|\common\models\activeQueries\ProductQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\activeQueries\IncomeProductLinkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\activeQueries\IncomeProductLinkQuery(get_called_class());
    }
}
