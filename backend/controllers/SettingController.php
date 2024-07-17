<?php

namespace backend\controllers;

use Yii;
use common\models\Articles;
use common\models\MasterArticles;
use common\models\MasterArticlesMedia;
use common\models\Medias;
use common\models\ArticleCategories;
use common\models\MasterEmployees;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\data\Pagination;

class SettingController extends Controller
{
    const SETTING = 22;
    const ACTIVE_STATUS = 1;
    const NOTACTIVE_STATUS = 0;
    const POSITION_LIVE = 1;
    const POSITION_DRAFT = 0;
    const POSITION_TRASH = 10;
    
    
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }
    
    
    public function actionIndex() {
        $q = \Yii::$app->request->get('q');
        if(!isset($q)){
            $articlesQuery = new Query();
            $articlesQuery->select('articles.*, articles.id as article_id, articles.description as articles_desc, master_articles.*, master_articles.id as m_article_id, master_articles_media.*, master_articles_media.id as m_articles_media_id, medias.*, medias.id as m_id, employees.*, employees.id as em_id, article_categories.*, article_categories.id as articles_cat_id')
                    ->from('articles')
                    ->join('LEFT JOIN', 'master_articles', 'master_articles.articles_id = articles.id')
                    ->join('LEFT JOIN', 'master_articles_media', 'master_articles_media.master_articles_id = master_articles.id')
                    ->join('LEFT JOIN', 'article_categories', 'article_categories.id = master_articles.article_categories_id')
                    ->join('LEFT JOIN', 'employees', 'employees.id = master_articles.employees_id')
                    ->join('LEFT JOIN', 'medias', 'medias.id = master_articles_media.medias_id')
                    ->join('LEFT JOIN', 'master_employees', 'master_employees.employees_id = employees.id')
                    ->join('LEFT JOIN', 'user', 'user.id = master_employees.employees_id = employees.id')
                    ->join('LEFT JOIN', 'previleges', 'previleges.id = user.previleges_id')
                    ->where(['article_categories_id' => self::SETTING])
                    ->andWhere(['articles.status' => self::ACTIVE_STATUS])
                    ->andWhere(['articles.position' => self::POSITION_LIVE])
                    ->andWhere(['master_articles.employees_id' => $this->getEmployeesID()])
                    ->orderBy(['articles.id' => SORT_DESC])
                    ->all();
        }else if($q !== null){
            $articlesQuery = new Query();
            $articlesQuery->select('articles.*, articles.id as article_id, master_articles.*, master_articles.id as m_article_id, master_articles_media.*, master_articles_media.id as m_articles_media_id, medias.*, medias.id as m_id, employees.*, employees.id as em_id, article_categories.*, article_categories.id as articles_cat_id')
                    ->from('articles')
                    ->join('LEFT_JOIN', 'master_artices', 'master_articles.articles_id = articles.id')
                    ->join('LEFT JOIN', 'master_articles_media', 'master_articles_media.master_articles_id = master_articles.id')
                    ->join('LEFT JOIN', 'article_categories', 'article_categories.id = master_articles.article_categories_id')
                    ->join('LEFT JOIN', 'employees', 'employees.id = master_articles.employees_id')
                    ->join('LEFT jOIN', 'medias', 'medias.id = master_articles_media.medias.id')
                    ->join('LEFT JOIN', 'master_employees', 'master_employees.employees_id = employees.id')
                    ->join('LEFT JOIN', 'user', 'user.id = master_employees.user_id')
                    ->join('LEFT JOIN', 'previleges', 'previleges.id = user.previleges_id')
                    ->where(['LIKE', 'articles.title', $q])
                    ->orWhere(['LIKE', 'articles.article', $q])
                    ->orWhere(['LIKE', 'medias.media', $q])
                    ->orWhere(['LIKE', 'files.file', $q])
                    ->orWhere(['LIKE', 'employees.first_name', $q])
                    ->orWhere(['LIKE', 'employees.last_name', $q])
                    ->andWhere(['article_categories_id' => self::SETTING])
                    ->andWhere(['article.status' => self::ACTIVE_STATUS])
                    ->andWhere(['article.position' => self::POSITION_LIVE])
                    ->andWhere(['master_articles.employees_id' => $this->getEmployeesID()])
                    ->orderBy(['articles.id' => SORT_DESC])
                    ->all();
        }
        $countarticles = $articlesQuery->count();
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $countarticles,
        ]);
        
        $articles = $articlesQuery->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        
        return $this->render('index', [
            'countarticles' => $countarticles,
            'articles' => $articles,
            'pagination' => $pagination,
            'q' => $q,
        ]);
    }
    
    public function actionCreate() {
        $model = new Articles();
        $medias = new Medias();
        $masterArticles = new MasterArticles();
        $masterMedias = new MasterArticlesMedia();
        $model->mini_title = 'Corp Identity';
        $dateNow = new \DateTime();
        $model->date = $dateNow->format("Y-m-d");
        $model->article = 'Corp Identity';
        $model->status = self::ACTIVE_STATUS;
        $model->position = self::POSITION_LIVE;
        if($model->load(Yii::$app->request->post())){
            if($model->validate(false)){
                $model->save(false);
                $masterArticles->article_categories_id = self::SETTING;
                $masterArticles->articles_id = $model->id;
                $masterArticles->viewer = 0;
                $masterArticles->rate = 0;
                $masterArticles->comments = 0;
                $masterArticles->employees_id = \Yii::$app->usershow->findEmployees(\Yii::$app->user->identity->id)->id;
                //if($masterArticles->load(Yii::$app->request->post())){
                if($masterArticles->validate()){
                    $masterArticles->save();
                    $masterArticlesID = $masterArticles->id;
                    if($medias->load(\Yii::$app->request->post())){
                        $medias->uploadPublicMedia(null, $masterArticlesID, $medias->description);
                    }else{
                        return $this->redirect(['view', 'id'=>$model->id]);
                    }
                }
                //}
            return $this->redirect(['view', 'id'=>$model->id]);
            }else{
                return $this->render('create',[
                    'model' => $model,
                    'medias' => $medias,
                    'masterArticles' => $masterArticles,
                    'masterMedias' => $masterMedias,
                ]);
            }
        }
        return $this->render('create',[
            'model' => $model,
            'medias' => $medias,
            'masterArticles' => $masterArticles,
            'masterMedias' => $masterMedias,
        ]);
    }
    
    
    public function actionView($id) {
        $model = $this->findModel($id);
        $masterArticles = MasterArticles::find()->where(['articles_id' => $model->id])->one();
        $masterMedias = MasterArticlesMedia::find()->where(['master_articles_id' => $masterArticles->id])->one();
        $countMasterMedias = MasterArticlesMedia::find()->where(['master_articles_id' => $masterArticles->id])->count();
        if($countMasterMedias > 0){
            $countMedias = Medias::find()->where(['id' => $masterMedias->medias_id])->count();
            $medias = Medias::find()->where(['id' => $masterMedias->medias_id])->one();
        }else{
            $countMedias = 0;
            $medias = NULL;
        }
        $keywords = explode(',', $model->tags);
        return $this->render('view',[
            'model' => $model,
            'countMasterMedias' => $countMasterMedias,
            'medias' => $medias,
            'keywords' => $keywords,
        ]);
    }
    
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $masterArticles = MasterArticles::find()->where(['articles_id' => $model->id])->one();
        $masterMedias = MasterArticlesMedia::find()->where(['master_articles_id' => $masterArticles->id])->one();
        $countMasterMedias = MasterArticlesMedia::find()->where(['master_articles_id' => $masterArticles->id])->count();
        
        if($countMasterMedias > 0){
            $countMedias = Medias::find()->where(['id' => $masterMedias->medias_id])->count();
            $medias = Medias::find()->where(['id' => $masterMedias->medias_id])->one();
            $mediasID = $medias->id;
        }else{
            $countMedias = 0;
            $medias = new Medias();
            $mediasID = null;
        }
        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                $model->update();
                $masterArticles->articles_id = $model->id;
                $masterArticlesID = $masterArticles->id;
                if(Yii::$app->request->post('foto_x') == "1"){
                    $medias_delete = true;
                    $this->handleDeleteMedia($mediasID);
                }else{
                    $medias_delete = false;
                }
                if($medias->load(Yii::$app->request->post())){
                    $mediaDescription = Yii::$app->request->post()['Medias']['description'];
                    $this->handleUpdateMedia($mediasID, $masterArticlesID,$mediaDescription);
                }else{
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
            'masterMedias' => $masterMedias,
            'countMedias' => $countMedias,
            'medias' => $medias,
        ]);
    }
    
    /**
     * Finds the Articles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Articles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Articles::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function getEmployeesID() 
    {
        if(Yii::$app->user->isGuest){
            Yii::$app->response->redirect('/site/login');
        }else{
            $userID = \Yii::$app->user->identity->getId();
            $employeesID = MasterEmployees::findOne(['user_id' => $userID])->employees_id;
            return $employeesID;
        }
    }
    
    protected function handleUpdateMedia($mediasID, $publicArticlesID, $description=null) 
    {
        $medias = new Medias();
        
        if(!isset($description)){
            return false;
        }else{
            $now = date_create('now')->format('Y-m-d H:i:s');
            $query = new Query();
            $query->createCommand()->update('medias', ['description' => $description,'modified_timestamp' => $now], ['id' => $mediasID])->execute();
        }
        
        if($mediasID != null){
            return $medias->uploadPublicMedia($mediasID, $publicArticlesID, $description);
        }else{
            return $medias->uploadPublicMedia(null, $publicArticlesID, $description);
        }
    }
    
    protected function handleDeleteMedia($mediasID) 
    {
        $medias = new Medias();
        $masterArticlesMedia = MasterArticlesMedia::find()->where(['medias_id' => $mediasID])->one();
        $masterArticlesMedia->delete();
        $medias->tempDeleteMedia($mediasID);
        return $medias->deleteMedia();
    }
    
    
    
}