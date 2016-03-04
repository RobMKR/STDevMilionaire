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

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionRegister()
    {
        return $this->render('/users/register');
    }
    public function actionIndex()
    {

        if(!Users::isLoggedIn()){
          return $this->redirect('users/login');
        }
        if(!isset(Yii::$app->session['questions'])){
          $model  = new Questions();
          $data = $model->getQuestions(5);
          Yii::$app->session->set('questions', $data);
          Yii::$app->session->set('points', '0');
          Yii::$app->session->set('reset', $data);

        }


        $question = Yii::$app->session["questions"];
        if(Yii::$app->request->get() && isset($_GET["question"])){
          if($_GET["answer"] === array_intersect($_GET["answer"], $question[$_GET["question"]]['true_answers']) &&
             $question[$_GET["question"]]['true_answers'] === array_intersect($question[$_GET["question"]]['true_answers'], $_GET["answer"])){

            Yii::$app->session->setFlash('true_ans', 'Answer is correct, you got '.$question[$_GET["question"]]['points']. ' points.');
            Yii::$app->session['points'] +=  $question[$_GET["question"]]['points'];

          } else {
            Yii::$app->session->setFlash('false_ans', 'Answer is wrong, correct answer is \''.implode(" , " , $question[$_GET["question"]]['true_answers']).'\'');
          }
          unset($_SESSION["questions"][$_GET['question']]);
          if(current(array_keys($_SESSION["questions"])) != ""){
            return $this->redirect('/?question_id='.current(array_keys($_SESSION["questions"])));
          } else {
            Yii::$app->session['score'] = Yii::$app->session['points'];
            Yii::$app->session['points'] = 0;
            Yii::$app->session->setFlash('final', 'Finish. Your Score:  \''.Yii::$app->session['score'].'\'');
            $_SESSION["questions"] = Yii::$app->session['reset'];


          }
        }
        return $this->render('index', [


        ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
