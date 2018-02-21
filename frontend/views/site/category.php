<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>
<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php

                foreach ($posts as $post):?>
                    <post class="post post-list">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="post-content">
                                    <header class="entry-header text-uppercase">

                                        <h1 class="entry-title"><a
                                                href="<?= Url::toRoute(['site/view', 'id' => $post->id]) ?>"><?= $post->title ?></a>
                                        </h1>
                                        
                                    </header>
                                    <div class="entry-content">
                                        <p><?= $post->content ?>
                                        </p>
                                    </div>
                                    <div class="social-share">
                                        <span
                                            class="social-share-title pull-left text-capitalize"><?= $post->getDate(); ?> /  <a href="<?= Url::toRoute(['site/category', 'id' => $post->category->id]) ?>"> <?= $post->category->title ?></a> /by <?= $post->author->username ?></span>

                                        <ul class="text-center pull-right">

                                            <?php
                                            foreach ($post->tags as $tag):?>
                                                <?= '<li><a href="#">#' . $tag->title . '</a></li>'; ?>
                                            <?php endforeach; ?>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </post>
                    <br><br>
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