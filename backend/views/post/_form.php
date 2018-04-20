<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;

use common\models\Tag;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>

    <? /*= $form->field($model, 'category_id')->textInput() */ ?>

    <?= $form->field($model, 'category_id')->dropDownList($categories) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->widget(Widget::class, [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'plugins' => [
                'clips',
                'fullscreen',
            ],
        ],
    ]); ?>
    <!--  --><? /*= $form->field($model, 'content')->textarea(['rows' => 6]) */ ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, "active")->checkbox(); ?>


    <?= $form->field($model, 'tags_array')->widget(\kartik\select2\Select2::class, [
        'data' => ArrayHelper::map(Tag::getAll(), 'id', 'title'),
        'value' => ArrayHelper::map($model->tags, 'id', 'title'),
        'language' => 'ru',
        'options' => ['placeholder' => 'Select a tag ...', 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true,
            'tags' => true
        ],
    ]);
    ?>

    <? /*= $form->field($model, 'date')->textInput() */ ?>

    <?php
    echo $form->field($model, 'date')->widget(DateTimePicker::class, [
        'name' => 'DateTimePicker1',
        'type' => DateTimePicker::TYPE_INPUT,
        'options' => ['placeholder' => 'Дата...'],
        'convertFormat' => true,
        'value' => $model->date,
        'pluginOptions' => [
            'format' => Yii::$app->formatter->datetimeFormat,
            'autoclose' => true,
            'weekStart' => 1, // с понедельника
            // 'startDate' => '01.01.2017 00:00', //самая ранняя  дата
            'todayBtn' => true, // кнопка "сегодня"
        ]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
