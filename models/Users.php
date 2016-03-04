<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Users extends ActiveRecord{

    public $confirm;
    public $passwordField;


    public static function tableName()
    {
        return 'users';
    }
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'passwordField', 'confirm'], 'required', 'on'=>'register'],
            [['username', 'passwordField'], 'required', 'on'=>'login'],
            ['confirm', 'compare', 'compareAttribute'=>'passwordField', 'message'=>"Passwords don't match", 'on'=>'register'],


                ];
    }
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'passwordField' => 'Password',
            'confirm' => 'RePassword',
            'role' =>'Admin',
        ];
    }
    public function loginUser(){
      $session = Yii::$app->session;
      $session->set('isLoggedIn', $this->username);
    }
    public static function isLoggedIn(){
      if(isset(Yii::$app->session['isLoggedIn'])){
        return true;
      }
      return false;
    }
    public function logOut(){
      if(isset(Yii::$app->session['isLoggedIn'])){
        Yii::$app->session->destroy();
      }
    }

    public function adminLogOut(){
      if(isset(Yii::$app->session['admin'])){
        Yii::$app->session->destroy();
      }
    }
    public function isAdmin(){
      if(isset(Yii::$app->session['admin'])){
        return true;
      }
      return false;
    }
    public function loginAdmin(){
      $session = Yii::$app->session;
      $session->set('admin', $this->username);
    }

}
