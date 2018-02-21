<?php

namespace common\models;

use yii;
use yii\data\Pagination;

class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['category_id' => 'id']);
    }

    public function getPostsCount()
    {
        return $this->getPosts()->count();
    }

    public static function getAll()
    {
        return Category::find()->all();
    }

    public static function getPostsByCategory($id)
    {
        // build a DB query to get all posts
        $query = Post::find()->where(['category_id' => $id]);

        // get the total number of posts (but do not fetch the post data yet)
        $count = $query->count();

        // create a pagination object with the total count
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 6]);

        // limit the query using the pagination and retrieve the posts
        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $data['posts'] = $posts;
        $data['pagination'] = $pagination;

        return $data;
    }
}
