<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$homeLink = 'http://web_sekolah.prod'; //local

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'roxymce' => [
            'class' => 'navatech\roxymce\Module',
            'uploadFolder' => '@frontend/web/uploads/images/public/',
            'uploadUrl' => 'http://web_sekolah.prod/uploads/images/public/',
            //test
            //'uploadFolder' => '@root/uploads/images/public/',
            //'uploadUrl' => 'http://'.$homeLink.'/uploads/images/public/',
            //live
            //'uploadFolder' => '@root/uploads/images/public/',
            //'uploadUrl' => 'https://'.$homeLink.'/uploads/images/public/',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                //'<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
                //'<module:\w+>/<controller:\w+>/<action:\w+>/' => '<module>/<controller>/<action>',
                '<alias:\w+>' => 'site/<alias>',
            ],
        ],
    ],
    'params' => $params,
];
