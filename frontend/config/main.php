<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => false,
            'showScriptName' => false,
            //запретить стандартные URL если не соответствует правилам класса
            //'enableStrictParsing' => true,
            'rules' => [
                /*                'page-<page:\d+>' => 'post/index', //пагинация для главной страницы
                                '/' => 'post/index', //главная страница

                                'site/captcha' => 'site/captcha', //для капчи ничего не меняем
                                'sitemap.xml' => 'site/sitemap', //карта сайта

                                'posts/page-<page:\d+>' => 'post/posts', //пагинация для статей
                                'posts' => 'post/posts', //статьи

                             //вывод статичных страниц
                                [
                                    'pattern'=>'<action:about|service|contact>',
                                    'route' => 'site/<action>',
                                    'suffix' => '.html',
                                ],
                  */
                //login|logout|signup и тд.
             //   '<action:\w+>' => 'site/<action>',

                /*                //вывод отдельной страницы
                                [
                                    'pattern'=>'<url:\w+>',
                                    'route' => 'site/view',
                                    'suffix' => '.html',
                                ],
                                /*
                /*
                                              'category/<url:\w+>' => 'category/view', //рубрики
                                              'tag/<url:\w+>' => 'tag/view', //метки
                                          */
            ],
        ],

    ],
    'params' => $params,
];
