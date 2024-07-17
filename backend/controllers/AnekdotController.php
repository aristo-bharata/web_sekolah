<?php

namespace backend\controllers;

use Yii;
use common\models\Articles;
use common\models\MasterArticles;
use common\models\ArticlesSearch;
use common\models\Medias;
use common\models\MasterArticlesMedia;
use common\models\Employees;
use common\models\MasterEmployees;
use common\models\ArticleCategories;
use common\models\ArticleTypes;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\data\Pagination;





class AnekdotController extends Controller{
    
    const ARTICLES = array(1,2,3,4,5,6,7,8,9,10,11,13,14,15);
    const BLOG = array(1,2,3,4,5,6,7,8,9,10,11);
    const GALERI = array(13,14,15);
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
    
    public function actionContentwriterTrash() 
    {
        $q = \Yii::$app->request->get('q');
        if(!isset($q)){
            $articlesQuery = new Query();
            $articlesQuery->select('articles.*, articles.id as article_id, articles.description as articles_desc, master_articles.*, master_articles.id as m_article_id, master_articles_media.*, master_articles_media.id as m_articles_media_id, master_articles_file.*, master_articles_file.id as m_articles_file_id, medias.*, medias.id as m_id, files.*, files.id as f_id, employees.*, employees.id as em_id, article_categories.*, article_categories.id as articles_cat_id')
                    ->from('articles')
                    ->join('LEFT JOIN', 'master_articles', 'master_articles.articles_id = articles.id')
                    ->join('LEFT JOIN', 'master_articles_media', 'master_articles_media.master_articles_id = master_articles.id')
                    ->join('LEFT JOIN', 'master_articles_file', 'master_articles_file.master_articles_id = master_articles.id')
                    ->join('LEFT JOIN', 'article_categories', 'article_categories.id = master_articles.article_categories_id')
                    ->join('LEFT JOIN', 'employees', 'employees.id = master_articles.employees_id')
                    ->join('LEFT JOIN', 'medias', 'medias.id = master_articles_media.medias_id')
                    ->join('LEFT JOIN', 'files', 'files.id = master_articles_file.files_id')
                    ->join('LEFT JOIN', 'master_employees', 'master_employees.employees_id = employees.id')
                    ->join('LEFT JOIN', 'user', 'user.id = master_employees.employees_id = employees.id')
                    ->join('LEFT JOIN', 'previleges', 'previleges.id = user.previleges_id')
                    ->where(['article_categories_id' => self::ARTICLES])
                    ->andWhere(['articles.status' => self::NOTACTIVE_STATUS])
                    ->andWhere(['articles.position' => self::POSITION_TRASH])
                    ->andWhere(['master_articles.employees_id' => $this->getEmployeesID()])
                    ->orderBy(['articles.id' => SORT_DESC])
                    ->all();
        }else if($q !== null){
            $articlesQuery = new Query();
            $articlesQuery->select('articles.*, articles.id as article_id, master_articles.*, master_articles.id as m_article_id, master_articles_media.*, master_articles_media.id as m_articles_media_id, master_articles_file.*, master_articles_file.id as m_articles_file_id, medias.*, medias.id as m_id, medias.description as m_desc, files.*, files.id as f_id, employees.*, employees.id as em_id, article_categories.*, article_categories.id as articles_cat_id')
                    ->from('articles')
                    ->join('LEFT_JOIN', 'master_artices', 'master_articles.articles_id = articles.id')
                    ->join('LEFT JOIN', 'master_articles_media', 'master_articles_media.master_articles_id = master_articles.id')
                    ->join('LEFT JOIN', 'master_articles_file', 'master_articles_file.master_articles_id = master_articles.id')
                    ->join('LEFT JOIN', 'article_categories', 'article_categories.id = master_articles.article_categories_id')
                    ->join('LEFT JOIN', 'employees', 'employees.id = master_articles.employees_id')
                    ->join('LEFT jOIN', 'medias', 'medias.id = master_articles_media.medias.id')
                    ->join('LEFT JOIN', 'files', 'files.id = master_articles_file.files_id')
                    ->join('LEFT JOIN', 'master_employees', 'master_employees.employees_id = employees.id')
                    ->join('LEFT JOIN', 'user', 'user.id = master_employees.user_id')
                    ->join('LEFT JOIN', 'previleges', 'previleges.id = user.previleges_id')
                    ->where(['LIKE', 'articles.title', $q])
                    ->orWhere(['LIKE', 'articles.article', $q])
                    ->orWhere(['LIKE', 'medias.media', $q])
                    ->orWhere(['LIKE', 'files.file', $q])
                    ->orWhere(['LIKE', 'employees.first_name', $q])
                    ->orWhere(['LIKE', 'employees.last_name', $q])
                    ->andWhere(['article_categories_id' => self::ARTICLES])
                    ->andWhere(['articles.status' => self::NOTACTIVE_STATUS])
                    ->andWhere(['articles.position' => self::POSITION_TRASH])
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
        return $this->render('contentwriter-trash', [
            'articles' => $articles,
            'pagination' => $pagination,
            'q' => $q,
        ]);
    }
    
    public function actionAdminTrash() 
    {
        $q = \Yii::$app->request->get('q');
        if(!isset($q)){
            $articlesQuery = new Query();
            $articlesQuery->select('articles.*, articles.id as article_id, articles.description as articles_desc, master_articles.*, master_articles.id as m_article_id, master_articles_media.*, master_articles_media.id as m_articles_media_id, master_articles_file.*, master_articles_file.id as m_articles_file_id, medias.*, medias.id as m_id, files.*, files.id as f_id, employees.*, employees.id as em_id, article_categories.*, article_categories.id as articles_cat_id')
                    ->from('articles')
                    ->join('LEFT JOIN', 'master_articles', 'master_articles.articles_id = articles.id')
                    ->join('LEFT JOIN', 'master_articles_media', 'master_articles_media.master_articles_id = master_articles.id')
                    ->join('LEFT JOIN', 'master_articles_file', 'master_articles_file.master_articles_id = master_articles.id')
                    ->join('LEFT JOIN', 'article_categories', 'article_categories.id = master_articles.article_categories_id')
                    ->join('LEFT JOIN', 'employees', 'employees.id = master_articles.employees_id')
                    ->join('LEFT JOIN', 'medias', 'medias.id = master_articles_media.medias_id')
                    ->join('LEFT JOIN', 'files', 'files.id = master_articles_file.files_id')
                    ->join('LEFT JOIN', 'master_employees', 'master_employees.employees_id = employees.id')
                    ->join('LEFT JOIN', 'user', 'user.id = master_employees.employees_id = employees.id')
                    ->join('LEFT JOIN', 'previleges', 'previleges.id = user.previleges_id')
                    ->where(['article_categories_id' => self::ARTICLES])
                    ->andWhere(['articles.status' => self::NOTACTIVE_STATUS])
                    ->andWhere(['articles.position' => self::POSITION_TRASH])
                    //->andWhere(['master_articles.employees_id' => $this->getEmployeesID()])
                    ->orderBy(['articles.id' => SORT_DESC])
                    ->all();
        }else if($q !== null){
            $articlesQuery = new Query();
            $articlesQuery->select('articles.*, articles.id as article_id, master_articles.*, master_articles.id as m_article_id, master_articles_media.*, master_articles_media.id as m_articles_media_id, master_articles_file.*, master_articles_file.id as m_articles_file_id, medias.*, medias.id as m_id, medias.description as m_desc, files.*, files.id as f_id, employees.*, employees.id as em_id, article_categories.*, article_categories.id as articles_cat_id')
                    ->from('articles')
                    ->join('LEFT_JOIN', 'master_artices', 'master_articles.articles_id = articles.id')
                    ->join('LEFT JOIN', 'master_articles_media', 'master_articles_media.master_articles_id = master_articles.id')
                    ->join('LEFT JOIN', 'master_articles_file', 'master_articles_file.master_articles_id = master_articles.id')
                    ->join('LEFT JOIN', 'article_categories', 'article_categories.id = master_articles.article_categories_id')
                    ->join('LEFT JOIN', 'employees', 'employees.id = master_articles.employees_id')
                    ->join('LEFT jOIN', 'medias', 'medias.id = master_articles_media.medias.id')
                    ->join('LEFT JOIN', 'files', 'files.id = master_articles_file.files_id')
                    ->join('LEFT JOIN', 'master_employees', 'master_employees.employees_id = employees.id')
                    ->join('LEFT JOIN', 'user', 'user.id = master_employees.user_id')
                    ->join('LEFT JOIN', 'previleges', 'previleges.id = user.previleges_id')
                    ->where(['LIKE', 'articles.title', $q])
                    ->orWhere(['LIKE', 'articles.article', $q])
                    ->orWhere(['LIKE', 'medias.media', $q])
                    ->orWhere(['LIKE', 'files.file', $q])
                    ->orWhere(['LIKE', 'employees.first_name', $q])
                    ->orWhere(['LIKE', 'employees.last_name', $q])
                    ->andWhere(['article_categories_id' => self::ARTICLES])
                    ->andWhere(['articles.status' => self::NOTACTIVE_STATUS])
                    ->andWhere(['articles.position' => self::POSITION_TRASH])
                    //->andWhere(['master_articles.employees_id' => $this->getEmployeesID()])
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
        return $this->render('admin-trash', [
            'articles' => $articles,
            'pagination' => $pagination,
            'q' => $q,
        ]);
    }
    
    public function actionAdminRollback($id) 
    {
        $model = $this->findModel($id);
        $model->status = self::ACTIVE_STATUS;
        $model->position = self::POSITION_DRAFT;
        if($model->update()){
            $path = $this->getCategoriesPath($model->id);
            $message = 'Rollback Success';
            return $this->render('admin-rollback',[
                'model' => $model,
                'path' => $path,
                'message' => $message,
            ]);
        }else{
            $message = 'Rollback Unsuccess, call administrator';
            return $this->render('admin-rollback',[
                'message' => $message,
            ]);
        }
    }
    
    public function actionContentwriterRollback($id) 
    {
        $model = $this->findModel($id);
        $model->status = self::ACTIVE_STATUS;
        $model->position = self::POSITION_DRAFT;
        if($model->update() !== false){
            $path = $this->getCategoriesPath($model->id);
            $message = 'Rollback Success';
            return $this->render('contentwriter-rollback',[
                'model' => $model,
                'path' => $path,
                'message' => $message,
            ]);
        }else{
            $message = 'Rollback Unsuccess, call administrator';
            return $this->render('contentwriter-rollback',[
                'message' => $message,
            ]);
        }
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
    
    protected function getCategoriesPath($id) {
        $masterArticles = MasterArticles::find()->where(['articles_id' => $id])->one();
        $categories = ArticleCategories::find()->where(['id' => $masterArticles->article_categories_id])->one();
        $articleType = ArticleTypes::find()->where(['id' => $categories->article_types_id])->one();
        
        switch ($articleType->id){
            case 1: //blogs
                $categoriesPath = 'blogs';
                break;
            case 2: //galleries
                $categoriesPath = 'galleries';
                break;
            case 3: //regulation
                $categoriesPath = 'regulation';
                break;
            case 4: //regulation
                $categoriesPath = 'regulation';
                break;
            case 5: //regulation
                $categoriesPath = 'regulation';
                break;
            case 6: //regulation
                $categoriesPath = 'regulation';
                break;
            case 7: //regulation
                $categoriesPath = 'regulation';
                break;
            case 8: //regulation
                $categoriesPath = 'advertising';
                break;
            case 9: //regulation
                $categoriesPath = 'recruitment';
                break;
            case 10: //regulation
                $categoriesPath = 'help';
                break;
            default: //employees
                $categoriesPath = 'employees';
                break;
        }
        
        return $categoriesPath;
    }
}