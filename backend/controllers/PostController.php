<?php

namespace backend\controllers;

use yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\models\Post;
use common\models\PostSearch;
use common\models\Category;
use common\models\Tag;


/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $selectedTags = $model->getSelectedTags();
        $tags = ArrayHelper::map(Tag::find()->all(), 'id', 'title');

        return $this->render('view', [
            'model' =>$model,
            'selectedTags' => $selectedTags,
            'tags' => $tags
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post()) && $model->savePost()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'title');


        if ($model->load(Yii::$app->request->post()) && $model->savePost()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'categories' => $categories
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionSetCategory($id)
    {
        $post = $this->findModel($id);
        $selectedCategory = $post->category->id;
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'title');

        if (Yii::$app->request->isPost) {
            $category = Yii::$app->request->post('category');
            if ($post->saveCategory($category)) {
                return $this->redirect(['view', 'id' => $post->id]);
            }
        }

        return $this->render('category', [
            'post' => $post,
            'selectedCategory' => $selectedCategory,
            'categories' => $categories
        ]);
    }

    public function actionSetTags($id)
    {
        $post = $this->findModel($id);
        $selectedTags = $post->getSelectedTags();
        $tags = ArrayHelper::map(Tag::find()->all(), 'id', 'title');

        if (Yii::$app->request->isPost) {
            $tags = Yii::$app->request->post('tags');
            $post->saveTags($tags);
            return $this->redirect(['view', 'id' => $post->id]);
        }

        return $this->render('tags', [
            'selectedTags' => $selectedTags,
            'tags' => $tags
        ]);
    }
}
