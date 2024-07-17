<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'arraystatus' => [
            'class' => 'common\components\ArrayStatus',
        ],
        'articleattribute' => [
            'class' => 'common\components\ArticleAttribute',
        ],
        'dateconverter' => [
            'class' => 'common\components\DateConverter',
        ],
        'articlestatistic' => [
            'class' => 'common\components\ArticleStatistic',
        ],
        'usershow' => [
            'class' => 'common\components\UserShow',
        ],
        'youtubechannel' => [
            'class' => 'common\components\YoutubeChannel',
        ],
        'fileextension' => [
            'class' => 'common\components\FileExtension',
        ],
        'webidentity' => [
            'class' => 'common\components\WebIdentity',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
