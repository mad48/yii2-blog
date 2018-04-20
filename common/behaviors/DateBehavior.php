<?php


namespace common\behaviors;


use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class DateBehavior extends Behavior
{
    public $createdDate = 'created_at';
    public $updatedDate = 'updated_at';


    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'before',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'before',
        ];
    }

    public function before()
    {
        $this->owner->{$this->updatedDate} = date('Y-m-d H:i:s');//new Expression('NOW()');

        if (!empty($this->owner->{$this->createdDate})) {
            $this->owner->{$this->createdDate} = date('Y-m-d H:i:s', strtotime($this->owner->{$this->createdDate}));
        }
        /*        if (empty($this->owner[$this->createdDate])) {
                    $this->owner[$this->createdDate] = $this->owner[$this->updatedDate];
                } else {
                    $this->owner[$this->createdDate] = date('Y-m-d H:i:s', strtotime($this->owner[$this->createdDate]));
                }*/
    }

}