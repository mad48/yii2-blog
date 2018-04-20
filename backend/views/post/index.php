<?php

use common\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

use common\models\Post;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'user_id',
            [
                'attribute' => 'user_id',
                'value' => 'author.username',
                'filter' => ArrayHelper::map(User::getAll(), 'id', 'username'),
                'options' => ['width' => '200']
            ],

            'category_id',
            /*        [
                        'attribute' => 'category_id',
                        'value' => 'category.title'
                    ],*/
            'title',
            //'content:ntext',
            //'url:text',
            //['attribute' => 'url', 'format' => 'text'],
            ['attribute' => 'active', 'filter' => Post::getStatuses(), 'value' => 'statusName'],

            'date',

            [
                'class' => 'yii\grid\ActionColumn',

                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        if (Yii::$app->user->can('updatePost', ['post' => Post::findOne(['id' => $model->id])]))
                            return Html::a('upd', $url);
                        else return false;
                    }
                ],
            ],

        ],

    ]); ?>
</div>
