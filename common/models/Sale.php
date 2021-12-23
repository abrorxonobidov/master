<?php

namespace common\models;

use common\models\activeQueries\SaleQuery;
use Yii;

/**
 * This is the model class for table "sale".
 *
 * @property int $id
 * @property int $client_id
 * @property string $date_time
 * @property string $comment
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $creator_id
 * @property int|null $modifier_id
 *
 * @property string $statusColor
 * @property Client $client
 * @property User $creator
 * @property User $modifier
 * @property Payment[] $payments
 * @property Payment $payment
 * @property SaleProductLink[] $saleProductLinks
 * @property int $totalSum
 */
class Sale extends BaseActiveRecord
{

    public $sum;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'status',], 'required'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['client_id', 'creator_id', 'modifier_id'], 'integer'],
            [['date_time', 'created_at', 'updated_at'], 'safe'],
            [['comment'], 'string', 'max' => 255],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_CANCELLED, self::STATUS_DRAFT]],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['creator_id' => 'id']],
            [['modifier_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['modifier_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('app', 'ID'),
            'client_id' => Yii::t('app', 'Мижоз'),
            'sum' => Yii::t('app', 'Жами нархи'),
            'date_time' => Yii::t('app', 'Сотилган сана'),
        ]);
    }

    public function beforeSave($insert)
    {
        if ($this->date_time)
            $this->date_time = date('Y-m-d H:i:s', strtotime($this->date_time));

        return parent::beforeSave($insert);
    }

    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    public function getPayments()
    {
        return $this->hasMany(Payment::class, ['sale_id' => 'id']);
    }

    public function getPayment()
    {
        return $this->hasOne(Payment::class, ['sale_id' => 'id']);
    }

    public function getSaleProductLinks()
    {
        return $this->hasMany(SaleProductLink::class, ['sale_id' => 'id']);
    }

    public static function find()
    {
        return new SaleQuery(get_called_class());
    }

    public static function getStatusListButtons($id, $route)
    {
        $menu = [];
        foreach (self::statusList() as $status => $label) {
            $menu[] = [
                'label' => $label,
                'url' => ['/sale/set-status',
                    'route' => $route,
                    'status' => $status,
                    'id' => $id],
                'linkOptions' => [
                    'class' => 'btn btn-default'
                ]
            ];
        }
        return $menu;
    }

    public function getTotalSum()
    {
        return @SaleProductLink::find()
            ->select([
                'total_sum' => 'SUM(price * amount)'
            ])
            ->where(['sale_id' => $this->id])
            ->asArray()
            ->column()[0];
    }
}
