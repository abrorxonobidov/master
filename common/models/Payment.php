<?php

namespace common\models;

use common\models\activeQueries\PaymentQuery;
use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property int $id
 * @property int $client_id
 * @property int $pay_type_id
 * @property int|null $sale_id
 * @property int $price
 * @property string $date_time
 * @property string|null $comment
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $creator_id
 * @property int|null $modifier_id
 *
 * @property Client $client
 * @property User $creator
 * @property User $modifier
 * @property PayType $payType
 * @property Sale $sale
 */
class Payment extends BaseActiveRecord
{




    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'price', 'pay_type_id'], 'required'],
            [['client_id', 'pay_type_id', 'sale_id', /*'price',*/ 'status', 'creator_id', 'modifier_id'], 'integer'],
            [['price'], 'default', 'value' => 0],
            [['date_time', 'created_at', 'updated_at'], 'safe'],
            [['comment'], 'string', 'max' => 255],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_CANCELLED, self::STATUS_DRAFT]],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['creator_id' => 'id']],
            [['modifier_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['modifier_id' => 'id']],
            [['pay_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PayType::class, 'targetAttribute' => ['pay_type_id' => 'id']],
            [['sale_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sale::class, 'targetAttribute' => ['sale_id' => 'id']],
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
            'pay_type_id' => Yii::t('app', 'Тўлов тури'),
            'sale_id' => Yii::t('app', 'Сотув ИД рақами'),
            'price' => Yii::t('app', 'Тўланган пул миқдори'),
            'date_time' => Yii::t('app', 'Тўланган сана'),
            'date_from' => Yii::t('app', 'Тўланган сана (дан)'),
            'date_to' => Yii::t('app', 'Тўланган сана (гача)'),
        ]);
    }

    public function beforeSave($insert)
    {
        if ($this->date_time)
            $this->date_time = date('Y-m-d H:i:s', strtotime($this->date_time));

        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[Client]].
     *
     * @return yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    /**
     * Gets query for [[PayType]].
     *
     * @return yii\db\ActiveQuery
     */
    public function getPayType()
    {
        return $this->hasOne(PayType::class, ['id' => 'pay_type_id']);
    }

    /**
     * Gets query for [[Sale]].
     *
     * @return yii\db\ActiveQuery
     */
    public function getSale()
    {
        return $this->hasOne(Sale::class, ['id' => 'sale_id']);
    }

    /**
     * {@inheritdoc}
     * @return PaymentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PaymentQuery(get_called_class());
    }

    public static function getStatusListButtons($id, $route)
    {
        $menu = [];
        foreach (self::statusList() as $status => $label) {
            $menu[] = [
                'label' => $label,
                'url' => ['/payment/set-status', 'route' => $route, 'status' => $status, 'id' => $id],
                'linkOptions' => ['class' => 'btn btn-default']
            ];
        }
        return $menu;
    }
}
