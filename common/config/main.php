<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'main' => 'app.php',
                        'main/error' => 'error.php'
                    ]
                ],
                'yii' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        'yii' => 'yii.php',
                    ]
                ]
            ]
        ]
    ],
    'modules' =>
        [
            'datecontrol' => [
                'class' => '\kartik\datecontrol\Module',
                'displaySettings' => [
                    \kartik\datecontrol\Module::FORMAT_DATE => 'dd.MM.yyyy',
                    \kartik\datecontrol\Module::FORMAT_TIME => 'HH:mm:ss',
                    \kartik\datecontrol\Module::FORMAT_DATETIME => 'dd.MM.yyyy HH:mm:ss',
                ],

                // format settings for saving each date attribute (PHP format example)
                'saveSettings' => [
                    \kartik\datecontrol\Module::FORMAT_DATE => 'php:Y-m-d', // saves as unix timestamp
                    \kartik\datecontrol\Module::FORMAT_TIME => 'php:H:i:s',
                    \kartik\datecontrol\Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
                ],

                // set your display timezone
//            'displayTimezone' => 'Asia/Tashkent',

                // set your timezone for date saved to db
//            'saveTimezone' => 'UTC',

                // automatically use kartik\widgets for each of the above formats
                'autoWidget' => true,

            ],
            'gridview' => [
                'class' => '\kartik\grid\Module'
            ],
        ]
];
