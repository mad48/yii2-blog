<?php
use yii\helpers\Url;

?>
<div class="col-md-4" data-sticky_column>
    <div class="primary-sidebar">

        <aside class="widget border pos-padding">
            <h3 class="widget-title text-uppercase text-center">Categories</h3>
            <ul>
                <?php foreach ($categories as $category): ?>
                    <li>
                        <a href="<?= Url::toRoute(['blog/category', 'id' => $category->id]); ?>"><?= $category->title ?></a>
                        <span class="post-count pull-right"> (<?= $category->getPostsCount(); ?>)</span>
                    </li>
                <?php endforeach; ?>

            </ul>
        </aside>
    </div>
</div>