<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\Application;
use app\models\Questions;

 ?>
<div class="row">
  <h1 align="center">Questions</h1>
  <?php foreach($data as $question): ?>
    <div class="col-lg-12 adm-question">
      <div class="col-lg-2">
        <b>Question id:</b> <?=$question['id']?>.
      </div>
      <div class="col-lg-2">
          <b>Question:</b></br> <?=$question['question']?>.
      </div>
      <div class="col-lg-2">
        <b>Correct Answers:</b></br> <?=$question['true_answers']?>.
      </div>
      <div class="col-lg-2">
        <b>Incorrect Answers:</b></br> <?=$question['false_answers']?>.
      </div>
      <div class="col-lg-2">
        <b>Points:</b> <?=$question['points']?>.
      </div>
      <div class="col-lg-2">
        <a href="/admin/remove?q_id=<?=$question['id']?>">Remove Question</a>
      </div>
    </div>
  <?php endforeach;?>
</div>
