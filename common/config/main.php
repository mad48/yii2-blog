<?php
return [
    'language' => 'ru-RU',
    'charset' => 'utf-8',

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'yyyy-MM-dd',
            'datetimeFormat' => 'php:d.m.Y H:i',
            'timeFormat' => 'php:H:i:s',
            'timeZone' => 'UTC',
            //'timeZone' => 'Europe/Moscow',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'RUB',

        ],
    ],
];
