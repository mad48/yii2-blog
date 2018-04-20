<?php

/* @var $this \yii\web\View */
/* @var $content string */


use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use common\widgets\BreadcrumbsMicrodata;
use frontend\assets\AppAsset;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<nav class="navbar main-menu navbar-default">
    <div class="container">
        <div class="menu-content">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!--<a class="navbar-brand" href="/"><img src="/images/logo.jpg" alt=""></a>-->
            </div>


            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav text-uppercase">
                    <li><a data-toggle="dropdown" class="dropdown-toggle" href="/">Home</a></li>
                    <li><a data-toggle="dropdown" class="dropdown-toggle" href="/blog">Blog</a></li>
                </ul>
                <div class="i_con">
                    <ul class="nav navbar-nav text-uppercase">
                        <?php if (Yii::$app->user->isGuest): ?>
                            <!-- <li><a href="<? /*= Url::toRoute(['site/login']) */ ?>">Login</a></li>-->

                            <li><a href="<?= Url::to(['@admin']) ?>">Login</a></li>
                            <li><a href="<?= Url::toRoute(['site/signup']) ?>">Register</a></li>

                        <?php else: ?>

                            <!--                            <span style="float: left; margin-left: -120px; margin-top: 9px; "><a href="/backend/web/">Admin Panel</a></span>-->
                            <?= Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(
                                'Logout (' . Yii::$app->user->identity->username . ')',
                                ['class' => 'btn btn-link logout', 'style' => " padding-top:10px;"]
                            )
                            . Html::endForm() ?>
                        <?php endif; ?>
                    </ul>
                </div>

            </div>
            <!-- /.navbar-collapse -->
        </div>

        <?= BreadcrumbsMicrodata::widget([
            'options' => [
                'class' => 'breadcrumb',
            ],
            'homeLink' => [
                'label' => Yii::t('yii', 'Home'),
                'url' => ['/blog/index'],
                'class' => 'home',
                'template' => '<li>{link}</li>',
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'itemTemplate' => '<li>{link}</li>',
            'activeItemTemplate' => '<li class="active">{link}</li>',
            'tag' => 'ul',
            'encodeLabels' => false
        ]);
        ?>


    </div>

    <!-- /.container-fluid -->
</nav>


<?= $content ?>


<footer id="footer" class="footer-widget-section">

    <div class="footer-copy">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">&copy; 2018 Yii2 Blog
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
