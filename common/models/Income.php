<?php

namespace common\models;

use common\models\activeQueries\IncomeQuery;
use Yii;

/**
 * This is the model class for table "income".
 *
 * @property int $id
 * @property string $date_time
 * @property string|null $comment
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $creator_id
 * @property int|null $modifier_id
 * @property int $excavator_id
 * @property int $truck_id
 *
 * @property User $creator
 * @property IncomeProductLink[] $incomeProductLinks
 * @property User $modifier
 * @property Technic $excavator
 * @property Technic $truck
 * @property int $totalSum
 */
class Income extends BaseActiveRecord
{

    public $sum;

    public static function tableName()
    {
        return 'income';
    }

    public function rules()
    {
        return [
            [['date_time', 'status'], 'required'],
            [['date_time', 'created_at', 'updated_at'], 'safe'],
            [['status', 'creator_id', 'modifier_id', 'excavator_id', 'truck_id'], 'integer'],
            [['comment'], 'string', 'max' => 255],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_CANCELLED, self::STATUS_DRAFT]],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['creator_id' => 'id']],
            [['modifier_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['modifier_id' => 'id']],
            [['excavator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Technic::class, 'targetAttribute' => ['excavator_id' => 'id']],
            [['truck_id'], 'exist', 'skipOnError' => true, 'targetClass' => Technic::class, 'targetAttribute' => ['truck_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('app', 'ID'),
            'date_time' => Yii::t('app', 'Кирим вақти'),
            'sum' => Yii::t('app', 'Жами нархи'),
            'excavator_id' => Yii::t('app', 'Экскаватор'),
            'truck_id' => Yii::t('app', 'Юк машинаси'),
        ]);
    }

    public function beforeSave($insert)
    {
        if ($this->date_time)
            $this->date_time = date('Y-m-d H:i:s', strtotime($this->date_time));

        return parent::beforeSave($insert);
    }

    public function getIncomeProductLinks()
    {
        return $this->hasMany(IncomeProductLink::class, ['income_id' => 'id']);
    }

    public function getExcavator()
    {
        return $this->hasOne(Technic::class, ['id' => 'excavator_id']);
    }

    public function getTruck()
    {
        return $this->hasOne(Technic::class, ['id' => 'truck_id']);
    }

    public static function find()
    {
        return new IncomeQuery(get_called_class());
    }

    public static function getStatusListButtons($id, $route)
    {
        $menu = [];
        foreach (self::statusList() as $status => $label) {
            $menu[] = ['label' => $label, 'url' => ['/income/set-status', 'route' => $route, 'status' => $status, 'id' => $id], 'linkOptions' => ['class' => 'btn btn-default']];
        }
        return $menu;
    }


    public function getTotalSum()
    {
        return @IncomeProductLink::find()
            ->select([
                'total_sum' => 'SUM(price * amount)'
            ])
            ->where(['income_id' => $this->id])
            ->asArray()
            ->column()[0];
    }
}
