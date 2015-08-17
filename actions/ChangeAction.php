<?php

namespace voskobovich\recovery\actions;

use voskobovich\recovery\interfaces\ChangeFormInterface;
use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

/**
 * Class ChangeAction
 * @package voskobovich\recovery\actions
 */
class ChangeAction extends Action
{
    /**
     * @var string
     */
    public $modelClass;

    /**
     * @var string
     */
    public $viewName = 'change';

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
        /** @var ActiveRecord|ChangeFormInterface $model */
        $model = new $this->modelClass;
        $model = $model::findOne($id);

        if (!$model || !$model->validateConfirmHash($code)) {
            Yii::$app->session->setFlash('recoveryChangeError');
        } else {
            $post = Yii::$app->request->post();

            if ($model->load($post) && $model->save()) {
                Yii::$app->session->setFlash('recoveryChangeSuccess');
            }
        }

        return $this->controller->render($this->viewName, [
            'model' => $model
        ]);
    }
}