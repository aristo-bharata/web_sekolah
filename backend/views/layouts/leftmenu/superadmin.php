<?php

    if(yii::$app->user->isGuest){
        Yii::$app->response->redirect('/site/login');
    }
use yii\helpers\Html;
use yii\helpers\Url;
?>


<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="\" class="brand-link">
        <?php
        
            //echo Yii::$app->webidentity->pageLogo()->id;
            
            echo Html::img(Yii::$app->params['publicImageLink'].Yii::$app->webidentity->pageLogo()->media,[
                'alt' => Yii::$app->webidentity->pageLogo()->description,
                'class' => 'brand-image',
           ]);
        ?>
        <!-- <img src="logo_vacationtoday-bw.png" alt="vacationtoday Logo" class="brand-image">-->
        <span class="brand-text font-weight-light">ADMINISTRATOR</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            <?php
              echo Html::img(Yii::$app->params['employeesImageLink'].Yii::$app->usershow->viewEmployeesMedia(Yii::$app->user->identity->id),
                      [
                          'alt' => Yii::$app->usershow->viewEmployees(Yii::$app->user->identity->id),
                          'class' => 'img-circle elevation-2',
                      ]);
            ?>
            </div>
            <div class="info">
              <a href="#" class="d-block"><?= ucwords(Yii::$app->usershow->viewEmployees(Yii::$app->user->identity->id)) ?></a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="\" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                      Dashboard
                    </p>
                </a>
            </li>
            <li class="nav-item mt-2">
                <?php
                    echo Html::a(Html::tag('i','',[
                        'class' => 'nav-icon fas fa-copy',
                    ]).Html::tag('p','Articles'.Html::tag('i','',['class' => 'fas fa-angle-left right']),[
                        'class' => 'text-light',
                    ]), Url::to('#'),[
                        'class' => 'nav-link',]);
                ?>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <?php 
                          echo Html::a(Html::tag('i','',[
                                      'class' => 'fas fa-plus-square nav-icon text-light',
                                  ]).Html::tag('p','Post Article',[
                                      'class' => 'text-light',
                                  ]), Url::to('/blogs/create'),[
                                      'class' => 'nav-link']);
                        ?>
                    </li>  
                    <li class="nav-item">
                        <?php 
                            echo Html::a(Html::tag('i','',[
                                        'class' => 'fas fa-newspaper nav-icon text-success'
                                    ]).Html::tag('p','Live', [
                                        'class' => 'text-success',
                                    ]),Url::to('/blogs/admin-index'),[
                                        'class' => 'nav-link',]);
                        ?>
                    </li>
                  <li class="nav-item mt-1">
                      <?php
                          echo Html::a(Html::tag('i','',[
                                      'class' => 'fab fa-firstdraft nav-icon text-warning',
                                  ]).Html::tag('p','Draft',[
                                      'class' => 'text-warning',
                                  ]), Url::to('/blogs/admin-draft'),[
                                      'class' => 'nav-link']);
                      ?>
                  </li>
                </ul>
            </li>
            <li class="nav-item mt-2">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-images"></i>
                  <p>
                    Galleries
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <?php 
                          echo Html::a(Html::tag('i','',[
                                      'class' => 'fas fa-plus-square nav-icon text-light',
                                  ]).Html::tag('p','Post Article',[
                                      'class' => 'text-light',
                                  ]), Url::to('/galleries/create'),[
                                      'class' => 'nav-link']);
                        ?>
                    </li>
                  <li class="nav-item">
                      <?php
                          echo Html::a(Html::tag('i', '', [
                                      'class' => 'far fa-images nav-icon text-success',
                                  ]).Html::tag('p', 'Live', [
                                      'class' => 'text-success',
                                  ]), Url::to('/galleries/admin-index'),[
                                      'class' => 'nav-link']);
                      ?>
                  </li>
                  <li class="nav-item mt-1">
                      <?php
                          echo Html::a(Html::tag('i', '', [
                                      'class' => 'fas fa-pencil-ruler nav-icon text-warning',
                                  ]).Html::tag('p', 'Draft', [
                                      'class' => 'text-warning',
                                  ]), Url::to('/galleries/admin-draft'),[
                                      'class' => 'nav-link']);
                      ?>
                  </li>
                  <!--
                  <li class="nav-item mt-1">
                      <?php
                          echo Html::a(Html::tag('i', '', [
                                      'class' => 'fas fa-trash-alt nav-icon text-danger',
                                  ]).Html::tag('p', 'Trash', [
                                      'class' => 'text-danger',
                                  ]), Url::to('/galleries/trash'),[
                                      'class' => 'nav-link']);
                      ?>
                  </li>
                  -->
                </ul>
            </li>
            <li class="nav-item mt-2">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-address-book"></i>
                  <p>
                    Employees
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item mt-1">
                        <?php
                            echo Html::a(Html::tag('i', '',[
                                    'class' => 'fas fa-user-plus nav-icon text-warning',
                                ]).Html::tag('p','Create Employees', [
                                    'class' => 'text-warning',
                                ]), Url::to('/employees/create'),[ 
                                    'class' => 'nav-link']);
                        ?>
                    </li>
                    <li class="nav-item">
                        <?php
                            echo Html::a(Html::tag('i', '', [
                                    'class' => 'fas fa-users-cog nav-icon text-success',
                                ]).Html::tag('p', 'Employees Setting',[
                                    'class' => 'text-success',
                                ]), Url::to('/employees/index'),[
                                    'class' => 'nav-link']);
                        ?>
                    </li>
                </ul>
            </li>
            <li class="nav-item mt-2">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-sticky-note"></i>
                  <p>
                    Regulation
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <?php 
                          echo Html::a(Html::tag('i','',[
                                      'class' => 'fas fa-plus-square nav-icon text-light',
                                  ]).Html::tag('p','Post Regulation',[
                                      'class' => 'text-light',
                                  ]), Url::to('/regulation/create'),[
                                      'class' => 'nav-link']);
                        ?>
                    </li>
                    <li class="nav-item">
                        <?php 
                            echo Html::a(Html::tag('i','',[
                                        'class' => 'fas fa-newspaper nav-icon text-success'
                                    ]).Html::tag('p','Live', [
                                        'class' => 'text-success',
                                    ]),Url::to('/regulation/index'),[
                                        'class' => 'nav-link',]);
                        ?>
                    </li>
                    <li class="nav-item mt-1">
                        <?php
                            echo Html::a(Html::tag('i','',[
                                        'class' => 'fab fa-firstdraft nav-icon text-warning',
                                    ]).Html::tag('p','Draft',[
                                        'class' => 'text-warning',
                                    ]), Url::to('/regulation/draft'),[
                                        'class' => 'nav-link']);
                        ?>
                    </li>
                </ul>
            </li>
            <li class="nav-item mt-2">
                <?php
                    echo Html::a(Html::tag('i', '', [
                                'class' => 'fas fa-cog nav-icon text-light',
                            ]).Html::tag('p','Setting',[
                                'class' => 'text-light',
                            ]), Url::to('/webidentity/index'),[
                                'class' => 'nav-link']);
                ?>
            </li>
            <li class="nav-item mt-2">
                <?php
                    echo Html::a(Html::tag('i', '', [
                                'class' => 'fas fa-trash-alt nav-icon text-light',
                            ]).Html::tag('p','Trash',[
                                'class' => 'text-light',
                            ]), Url::to('/anekdot/admin-trash'),[
                                'class' => 'nav-link']);
                ?>
            </li>
            <li class="nav-item mt-3">
                <?php
                    echo Html::a(Html::tag('i','',[
                                'class' => 'nav-icon fas fa-sign-out-alt text-light',
                            ]).Html::tag('p','Log Out',[
                                'class' => 'text-light',
                            ]), Url::to('/site/logout'),[
                                'class' => 'nav-link btn btn-danger bg-danger',
                                'data' => ['method' => 'post'],]);
                ?>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>