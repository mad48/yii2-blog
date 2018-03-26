<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>
<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php foreach ($posts as $post): ?>
                    <post class="post">
                        <div class="post-thumb">


                            <a href="<?= Url::toRoute(['post', 'id' => $post->id]); ?>"
                               class="post-thumb-overlay text-center">
                                <div class="text-uppercase text-center">View Post</div>
                            </a>
                        </div>
                        <div class="post-content">
                            <header class="entry-header text-center text-uppercase">

                                <h1 class="entry-title"><a
                                        href="<?= Url::toRoute(['post', 'id' => $post->id]); ?>"><?= $post->title ?></a>
                                </h1>


                            </header>
                            <div class="entry-content">
                                <p><?= $post->content ?></p>

                                <div class="btn-continue-reading text-center text-uppercase">
                                    <!-- <a href="<? /*= Url::toRoute(['post', 'id' => $post->id]); */ ?>" class="more-link">Read
                                        more</a>-->
                                    <?= yii\bootstrap\Html::a('Read more', ['post', 'id' => $post->url], ['class' => 'btn btn-primary']) ?>
                                </div>
                            </div>
                            <div class="social-share">

                                <span
                                    class="social-share-title pull-left text-capitalize">
                                  
                                    <!--  --><? /*= $curTime = Yii::$app->formatter->asDateTime(new \DateTime('NOW'), 'yyyy-MM-dd HH:mm:ss');*/ ?>
                                    <?= Yii::$app->formatter->asDatetime($post->date) ?> /
                                    <a href="<?= Url::toRoute(['category', 'id' => $post->category->id]) ?>">
                                        <?= $post->category->title ?>
                                    </a>
                                    / by <?= $post->author->username ?></span>

                                <ul class="text-center pull-right">

                                    <?php
                                    foreach ($post->tags as $tag):?>
                                        <?= '<li><a href="#">#' . $tag->title . '</a></li>'; ?>
                                    <?php endforeach; ?>

                                </ul>
                            </div>
                        </div>
                    </post>

                <?php endforeach; ?>

                <?php
                echo LinkPager::widget([
                    'pagination' => $pagination,
                ]);
                ?>
            </div>
            <?= $this->render('/partials/sidebar', [
                'categories' => $categories
            ]); ?>
        </div>
    </div>
</div>
<!-- end main content-->
<!--footer start-->