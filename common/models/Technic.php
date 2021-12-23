<?php

namespace common\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "technic".
 *
 * @property int $id
 * @property int $type_id 1 Kamaz yuk tashuvchi 2 Ekskavator 3 yana qo'shilishi mumkin
 * @property string $name
 * @property string $phone
 * @property string|null $model
 * @property string|null $number
 * @property string|null $driver_name
 * @property string|null $image
 * @property string|null $comment
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $creator_id
 * @property int|null $modifier_id
 *
 * @property User $creator
 * @property User $modifier
 */
class Technic extends BaseActiveRecord
{
    const TYPE_TRUCK = 1;
    const TYPE_EXCAVATOR = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'technic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id', 'status', 'creator_id', 'modifier_id'], 'integer'],
            [['name', 'phone'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            ['type_id', 'in', 'range' => [self::TYPE_EXCAVATOR, self::TYPE_TRUCK]],
            [['name', 'phone', 'model', 'number', 'driver_name', 'image', 'comment'], 'string', 'max' => 255],
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
            'type_id' => Yii::t('app', 'Техника тури'),
            'name' => Yii::t('app', 'Техника номи'),
            'phone' => Yii::t('app', 'Телефон рақами'),
            'model' => Yii::t('app', 'Модели'),
            'number' => Yii::t('app', 'Рақами'),
            'driver_name' => Yii::t('app', 'Ҳайдовчи'),
            'image' => Yii::t('app', 'Расми'),
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
     * {@inheritdoc}
     * @return \common\models\activeQueries\TechnicQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\activeQueries\TechnicQuery(get_called_class());
    }

    public static function getTypeList()
    {
        return [
            self::TYPE_TRUCK => 'Юк ташувчи',
            self::TYPE_EXCAVATOR => 'Экскаватор',
        ];
    }

    public function getTypeName()
    {
        return @self::getTypeList()[$this->type_id];
    }

    public function getTitle()
    {
        $title = $this->name;
        if ($this->model)
            $title .= '<br>' . $this->model;
        if ($this->number)
            $title .= '<br>' . $this->number;
        return $title;
    }

    public function getDriverInfo()
    {
        $title = $this->phone;
        if ($this->driver_name)
            $title = $this->driver_name.'<br>'.$title ;
        return $title;
    }

    public static function getList($titleField = null, $condition = "", $conditionParams = [])
    {
        $listQuery = self::find()
            ->select([
                'id',
                'title' => new Expression("CONCAT(name,' ( ',number,')')")
            ])
            ->where(['status' => 1])
            ->asArray();
        if (!empty($condition)) {
            if (is_array($condition))
                $listQuery->andWhere($condition);
            else $listQuery->andWhere($condition, $conditionParams);
        }
        $list = $listQuery->all();
        $out = [];
        foreach ($list as $item)
            $out[$item['id']] = $item['title'];
        return $out;
    }
}
