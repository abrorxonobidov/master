<?php
/**
 * Created by PhpStorm.
 * User: Abrorxon Obidov
 * Date: 11.05.2021
 * Time: 10:00
 */

namespace common\behaviors;


use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * @property string $creatorIdAttribute
 * @property string $modifierIdAttribute
 * @property string $createdAtAttribute
 * @property string $updatedAtAttribute
 * @property boolean $timestamp
 * @property ActiveRecord $owner
 */
class CommonTimestampBehavior extends TimestampBehavior
{
    public $creatorIdAttribute = 'creator_id';

    public $modifierIdAttribute = 'modifier_id';

    public $timestamp = true;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
        ];
    }

    public function beforeValidate($event)
    {
        $owner = $this->owner;
        $p = strpos($owner::className(), 'Search');
        if ($p !== false)
            return;

        if ($this->owner->isNewRecord) {
            $this->owner[$this->createdAtAttribute] = $this->getValue($event);
            $this->setUserId($this->creatorIdAttribute);
        } else {
            $this->owner[$this->updatedAtAttribute] = $this->getValue($event);
            $this->setUserId($this->modifierIdAttribute);
        }

    }

    protected function getValue($event)
    {
        $value = parent::getValue($event);

        if ($this->timestamp)
            $value = date('Y-m-d H:i:s', $value);

        return $value;
    }

    protected function setUserId($attribute)
    {
        if ($this->owner->hasAttribute($attribute))
            $this->owner[$attribute] = Yii::$app->user->id;
    }
}