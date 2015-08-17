<?php

namespace voskobovich\recovery\forms;

use yii\base\Model;
use yii\db\ActiveRecord;
use Yii;


/**
 * Class RecoveryIndexForm
 * @package voskobovich\recovery\forms
 */
abstract class RecoveryIndexForm extends Model
{
    /**
     * @var string
     */
    public $email;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('recoveryIndexForm', 'E-mail'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email',
                function ($attribute) {
                    $user = $this->getUser();
                    if (!$user) {
                        $this->addError($attribute, Yii::t('recoveryIndexForm', 'There is no user with such email'));
                    }
                }
            ],
        ];
    }

    /**
     * @return ActiveRecord
     */
    abstract function getUser();

    /**
     * Sends recovery message.
     *
     * @return bool
     */
    abstract function sendMessage();
} 