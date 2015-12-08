<?php

namespace voskobovich\recovery\actions;

use voskobovich\recovery\interfaces\CompleteFormInterface;
use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

/**
 * Class CompleteAction
 * @package voskobovich\recovery\actions
 */
class CompleteAction extends Action
{
    /**
     * @var string
     */
    public $modelClass;

    /**
     * @var string
     */
    public $viewFile = 'complete';

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
     * @param $id
     * @param $code
     * @return string
     */
    public function run($id, $code)
    {
        /** @var ActiveRecord|CompleteFormInterface $model */
        $model = new $this->modelClass;
        $model = $model::findOne($id);

        if (!$model || !$model->validateConfirmHash($code)) {
            Yii::$app->session->setFlash('recoveryCompleteError');

            if ($this->errorCallback) {
                call_user_func($this->errorCallback, $model);
            } else {
                Yii::$app->session->setFlash('complete:error');
            }

        } else {
            $post = Yii::$app->request->post();

            if ($model->load($post) && $model->save()) {
                if ($this->successCallback) {
                    call_user_func($this->successCallback, $model);
                } else {
                    Yii::$app->session->setFlash('complete:success');
                }
            }
        }

        return $this->controller->render($this->viewFile, [
            'model' => $model
        ]);
    }
}