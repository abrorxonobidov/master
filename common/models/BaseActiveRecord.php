<?php
/**
 * Created by PhpStorm.
 * User: Abrorxon Obidov
 * Date: 27/07/2021
 * Time: 15:33:00
 */

namespace common\models;

use common\behaviors\CommonTimestampBehavior;
use common\helpers\DebugHelper;
use frontend\helpers\StringHelper;
use Yii;
use yii\bootstrap\Html;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * @property integer $id
 * @property integer $status
 * @property string $comment
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 * @property integer $creator_id
 * @property integer $modifier_id
 *
 *
 * @property string $image_file
 *
 * @property User $creator
 * @property User $modifier
 * @property string $statusColor
 * @property string $statusNameIcon
 * @property string $statusTitle
 * @property string $currency
 */
class BaseActiveRecord extends ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 2;
    const STATUS_CANCELLED = 3;
    const STATUS_DISABLED = 0;

    public $image_file;
    public $date_from;
    public $date_to;
    public $currency = 'сўм';

    public function behaviors()
    {
        return [
            [
                'class' => CommonTimestampBehavior::class
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Номланиши'),
            'status' => Yii::t('app', 'Статуси'),
            'statusTitle' => Yii::t('app', 'Статуси'),
            'created_at' => Yii::t('app', 'Яратилган сана'),
            'updated_at' => Yii::t('app', 'Таҳрирланган сана'),
            'creator_id' => Yii::t('app', 'Муаллиф') . ' ID',
            'modifier_id' => Yii::t('app', 'Таҳрирловчи') . ' ID',
            'creator.full_name' => Yii::t('app', 'Муаллиф'),
            'modifier.full_name' => Yii::t('app', 'Таҳрирловчи'),
            'comment' => Yii::t('app', 'Изоҳ'),
            'order' => Yii::t('app', 'Тартиб рақами'),
            'image_file' => Yii::t('app', 'Расм'),
            'currency' => Yii::t('app', ''),
        ];
    }

    public function loadDefaultValues($skipIfSet = true)
    {
        foreach (static::getTableSchema()->columns as $column) {
            if ($column->defaultValue !== null && (!$skipIfSet || $this->{$column->name} === null)) {
                if (strtoupper($column->defaultValue) === 'CURRENT_TIMESTAMP')
                    $column->defaultValue = date('Y-m-d H:i:s');
                $this->{$column->name} = $column->defaultValue;
            }
        }

        return $this;
    }

    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'creator_id']);
    }

    public function getModifier()
    {
        return $this->hasOne(User::class, ['id' => 'modifier_id']);
    }


    public function createGuid()
    {
        $guid = '';
        $uid = uniqid("", true);
        $data = $_SERVER['REQUEST_TIME'];
        $data .= $_SERVER['HTTP_USER_AGENT'];
        $hash = hash('ripemd128', $uid . $guid . md5($data));
        $guid = substr($hash, 0, 8) .
            '-' . substr($hash, 8, 4) .
            '-' . substr($hash, 12, 4) .
            '-' . substr($hash, 16, 4) .
            '-' . substr($hash, 20, 12);
        return $guid;
    }


    public static function getList($titleField = null, $condition = "", $conditionParams = [])
    {
        if ($titleField === null)
            $titleField = 'title';
        $listQuery = self::find()
            ->select([
                'id',
                'title' => $titleField
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

    public static function selectText()
    {
        return Yii::t('app', 'Танланг') . ' ...';
    }

    public static function uploadImagePath()
    {
        return Yii::$app->params['imageUploadPath'];
    }

    public static function imageSourcePath()
    {
        return 'http://' . Yii::$app->params['domainName'] . '/uploads/';
    }


    public function uploadImage($fileInput, $field, $table = '')
    {
        $image = UploadedFile::getInstance($this, $fileInput);
        if ($image) {
            if (!$this->isNewRecord) {
                if (!empty($this->$field)) {
                    $oldImage = $this->uploadImagePath() . $this->$field;
                    if (file_exists($oldImage)) {
                        unlink($oldImage);
                    }
                }
            }

            $imageName = $table . '_' . $this->id . '_' . $this->createGuid() . '.' . $image->getExtension();
            $this->$field = $imageName;
            $this->updateAttributes([$field]);
            $imagePath = $this->uploadImagePath() . $imageName;

            if (!$image->saveAs($imagePath))
                DebugHelper::printSingleObject($image->error, 1);
        }
    }

    public function inputImageConfig($field, $deleteUrl)
    {
        $config = ['path' => [], 'config' => []];
        if (!$this->isNewRecord && !empty($this->$field)) {
            $image = $this->$field;
            $file = $this->uploadImagePath() . $image;
            if (file_exists($file)) {
                $config['path'] = ['http://' . Yii::$app->params['domainName'] . '/uploads/' . $this->$field];
                $config['config'] = [
                    [
                        'caption' => $image,
                        'size' => filesize($file),
                        'url' => Url::to([$deleteUrl]),
                        'key' => $this->$field,
                        'extra' => [
                            'id' => $this->id,
                            'field' => $field,
                            'className' => get_called_class()
                        ],
                    ]
                ];
            }
        }
        return $config;
    }

    public function loadDefaultSearchParams(&$params)
    {
        if (empty($params)) {
            $params['date_from'] = date('Y-m-01');
            if ($this->hasProperty('date_from'))
                $this->date_from = date('Y-m-01');
            $params['date_to'] = date('Y-m-d');
            if ($this->hasProperty('date_to'))
                $this->date_to = date('Y-m-d');
        }
    }

    public static function statusList()
    {
        return [
            self::STATUS_ACTIVE => "Актив",
            self::STATUS_DRAFT => "Қоралама",
            self::STATUS_CANCELLED => "Бекор қилинган"
        ];
    }

    public static function statusListIcon()
    {
        return [
            self::STATUS_ACTIVE => StringHelper::iconFa('check-circle'),
            self::STATUS_DRAFT => StringHelper::iconFa('file-o'),
            self::STATUS_CANCELLED => StringHelper::iconFa('remove'),
        ];
    }

    public function getStatusName()
    {
        return @self::statusList()[$this->status];
    }

    public function getStatusNameIcon()
    {
        return @self::statusListIcon()[$this->status];
    }

    public static function statusColorList()
    {
        return [self::STATUS_ACTIVE => "success", self::STATUS_DRAFT => "black", self::STATUS_CANCELLED => "danger",];
    }

    public function getStatusColor()
    {
        return @self::statusColorList()[$this->status];
    }

    public function getStatusTitle()
    {
        return Html::tag('span', $this->statusNameIcon, ['class' => 'text-' . $this->statusColor, 'title' => $this->getStatusName()]);
    }
}