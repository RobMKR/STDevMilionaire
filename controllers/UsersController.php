<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Users;
use app\models\Highscores;
use yii\authclient\AuthAction;


class UsersController extends Controller
{

    public function actionRegister()
    {

      $model = new Users();
      $model->setScenario('register');
      if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        if($model->passwordField === $model->confirm){
          $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->passwordField);
        }
          if($model->save()){
            Yii::$app->session->setFlash('successReg', 'You have successfully registered. You can log in using your Username & Password.');

          } else {
            Yii::$app->session->setFlash('unique', 'This username is token.');
            return $this->refresh();
          }
      }
        return $this->render('register', [
           'model' => $model,
       ]);
    }
    public function actionLogin(){
      if(Users::isLoggedIn()){
        return $this->redirect('/');
      }
      if(empty(Yii::$app->session['isLoggedIn'])){
        $model = new Users();
        $model->setScenario('login');
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
          $user = Users::find()->where(["username" => $model->username ])->asArray()->all();

          if(Yii::$app->getSecurity()->validatePassword($model->passwordField, $user[0]['password'])){
              $model->loginUser();
              return $this->redirect('/');
          } else {
              Yii::$app->session->setFlash('password', 'Username or Password is invalid.');
          }



        }
          return $this->render('login', [
             'model' => $model,
         ]);
      }
    }
    public function actionLogout(){
      Users::logOut();
      return $this->redirect('/users/login');
    }
    public function actionAddscores()
    {
      if(!isset(Yii::$app->session['isLoggedIn'])){
        return $this->redirect('/');
      }
      $model = new Highscores();
      $model->username = Yii::$app->session['isLoggedIn'];
      $model->points = Yii::$app->session['score'];
      $model->timestamp = time();
      $model->save();

      return $this->redirect('/users/highscores');
    }
    public function actionHighscores()
    {

      $model =Highscores::find()->orderBy('points DESC')->limit(10)->asArray()->all();
      return $this->render('highscores', [
         'model' => $model,
      ]);
    }
}
