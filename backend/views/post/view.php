<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\widgets\TagsWidget;
/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?/*= Html::a('Set Tags', ['set-tags', 'id' => $model->id], ['class' => 'btn btn-default']) */?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'category_id',
            'title',
            'content:ntext',
            'url:url',
            'active',
            'date',
        ],
    ]) ?>


    <?= TagsWidget::widget(['tags' => $tags, 'selectedTags' => $selectedTags]) ?>



</div>
