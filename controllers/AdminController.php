<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Users;
use app\models\Questions;
use app\models\Highscores;
use yii\authclient\AuthAction;


class AdminController extends Controller
{

    public function actionIndex()
    {
        $this->layout = "admin";
        if(!Users::isAdmin()){
          return $this->redirect('admin/login');
        }
        $model = new Questions();
        $data = $model->find()->orderBy('points DESC')->limit(10)->asArray()->all();
        return $this->render('index', [
          'data' => $data
       ]);
    }

    public function actionLogin(){
      $this->layout = "admin";
      if(Users::isAdmin()){
        return $this->redirect('/');
      }
      if(empty(Yii::$app->session['admin'])){
        $model = new Users();
        $model->setScenario('login');
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
          $user = Users::find()->where(["username" => $model->username ])->asArray()->all();
          if(Yii::$app->getSecurity()->validatePassword($model->passwordField, $user[0]['password']) && $user[0]['role'] == '1'){
              $model->loginAdmin();
              return $this->redirect('/admin');
          } else {
              Yii::$app->session->setFlash('password', 'Username or Password is invalid.');
          }



        }
          return $this->render('login', [
             'model' => $model,
         ]);
      }
    }
    public function actionAddquestion()
    {
        $this->layout = "admin";
        if(!Users::isAdmin()){
          return $this->redirect('/admin');
        }
        $model = new Questions();
        if($model->load(Yii::$app->request->post())){
          $data = Yii::$app->request->post()["Questions"];
          $model->question = $data["question"];
          if (count($data['is_true']) != 1){

            foreach($data['is_true'] as $key){
              $array[] = $data['answer'][$key];
              unset($data['answer'][$key]);
            }

            $model->true_answers = implode(' , ' , $array);
            $model->false_answers = implode(' , ' , $data['answer']);

          } else {

            $model->true_answers = $data['answer'][$data['is_true'][0]];
            unset($data['answer'][$data['is_true'][0]]);
            $model->false_answers = implode(' , ' , $data['answer']);

          }
          $model->points = $data['points'];

          if(!empty($model->points) && !empty($model->false_answers) && !empty($model->true_answers) && !empty($model->question)){
            if($model->save()){
              Yii::$app->session->setFlash('add_complete', 'You have added a question');
            } else {
              Yii::$app->session->setFlash('db_problem', 'You have Database problem');
            }

          } else {
            Yii::$app->session->setFlash('required', 'You Must fill all fields');
          }

        }


        return $this->render('addquestion', [
          'model' => $model
       ]);
    }
    public function actionRemove()
    {
        $this->layout = "admin";
        if(!Users::isAdmin()){
          return $this->redirect('admin/login');
        }
        if(isset($_GET['q_id'])){
          $id = $_GET['q_id'];
          $model =Questions::deleteAll("id = $id");
          return $this->redirect('/admin');
        }
        return $this->render('remove', [

       ]);
    }
    public function actionLogout()
    {
      Users::adminLogOut();
      return $this->redirect('/admin/login');
    }


}
