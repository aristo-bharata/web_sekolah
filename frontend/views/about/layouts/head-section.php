<?php

use yii\widgets\ActiveForm;
/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
?>
<section class="py-5 text-center purple">
  <div class="container">
    <div class="row py-lg-5">
      <div class="col-lg-8 col-md-8 mx-auto">
        <h1 class="fw-light">Find the great place!</h1>
        <p class="lead text-muted">You will find places you have never been and will attract you to travel there</p>
        <?php
            $form = ActiveForm::begin([
                'method' => 'GET',
                'action' => Yii::$app->params['homeLink'].'/search',
            ]);
        ?>
          <div class="input-group mb-3">
              <span class="input-group-text bg-white border border-end-0"><i class="bi bi-search"></i></span>
              <?php /* $form->field($articles, 'keystring')->fileInput([
                  'class' => 'form-control border border-start-0',
                  'aria-describedby' => 'basic-addon2',
              ])->label(false)*/?>
              <input name="keystring" type="search" class="form-control border border-start-0" aria-describedby="basic-addon2">
            </div>
            <button class="btn btn-danger">Search</button>
        <?php
        ActiveForm::end();
        ?>
      </div>
    </div>
  </div>
</section>