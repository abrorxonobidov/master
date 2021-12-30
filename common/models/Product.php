<?php

namespace common\models;

use common\models\activeQueries\ProductQuery;
use Yii;
use yii\db\Expression;
use yii\db\Query;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $unit_id
 * @property string $title
 * @property int $income_price Сотиб олиш нархи
 * @property int $price Сотиш нархи
 * @property string|null $image
 * @property string|null $comment
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $creator_id
 * @property int|null $modifier_id
 *
 * @property User $creator
 * @property IncomeProductLink[] $incomeProductLinks
 * @property User $modifier
 * @property SaleProductLink[] $saleProductLinks
 * @property Unit $unit
 * @property int $quantity
 * @property string $quantityWithUnit
 */
class Product extends BaseActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_id', 'title', 'income_price', 'price'], 'required'],
            [['unit_id', 'income_price', 'price', 'status', 'creator_id', 'modifier_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'image', 'comment'], 'string', 'max' => 255],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['creator_id' => 'id']],
            [['modifier_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['modifier_id' => 'id']],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::class, 'targetAttribute' => ['unit_id' => 'id']],
            [['title'],
                'match',
                'not' => true,
                'pattern' => '/\(|\)|\//i',
                'message' => 'Рухсат берилмаган белги киритилган'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('app', 'ID'),
            'unit_id' => Yii::t('app', 'Ўлчов бирлиги'),
            'unit.title' => Yii::t('app', 'Ўлчов бирлиги'),
            'income_price' => Yii::t('app', 'Сотиб олиш нархи'),
            'price' => Yii::t('app', 'Сотиш нархи'),
            'image' => Yii::t('app', 'Маҳсулот расми'),
            'quantity' => Yii::t('app', 'Қолдиқ'),
            'quantityWithUnit' => Yii::t('app', 'Қолдиқ'),
        ]);
    }

    /**
     * Gets query for [[Creator]].
     *
     * @return yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'creator_id']);
    }

    /**
     * Gets query for [[IncomeProductLinks]].
     *
     * @return yii\db\ActiveQuery
     */
    public function getIncomeProductLinks()
    {
        return $this->hasMany(IncomeProductLink::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Modifier]].
     *
     * @return yii\db\ActiveQuery
     */
    public function getModifier()
    {
        return $this->hasOne(User::class, ['id' => 'modifier_id']);
    }

    /**
     * Gets query for [[SaleProductLinks]].
     *
     * @return yii\db\ActiveQuery
     */
    public function getSaleProductLinks()
    {
        return $this->hasMany(SaleProductLink::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Unit]].
     *
     * @return yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::class, ['id' => 'unit_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }


    /**
     * @param null $titleField
     * @param string $condition
     * @param array $conditionParams
     * @return array
     */
    public static function getList($titleField = null, $condition = "", $conditionParams = [])
    {
        $listQuery = self::find()
            ->select([
                'id',
                'title',
            ])
            ->where(['status' => 1])
            ->asArray();
        if ($titleField !== null)
            $listQuery->select([
                'id',
                'title' => new Expression("CONCAT(title,' ('," . $titleField . ",')')"),
            ]);
        if ($condition) {
            if (is_array($condition))
                $listQuery->andWhere($condition);
            else
                $listQuery->andWhere($condition, $conditionParams);
        }
        $list = $listQuery->all();
        $out = [];
        foreach ($list as $item)
            $out[$item['id']] = $item['title'];
        return $out;
    }

    /**
     * @param null $titleField
     * @return array
     */
    public static function getListWithUnit($titleField)
    {
        $list = self::find()
            ->alias('p')
            ->select([
                'p.id',
                'title' => new Expression("CONCAT(p.title,' (', p.$titleField, '/', u.title, ')')"),
            ])
            ->leftJoin(['u' => Unit::tableName()], 'u.id = p.unit_id')
            ->where(['p.status' => 1])
            ->asArray()
            ->all();
        $out = [];
        foreach ($list as $item)
            $out[$item['id']] = $item['title'];
        return $out;
    }

    public function getQuantity()
    {
        $income = IncomeProductLink::find()
            ->select([
                'income' => 'SUM(amount)',
                'sale' => 'SUM(0)'
            ])
            ->where([
                'product_id' => $this->id,
                'status' => self::STATUS_ACTIVE
            ]);

        $sale = SaleProductLink::find()
            ->select([
                'income' => 'SUM(0)',
                'sale' => 'SUM(amount)',
            ])
            ->where([
                'product_id' => $this->id,
                'status' => self::STATUS_ACTIVE
            ]);

        $res = (new Query())
            ->from($income)
            ->union($sale);

        return @(new Query())
            ->select('SUM(income) - SUM(sale)')
            ->from($res)
            ->column()[0];

    }

    public function getQuantityWithUnit()
    {
        return Yii::$app->formatter->asDecimal($this->quantity) . ' ' . @$this->unit->title;
    }
}
