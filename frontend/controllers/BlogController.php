<?php

namespace frontend\controllers;

use yii;

use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

use common\models\Post;
use common\models\Category;


class BlogController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'post', 'category'],
                        'allow' => true,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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
        $data = Post::getAll();
        $categories = Category::getAll();

        $this->view->params['breadcrumbs'][] = ['label' => 'Блог'];

        return $this->render('index', [
            'posts' => $data['posts'],
            'pagination' => $data['pagination'],
            'categories' => $categories,
        ]);
    }


    public function actionPost($id)
    {
        $post = Post::getOne($id);
        $categories = Category::getAll();

        $this->view->params['breadcrumbs'][] = ['label' => 'Блог', 'url' => ['blog/']];
        $this->view->params['breadcrumbs'][] = ['label' => $post->title];

        return $this->render('single', [
            'post' => $post,
            'categories' => $categories,
        ]);
    }

    public function actionCategory($id)
    {
        $data = Category::getPostsByCategory($id);
        $categories = Category::getAll();

        $curcat = Category::getCategoryById($id);

        $this->view->params['breadcrumbs'][] = ['label' => 'Блог', 'url' => ['blog/']];
        $this->view->params['breadcrumbs'][] = ['label' => $curcat->title];

        return $this->render('index', [
            'posts' => $data['posts'],
            'pagination' => $data['pagination'],
            'categories' => $categories,
            'curcat' => $curcat
        ]);
    }


}
