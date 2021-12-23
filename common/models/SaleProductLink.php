<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sale_product_link".
 *
 * @property int $id
 * @property int $sale_id
 * @property int $product_id
 * @property int $amount
 * @property int $price
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $creator_id
 * @property int|null $modifier_id
 *
 * @property integer $total_price
 *
 * @property User $creator
 * @property User $modifier
 * @property Product $product
 * @property Sale $sale
 */
class SaleProductLink extends BaseActiveRecord
{
    public $total_price;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale_product_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'amount', 'price'], 'required'],
            [['sale_id', 'product_id', 'amount', 'price', 'status', 'creator_id', 'modifier_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_CANCELLED, self::STATUS_DRAFT]],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
            [['modifier_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['modifier_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['sale_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sale::className(), 'targetAttribute' => ['sale_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),[
            'id' => Yii::t('app', 'ID'),
            'sale_id' => Yii::t('app', 'Сотув ИД рақами'),
            'product_id' => Yii::t('app', 'Маҳсулот'),
            'amount' => Yii::t('app', 'Миқдори'),
            'price' => Yii::t('app', 'Нархи'),
            'status' => Yii::t('app', 'Статуси'),
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
     * Gets query for [[Sale]].
     *
     * @return \yii\db\ActiveQuery|\common\models\activeQueries\SaleQuery
     */
    public function getSale()
    {
        return $this->hasOne(Sale::className(), ['id' => 'sale_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\activeQueries\SaleProductLinkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\activeQueries\SaleProductLinkQuery(get_called_class());
    }
}
