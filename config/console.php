<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
	'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\User',
        ],

        'session' => [ // for use session in console application
            'class' => 'yii\web\Session'
        ],

        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
		'imap' => [
            'class' => 'kekaadrenalin\imap\Imap',
            'connection' => [
              'imapPath' => '{imap.gmail.com:993/imap/ssl}INBOX',
              'imapLogin' => 'email@gmail.com',
              'imapPassword' => 'passwd',
              'serverEncoding'=>'encoding', // utf-8 default.
              //'attachmentsDir'=>'/'
			  'attachmentsDir'=>'/home/soft/public_html/prst.in.ua/files/mail_attached/'
			 // 'decodeMimeStr'  => true,
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
