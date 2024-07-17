<?php

namespace backend\controllers;

use Yii;
use common\models\Employees;
use common\models\EmployeesSearch;
use common\models\MasterEmployees;
use common\models\MasterEmployeesMedia;
use common\models\Medias;
use common\models\Previleges;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\data\Pagination;

/**
 * EmployeesController implements the CRUD actions for Employees model.
 */
class EmployeesController extends Controller
{
    const ACTIVE_STATUS = 1;
    const NOTACTIVE_STATUS = 0;
    const POSITION_LIVE = 1;
    const POSITION_DRAFT = 0;
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['create', 'update','index'],
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied
                ],
            ],
        ];
    }

    /**
     * Lists all Employees models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EmployeesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionTrash() 
    {
        return $this->render('trash', [
            
        ]);
    }
    
    /**
     * Displays a single Employees model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $user = User::findOne($this->getMasterEmployees($id)['employees_id']);
        if($this->countMasterEmployeesMedia($model->id) > 0){
            $medias_ = Medias::findOne($this->getMasterEmployeesMedia($model->id)['medias_id']);
        }else{
            $medias_ = null;
        }
        $medias = new Medias();
        $masterEmployeesMedia = new MasterEmployeesMedia();
        
        return $this->render('view', [
            'model' => $model,
            'user' => $user,
            'medias_' => $medias_,
            'medias' => $medias,
        ]);
    }

    /**
     * Displays a single Employees model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    public function actionContentwriterView($id) {
        $model = $this->findModel($id);
        $user = User::findOne($this->getMasterEmployees($id)['employees_id']);
        if($this->countMasterEmployeesMedia($model->id) > 0){
            $medias_ = Medias::findOne($this->getMasterEmployeesMedia($model->id)['medias_id']);
        }else{
            $medias_ = null;
        }
        $medias = new Medias();
        $masterEmployeesMedia = new MasterEmployeesMedia();
        
        return $this->render('contentwriter-view', [
            'model' => $model,
            'user' => $user,
            'medias_' => $medias_,
            'medias' => $medias,
        ]);
    }
    
    /**
     * Creates a new Employees model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Employees();
        $user = new User();
        $masterEmployees = new MasterEmployees();
        $masterEmployeesMedia = new MasterEmployeesMedia();
        $medias = new Medias();
        $previleges = ArrayHelper::map(Previleges::find()->all(), 'id', 'previlege');
        
        if($model->load(\Yii::$app->request->post())){
            $email = \Yii::$app->request->post()['User']['username'];
            $password = \Yii::$app->request->post()['User']['password'];
            $passwordHint = \Yii::$app->request->post()['User']['password_hint'];
            $previlegesID = \Yii::$app->request->post()['User']['previleges_id'];
            if($user->getUser($email) === true ){
                $user->actionUser(null, $email, $password, $passwordHint, $previlegesID);
                if(Yii::$app->request->post()['Employees']['description'] == null){
                //$model->description = ucwords($model->first_name.' '. $model->last_name); 
            }
                $model->status = 1;
                if($model->validate(false)){
                    $model->status = 1;
                    $model->save(false);
                    $employeesID = $model->id;
                    $description = $model->description;
                    $rate = 0;
                    $masterEmployees->saveMasterEmployees($user->setUser($email)['id'], $employeesID, $rate);
                    if($medias->load(\Yii::$app->request->post())){
                        $medias->uploadEmployeesMedia(null, $employeesID, $description);
                    }else{
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
            'masterEmployees' => $masterEmployees,
            'masterEmployeesMedia' => $masterEmployeesMedia,
            'user' => $user,
            'medias' => $medias,
            'previleges' => $previleges,
        ]);
    }

    /**
     * Updates an existing Employees model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $user = User::findOne($this->getMasterEmployees($id)['user_id']);

        if($this->countMasterEmployeesMedia($model->id) > 0){
            $medias_ = Medias::findOne($this->getMasterEmployeesMedia($model->id)['medias_id']);
        }else{
            $medias_ = null;
        }
        
        $medias = new Medias();
        $masterEmployeesMedia = new MasterEmployeesMedia();
        
        if($model->load(Yii::$app->request->post())){
            if(isset(\Yii::$app->request->post()['User']['username'])){
                $email = Yii::$app->request->post()['User']['username'];
            } else {
                $email = null;
            }
            
            if(isset(Yii::$app->request->post()['User']['password'])){
                $password = Yii::$app->request->post()['User']['password'];
            } else {
                $password = null;
            }
            
            if((isset(Yii::$app->request->post()['User']['password_hint']))){
                $passwordHint = \Yii::$app->request->post()['User']['password_hint'];
            }else{
                $passwordHint = null;
            }
            
            if(isset(\Yii::$app->request->post()['User']['previleges_id'])){
                $previlegesID = \Yii::$app->request->post()['User']['previleges_id'];
            } else {
                $previlegesID = null;
            }
            
            $uid = $user->id;
            $user->actionUser($uid, $email, $password, $passwordHint, $previlegesID);
            if($model->validate()){
                $model->update();
                if(Yii::$app->request->post('foto_x') == "1"){
                    $masterEmployeesMedia->deleteEmployeesFoto($id);
                    $medias->deleteMedia();
                } else {
                    if($medias->load(\Yii::$app->request->post())){
                        $description = $model->first_name . ' ' . $model->last_name;
                        if($this->countMasterEmployeesMedia($model->id) > 0){
                            $medias->uploadEmployeesMedia($masterEmployeesMedia->getEmployeesFoto($id)['medias_id'], $id, $description);
                        } else {
                            $medias->uploadEmployeesMedia(null, $id, $description);
                        } 
                    } else {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
            'user' => $user,
            'medias' => $medias,
            'medias_' => $medias_,
            'masterEmployeesMedia' => $masterEmployeesMedia,
        ]);
    }

    /**
     * Updates an existing Employees model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionContentwriterUpdate($id)
    {
        $model = $this->findModel($id);
        $user = User::findOne($this->getMasterEmployees($id)['user_id']);

        if($this->countMasterEmployeesMedia($model->id) > 0){
            $medias_ = Medias::findOne($this->getMasterEmployeesMedia($model->id)['medias_id']);
        }else{
            $medias_ = null;
        }
        
        $medias = new Medias();
        $masterEmployeesMedia = new MasterEmployeesMedia();
        
        if($model->load(Yii::$app->request->post())){
            if(isset(\Yii::$app->request->post()['User']['username'])){
                $email = Yii::$app->request->post()['User']['username'];
            } else {
                $email = null;
            }
            
            if(isset(Yii::$app->request->post()['User']['password'])){
                $password = Yii::$app->request->post()['User']['password'];
            } else {
                $password = null;
            }
            
            if((isset(Yii::$app->request->post()['User']['password_hint']))){
                $passwordHint = \Yii::$app->request->post()['User']['password_hint'];
            }else{
                $passwordHint = null;
            }
            
            $uid = $user->id;
            $user->actionUser($uid, $email, $password, $passwordHint, 2);
            if($model->validate()){
                $model->update();
                if(Yii::$app->request->post('foto_x') == "1"){
                    $masterEmployeesMedia->deleteEmployeesFoto($id);
                    $medias->deleteMedia();
                } else {
                    if($medias->load(\Yii::$app->request->post())){
                        $description = $model->first_name . ' ' . $model->last_name;
                        if($this->countMasterEmployeesMedia($model->id) > 0){
                            $medias->uploadEmployeesMedia($masterEmployeesMedia->getEmployeesFoto($id)['medias_id'], $id, $description);
                        } else {
                            $medias->uploadEmployeesMedia(null, $id, $description);
                        } 
                    } else {
                        return $this->redirect(['contentwriter-view', 'id' => $model->id]);
                    }
                }
            }
            return $this->redirect(['contentwriter-view', 'id' => $model->id]);
        }
        return $this->render('contentwriter-update', [
            'model' => $model,
            'user' => $user,
            'medias' => $medias,
            'medias_' => $medias_,
            'masterEmployeesMedia' => $masterEmployeesMedia,
        ]);
    }
    
    /**
     * Updates an existing Employees model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionContentwriterChangepass($id) {
        $model = $this->findModel($id);
        $user = User::findOne($this->getMasterEmployees($id)['user_id']);

        if($this->countMasterEmployeesMedia($model->id) > 0){
            $medias_ = Medias::findOne($this->getMasterEmployeesMedia($model->id)['medias_id']);
        }else{
            $medias_ = null;
        }
        
        $medias = new Medias();
        $masterEmployeesMedia = new MasterEmployeesMedia();
        
        if($user->load(Yii::$app->request->post())){
            
            if(isset(Yii::$app->request->post()['new_password'])){
                $password = Yii::$app->request->post()['new_password'];
            } else {
                $password = null;
            }
            
            if((isset(Yii::$app->request->post()['new_password-hint']))){
                $passwordHint = \Yii::$app->request->post()['new_password-hint'];
            }else{
                $passwordHint = null;
            }
            
            $uid = $user->id;
            $user->actionUser($uid, null, $password, $passwordHint, 2);
            
            //echo $uid .' ' . $password .' ' . $passwordHint;
            
            return $this->redirect(['contentwriter-view', 'id' => $model->id]);
        }
        
        return $this->render('contentwriter-changepass', [
            'model' => $model,
            'user' => $user,
            'medias' => $medias,
            'medias_' => $medias_,
            'masterEmployeesMedia' => $masterEmployeesMedia,
        ]);
        
    }
    
    /**
     * Deletes an existing Employees model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Employees model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Employees the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employees::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function getMasterEmployees($id) {
        $query = (new Query())
                ->select('*')
                ->from('master_employees')
                ->where(['=', 'employees_id', $id]);
        return $query->createCommand()->queryOne();
    }
    protected function getMasterEmployeesMedia($id) 
    {
        $query = (new Query())
                ->select('*')
                ->from('master_employees_media')
                ->where(['=', 'employees_id', $id]);
        return $query->createCommand()->queryOne();
    }
    
    protected function countMasterEmployeesMedia($id) 
    {
        $query = (new Query())
                ->select('*')
                ->from('master_employees_media')
                ->where(['=', 'employees_id', $id]);
        return $query->createCommand()->query()->count();
    }
    protected function getMedias($id) 
    {
        $query = (new Query())
                ->select('*')
                ->from('medias')
                ->where(['=', 'id', $this->getMasterEmployees($id)['medias_id']]);
        return $query->createCommand()->queryOne();
    }
    
    protected function getUser($id) 
    {
        $query = (new Query())
                ->select('*')
                ->from('user')
                ->where(['=', 'id', $this->getMasterEmployees($id)['employees_id']]);
        return $query->createCommand()->queryOne();
    }
    
    protected function tempDelete($id) 
    {
        $model = $this->findModel($id);
        $model->status = 0;
        return $model->update();
    }
}
