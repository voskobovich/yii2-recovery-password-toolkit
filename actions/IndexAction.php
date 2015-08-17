<?php

namespace voskobovich\recovery\actions;

use voskobovich\recovery\forms\RecoveryIndexForm;
use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;

/**
 * Class IndexAction
 * @package voskobovich\recovery\actions
 */
class IndexAction extends Action
{
    /**
     * @var string
     */
    public $modelClass;

    /**
     * @var string
     */
    public $viewName = 'index';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->modelClass == null) {
            throw new InvalidConfigException('Param "modelClass" must be contain model name with namespace.');
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        /** @var RecoveryIndexForm $model */
        $model = new $this->modelClass;

        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            if ($model->validate() && $model->sendMessage()) {
                Yii::$app->session->setFlash('recoveryIndexSuccess');
            }
        }

        return $this->controller->render($this->viewName, [
            'model' => $model
        ]);
    }
}