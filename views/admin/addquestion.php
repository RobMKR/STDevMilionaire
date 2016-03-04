<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = 'Add Question';
if(Yii::$app->session->hasFlash('required')){
  echo "<div class='alert alert-danger'>".Yii::$app->session->getFlash('required')."</div>";
} else if(Yii::$app->session->hasFlash('add_complete')){
  echo "<div class='alert alert-success'>".Yii::$app->session->getFlash('add_complete')."</div>";
}

?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'question')->textInput(['autofocus' => true]) ?><hr>
        <?= $form->field($model, 'answer[]')->textInput() ?>
        <?= $form->field($model, 'is_true[]')->checkBox(['label' => 'Correct Answer?', 'value'=> "0" , 'uncheck' => null, 'checked' => true]); ; ?><hr>
        <?= $form->field($model, 'answer[]')->textInput() ?>
        <?= $form->field($model, 'is_true[]')->checkBox(['label' => 'Correct Answer?', 'value'=> "1" ,'uncheck' => null, 'checked' => true]); ; ?><hr>
        <?= $form->field($model, 'answer[]')->textInput() ?>
        <?= $form->field($model, 'is_true[]')->checkBox(['label' => 'Correct Answer?',  'value'=> "2" ,'uncheck' => null, 'checked' => true]); ; ?><hr>
        <?= $form->field($model, 'answer[]')->textInput() ?>
        <?= $form->field($model, 'is_true[]')->checkBox(['label' => 'Correct Answer?', 'value'=> "3", 'uncheck' => null, 'checked' => true]); ; ?><hr>
        <?= $form->field($model, 'points')->textInput() ?>







        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Add Question', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end();?>
</div>
