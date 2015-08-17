<?php

namespace voskobovich\recovery\controllers;

use yii\filters\AccessControl;


/**
 * Class Controller
 * @package voskobovich\recovery\controllers
 */
class Controller extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'reset'],
                        'roles' => ['?']
                    ],
                ]
            ],
        ];
    }
} 