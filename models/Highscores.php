<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Highscores extends ActiveRecord{

    public static function tableName()
    {
        return 'highscores';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'points' =>'Points',
            'timestamp' => 'Date of score'

        ];
    }


}
