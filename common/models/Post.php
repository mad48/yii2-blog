<?php

namespace common\models;

use yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;


class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'category_id'], 'integer'],
            [['title'], 'required'],
            [['title', 'url'], 'string', 'max' => 255],
            [['content'], 'string'],
            [['active'], 'string', 'max' => 1],
            [['date'], 'safe'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['date'], 'default', 'value' => date('Y-m-d')],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'category_id' => 'Category ID',
            'title' => 'Title',
            'content' => 'Content',
            'url' => 'Url',
            'active' => 'Active',
            'date' => 'Date',
        ];
    }

    public function savePost()
    {
        $this->user_id = Yii::$app->user->id;
        return $this->save(false);
    }


    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }


    public function saveCategory($category_id)
    {
        $category = Category::findOne($category_id);
        if ($category != null) {
            $this->link('category', $category);
            return true;
        }
    }

    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->viaTable('post_tag', ['post_id' => 'id']);
    }

    public function getSelectedTags()
    {
        $selectedIds = $this->getTags()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedIds, 'id');
    }

    public function saveTags($tags)
    {
        if (is_array($tags)) {
            $this->clearCurrentTags();

            foreach ($tags as $tag_id) {
                $tag = Tag::findOne($tag_id);
                $this->link('tags', $tag);
            }
        }
    }

    public function clearCurrentTags()
    {
        PostTag::deleteAll(['post_id' => $this->id]);
    }

    /*
        public function getDate()
        {
            return Yii::$app->formatter->asDate($this->date);
        }*/


    public static function getPost($id)
    {
        $param = null;

        if (is_numeric($id)) {
            $param = 'id';
        } else {
            $param = 'url';
        }

        $post = Post::find()
            ->with('author', 'category', 'tags')
            ->where(['active' => true, $param => $id])
            //->andWhere($param . ' = :id', [':id' => $id])
            ->limit(1)
            ->one();

        return $post;
    }


    public static function getAll($pageSize = 3)
    {
        // выбрать все активные для определения их количества для pagination
        $query = Post::find()->where(['active' => true]);

        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => $pageSize,
            'forcePageParam' => false, // будет без page/1;  см. urlManager => rules
            'pageSizeParam' => false // убирает per-page из url
        ]);

        // выбрать только отображаемые с учетом смещения на номер страницы
        $posts = $query
            ->with('author', 'category', 'tags')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy(['date' => SORT_DESC])
            ->all();


        $data['posts'] = $posts;
        $data['pagination'] = $pagination;

        return $data;
    }


    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
