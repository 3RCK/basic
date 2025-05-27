<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    //public $id;
    //public $username;
    public $password;

    private static $users = [
        '100' => [
            'id' => '200',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];


    public static function tableName(){
        return '{{%user}}';
    }

    public function rules(){
        return [
        [['username', 'nombre', 'apellido', 'password', 'auth_key', 'access_token', 'role'], 'required'],
        [['nombre', 'apellido'], 'string', 'max' => 150],
        [['password_hash'], 'string', 'max' => 255],
        [['auth_key', 'access_token', 'role'], 'string', 'max' => 45],
       // [['username'], 'unique'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password){

        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey(){

        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generateAccessToken(){

        $this->access_token = Yii::$app->security->generateRandomString();
    }

    public function beforeValidate(){

            if($this->isNewRecord){

            $this->generateAuthKey();
            $this->generateAccessToken();

            }

        return parent::beforeValidate();
    }

    public function beforeSave($insert){
            if(parent::beforeSave($insert)){
                if(isset($this->password)){
                $this->setPassword($this->password);
            }
                return true;
            }
        return false;
    }
}
