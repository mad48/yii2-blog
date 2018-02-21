<?php
namespace common\widgets;

use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

use common\models\Tag;

class TagsWidget extends Widget
{
    public $tags;
    public $selectedTags;


    public function init()
    {
        parent::init();
        ob_start();

    }

    public function run()
    {


        /*foreach ($result as $tag) {
            echo '<span><a href="#">#' . $tag->title . '</a></span>';
        }*/

        echo Html::dropDownList('tags', $this->selectedTags, $this->tags, ['class' => 'form-control', 'multiple' => true]);
        $content = ob_get_clean();
       // return Html::encode($content);
       return $content;

    }

}