<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Questions extends ActiveRecord{
    public $answer;
    public $is_true;
    

    public static function tableName()
    {
        return 'questions';
    }

    public function attributeLabels()
    {
        return [
            'question' => 'Question',
            'true_answers' => 'True Answers is',
            'false_answers' => 'False Answers is',
            'points' =>'Points',
            'answer' => 'Answer',
            'is_true' => 'True?'
        ];
    }
    public function getQuestions($limit){
      $query = Yii::$app->db->createCommand("SELECT * FROM questions ORDER BY RAND() LIMIT $limit");
      $result = $query->queryAll();
      $data = [];
      $k = 0;
      foreach($result as $res){
        $data["question_$k"]["id"] = $res['id'];
        $data["question_$k"]["question"] = $res['question'];
        $data["question_$k"]["true_answers"] = explode(" , " , $res['true_answers']);
        $false = explode(" , " , $res['false_answers']);
        $data["question_$k"]["answers"] = $data["question_$k"]["true_answers"];
        foreach($false as $ans){
          array_push($data["question_$k"]["answers"], $ans) ;
        }
        $data["question_$k"]["points"] = $res['points'];
        $k++;

      }

      return $data;

    }
    public static function getQFlash(){
      if(Yii::$app->session->hasFlash('true_ans')){
        echo "<div class='alert alert-success'>".Yii::$app->session->getFlash('true_ans')."</div>";
      } else if(Yii::$app->session->hasFlash('false_ans')){
        echo "<div class='alert alert-danger'>".Yii::$app->session->getFlash('false_ans')."</div>";
      }
    }

}
