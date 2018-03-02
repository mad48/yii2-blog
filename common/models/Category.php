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
        return $this->hasMany(Post::class, ['category_id' => 'id']);
    }


    public function getPostsCount()
    {
        return $this->getPosts()->where(['active' => true])->count();
    }


    public static function getAll()
    {
        return Category::find()->orderBy(['title' => SORT_ASC])->all();
    }


    public static function getPostsByCategory($id)
    {
        $query = Post::find()->where(['category_id' => $id, 'active' => true]);

        $pageSize = 3;
        
        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => $pageSize,
            'forcePageParam' => false,
            'pageSizeParam' => false
        ]);

        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy(['date' => SORT_DESC])
            ->all();

        $data['posts'] = $posts;
        $data['pagination'] = $pagination;

        return $data;
    }
}
