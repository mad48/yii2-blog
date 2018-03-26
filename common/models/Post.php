<?php

namespace common\models;

use yii;
use yii\behaviors\TimestampBehavior;
use yii\data\Pagination;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\behaviors\SluggableBehavior;

class Post extends \yii\db\ActiveRecord
{
    public $tags_array;

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
            ['url', 'unique', 'targetAttribute' => ['url'], 'message' => 'url must be unique'],
            [['content'], 'string'],
            [['active'], 'string', 'max' => 1],
            //   [['date'], 'safe'],
            //['date', 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            ['date', 'datetime', 'format' => 'php:d.m.Y H:i'],//Yii::$app->formatter->datetimeFormat
            [['date'], 'default', 'value' => date('Y-m-d H:i:s')],
            [['tags_array'], 'safe']
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
            'tags_array' => 'Tags'
        ];
    }

    public function behaviors()
    {
        return [
            'slug' => [
                'class' => 'Zelenin\yii\behaviors\Slug',
                'slugAttribute' => 'url',
                'attribute' => 'title',
                'ensureUnique' => true,
                'replacement' => '-',
                'lowercase' => true,
                // 'immutable' => false,
                'transliterateOptions' => 'Russian-Latin/BGN; Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;'
            ],
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'date',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'date',
                ],
                'value' => function () {
                    return date('Y-m-d H:i:s', strtotime($this->date));
                },
            ],
        ];
    }


    public function savePost()
    {
        $this->user_id = Yii::$app->user->id;
        return $this->save();//убрать false иначе не работает SluggableBehavior
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


    public static function getOne($id)
    {
        $param = null;

        // экспериментальный вариант
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

        if (is_null($post)) {
            // если пост не найден - 404
            throw new NotFoundHttpException('Post not found');
        } else {
            return $post;
        }
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


    public static function getStatuses()
    {
        return [0 => "off", 1 => "on"];
    }


    public function getStatusName()
    {
        return $this->getStatuses()[$this->active];
    }


    public function getPostTagsIdsArray()
    {
        return ArrayHelper::map($this->tags, 'id', 'id');
    }


    public function afterFind()
    {

        $this->date = Yii::$app->formatter->asDatetime($this->date);

        $this->tags_array = $this->tags;
    }

    public function afterSave($insert, $changedAttributes)
    {

        parent::afterSave($insert, $changedAttributes);


        /*
                $arr = ArrayHelper::map($this->tags, 'id', 'id');
                foreach ($this->tags_array as $one) {
                    if (!in_array($one, $arr)) {
                        $model = new PostTag();
                        $model->post_id = $this->id;
                        $model->tag_id = $one;
                        $model->save();
                    }
                    if (isset($arr[$one])) {
                        unset($arr[$one]);
                    }
                }
        
                PostTag::deleteAll(
                    [
                        'AND',
                        'post_id= :post_id',
                        ['NOT IN', 'tag_id', $this->tags_array],
                    ],
                    [':post_id' => $this->id]
                );*/
        /*        echo "old<br>";
                var_dump($this->getOldAttribute('tags_array'));

                echo "new<br>";
                var_dump($this->tags_array);
                exit();*/

        if (empty($this->tags_array)) $this->tags_array = [];

        $added_tags = array_diff($this->tags_array, $this->postTagsIdsArray); //var_dump($added_tags);

        foreach ($added_tags as $tag_id) {
            $tag = Tag::findOne($tag_id);
            if ($tag) $this->link('tags', $tag);

            /*  $model = new PostTag();$tag_id
                  $model->post_id = $this->id;
                  $model->tag_id = $tag_id;
                  $model->save();
            */
        }


        $deleted_tags = array_diff($this->postTagsIdsArray, $this->tags_array);//var_dump($deleted_tags);

        PostTag::deleteAll(
            [
                'AND',
                'post_id= :post_id',
                ['IN', 'tag_id', $deleted_tags],
            ],
            [':post_id' => $this->id]
        );


    }

}
