<?php

namespace voskobovich\recovery\actions;

use voskobovich\recovery\forms\IndexForm;
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
    public $viewFile = 'index';

    /**
     * @var callable|null;
     */
    public $successCallback;

    /**
     * @var callable|null;
     */
    public $errorCallback;

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
        /** @var IndexForm $model */
        $model = new $this->modelClass;

        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            if ($model->validate() && $model->sendMessage()) {
                if ($this->successCallback) {
                    call_user_func($this->successCallback, $model);
                } else {
                    Yii::$app->session->setFlash('index:success');
                }
            }
        }

        return $this->controller->render($this->viewFile, [
            'model' => $model
        ]);
    }
}