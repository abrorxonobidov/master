<?php

namespace common\models;

use common\models\activeQueries\ClientQuery;
use kartik\icons\Icon;
use Yii;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string|null $car_number
 * @property string|null $car_model
 * @property string|null $address
 * @property string|null $image
 * @property string|null $comment
 * @property int $order
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $creator_id
 * @property int|null $modifier_id
 *
 * @property User $creator
 * @property User $modifier
 * @property Payment[] $payments
 * @property Sale[] $sales
 */
class Client extends BaseActiveRecord
{

    public static function tableName()
    {
        return 'client';
    }


    public function rules()
    {
        return [
            [['name', 'phone'], 'required'],
            [['order', 'status', 'creator_id', 'modifier_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'phone', 'address', 'image', 'comment'], 'string', 'max' => 255],
            [['car_number', 'car_model'], 'string', 'max' => 20],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['creator_id' => 'id']],
            [['modifier_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['modifier_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'ф.И.О.'),
            'phone' => Yii::t('app', 'Телефон рақами'),
            'car_number' => Yii::t('app', 'Машина рақами'),
            'car_model' => Yii::t('app', 'Машина модели'),
            'address' => Yii::t('app', 'Манзил'),
            'image' => Yii::t('app', 'Расм'),
        ]);
    }


    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'creator_id']);
    }


    public function getModifier()
    {
        return $this->hasOne(User::class, ['id' => 'modifier_id']);
    }


    public function getPayments()
    {
        return $this->hasMany(Payment::class, ['client_id' => 'id']);
    }


    public function getSales()
    {
        return $this->hasMany(Sale::class, ['client_id' => 'id']);
    }


    public static function find()
    {
        return new ClientQuery(get_called_class());
    }


    public function getPersonInfo()
    {
        return "<b>$this->name</b><br>"
            . Icon::show('phone', ['class' => 'fa']) . " $this->phone <br>"
            . Icon::show('home', ['class' => 'fa']) . " $this->address";
    }


    public function getCarInfo()
    {
        $info = '';
        if ($this->car_model)
            $info .= $this->car_model;
        if ($this->car_number)
            $info .= '<br>' . $this->car_number;
        return $info;
    }
}
