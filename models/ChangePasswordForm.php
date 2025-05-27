<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;


class ChangePasswordForm extends Model
{
    public $currentPassword;
    public $newPassword;
    public $confirmPassword;

    private $_user;

    public function rules()
    {
        return [
            [['currentPassword', 'newPassword', 'confirmPassword'], 'required'],
            ['currentPassword', 'validateCurrentPassword'],
            ['newPassword', 'string', 'min' => 5],
            ['confirmPassword', 'compare', 'compareAttribute' => 'newPassword'],
        ];
    }

    public function changePassword(){
        if($this->validate()){
            $user = $this->getUser();
            $user->setPassword($this->newPassword);
        return $user->save(false);
        }
        return false;
    }

    public function validateCurrentPassword($attribute, $params){
        if(!$this->hasErrors()){
            $user = $this->getUser();
                if(!$user || !$user->validatePassword($this->currentPassword)){
                $this->addError($attribute, 'Contraseña actual incorrecta');
                }
        }
    }   


    protected function getUser(){
        if($this->_user === null){
            $this->_user = User::findByUsername(Yii::$app->user->identity->username);
        }
        return $this->_user;
    }

}