<?php

namespace frontend\controllers;

use yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

use common\models\Post;
use common\models\Category;


class BlogController extends Controller
{


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // выбрать все активные для определения их количества для pagination
        $query = Post::find()->where(['active' => true]);


        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 3,
            'forcePageParam' => false, // будет без page/1;  см. urlManager => rules
            'pageSizeParam' => false // убирает per-page из url
        ]);

        // выбрать только отображаемые с учетом смещения на номер страницы
        $posts = $query
            ->with('author', 'category', 'tags')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        // var_dump($posts);

        $categories = Category::find()->all();

        return $this->render('index', [
            'posts' => $posts,
            'pagination' => $pagination,
            'categories' => $categories
        ]);
    }


    public function actionPost($id)
    {
        $post = Post::findOne($id);

        $categories = Category::getAll();

        return $this->render('single', [
            'post' => $post,
            'categories' => $categories,
        ]);
    }

    public function actionCategory($id)
    {

        $data = Category::getPostsByCategory($id);
        $categories = Category::getAll();

        return $this->render('category', [
            'posts' => $data['posts'],
            'pagination' => $data['pagination'],
            'categories' => $categories
        ]);
    }



}
