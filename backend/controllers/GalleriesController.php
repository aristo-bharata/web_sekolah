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
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\data\Pagination;

/**
 * GalleriesController implements the CRUD actions for Articles model.
 */
class GalleriesController extends Controller
{
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

    /**
     * Lists all Articles models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $q = Yii::$app->request->get('q');
        if(!isset($q)){
            $galeriQuery = new Query();
            $galeriQuery->select('articles.*, articles.id as article_id, articles.description as articles_desc, master_articles.*, master_articles.id as m_article_id, master_articles_media.*, master_articles_media.id as m_articles_media_id, master_articles_file.*, master_articles_file.id as m_articles_file_id, medias.*, medias.id as m_id, files.*, files.id as f_id, employees.*, employees.id as em_id, article_categories.*, article_categories.id as articles_cat_id')
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
                    ->where(['article_categories_id' => self::GALERI])
                    ->andWhere(['articles.status' => self::ACTIVE_STATUS])
                    ->andWhere(['articles.position' => self::POSITION_LIVE])
                    ->andWhere(['master_articles.employees_id' => $this->getEmployeesID()])
                    ->orderBy(['articles.id' => SORT_DESC])
                    ->all();
        }else if($q !== null){
            $galeriQuery = new Query();
            $galeriQuery->select('articles.*, articles.id as article_id, master_articles.*, master_articles.id as m_article_id, master_articles_media.*, master_articles_media.id as m_articles_media_id, master_articles_file.*, master_articles_file.id as m_articles_file_id, medias.*, medias.id as m_id, files.*, files.id as f_id, employees.*, employees.id as em_id, article_categories.*, article_categories.id as articles_cat_id')
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
                    ->andWhere(['in', 'article_categories_id', $this->getAllArticleCategories(self::GALERI)])
                    ->andWhere(['article.status' => self::ACTIVE_STATUS])
                    ->andWhere(['article.position' => self::POSITION_LIVE])
                    ->orderBy(['articles.id' => SORT_DESC])
                    ->all();
        }
        $countgaleri = $galeriQuery->count();
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $countgaleri,
        ]);
        
        $galeries = $galeriQuery->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        
        return $this->render('index', [
            'galeries' => $galeries,
            'pagination' => $pagination,
            'q' => $q,
        ]);
    }
    
    public function actionAdminIndex() {
        $q = \Yii::$app->request->get('q');
        if(!isset($q)){
            $galeriQuery = new Query();
            $galeriQuery->select('articles.*, articles.id as article_id, articles.description as articles_desc, master_articles.*, master_articles.id as m_article_id, master_articles_media.*, master_articles_media.id as m_articles_media_id, master_articles_file.*, master_articles_file.id as m_articles_file_id, medias.*, medias.id as m_id, files.*, files.id as f_id, employees.*, employees.id as em_id, article_categories.*, article_categories.id as articles_cat_id')
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
                    ->where(['article_categories_id' => self::GALERI])
                    ->andWhere(['articles.status' => self::ACTIVE_STATUS])
                    ->andWhere(['articles.position' => self::POSITION_LIVE])
                    ->orderBy(['articles.id' => SORT_DESC])
                    ->all();
        }else if($q !== null){
            $galeriQuery = new Query();
            $galeriQuery->select('articles.*, articles.id as article_id, master_articles.*, master_articles.id as m_article_id, master_articles_media.*, master_articles_media.id as m_articles_media_id, master_articles_file.*, master_articles_file.id as m_articles_file_id, medias.*, medias.id as m_id, medias.description as m_desc, files.*, files.id as f_id, employees.*, employees.id as em_id, article_categories.*, article_categories.id as articles_cat_id')
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
                    ->andWhere(['in', 'article_categories_id', $this->getAllArticleCategories(self::GALERI)])
                    ->andWhere(['article.status' => self::ACTIVE_STATUS])
                    ->andWhere(['article.position' => self::POSITION_DRAFT])
                    ->orderBy(['articles.id' => SORT_DESC])
                    ->all();
        }
        $countgaleri = $galeriQuery->count();
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $countgaleri,
        ]);
        
        $galeries = $galeriQuery->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        
        return $this->render('admin-index', [
            'galeries' => $galeries,
            'pagination' => $pagination,
            'q' => $q,
        ]);
    }
    
    public function actionContentwriterIndex() {
        $q = \Yii::$app->request->get('q');
        if(!isset($q)){
            $galeriQuery = new Query();
            $galeriQuery->select('articles.*, articles.id as article_id, articles.description as articles_desc, master_articles.*, master_articles.id as m_article_id, master_articles_media.*, master_articles_media.id as m_articles_media_id, master_articles_file.*, master_articles_file.id as m_articles_file_id, medias.*, medias.id as m_id, files.*, files.id as f_id, employees.*, employees.id as em_id, article_categories.*, article_categories.id as articles_cat_id')
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
                    ->where(['article_categories_id' => self::GALERI])
                    ->andWhere(['articles.status' => self::ACTIVE_STATUS])
                    ->andWhere(['articles.position' => self::POSITION_LIVE])
                    ->andWhere(['master_articles.employees_id' => $this->getEmployeesID()])
                    ->orderBy(['articles.id' => SORT_DESC])
                    ->all();
        }else if($q !== null){
            $galeriQuery = new Query();
            $galeriQuery->select('articles.*, articles.id as article_id, master_articles.*, master_articles.id as m_article_id, master_articles_media.*, master_articles_media.id as m_articles_media_id, master_articles_file.*, master_articles_file.id as m_articles_file_id, medias.*, medias.id as m_id, medias.description as m_desc, files.*, files.id as f_id, employees.*, employees.id as em_id, article_categories.*, article_categories.id as articles_cat_id')
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
                    ->andWhere(['article_categories_id', $this->getAllArticleCategories(self::GALERI)])
                    ->andWhere(['article.status' => self::ACTIVE_STATUS])
                    ->andWhere(['article.position' => self::POSITION_DRAFT])
                    ->andWhere(['master_articles.employees_id' => $this->getEmployeesID()])
                    ->orderBy(['articles.id' => SORT_DESC])
                    ->all();
        }
        $countgaleri = $galeriQuery->count();
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $countgaleri,
        ]);
        
        $galeries = $galeriQuery->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        
        return $this->render('contentwriter-index', [
            'galeries' => $galeries,
            'pagination' => $pagination,
            'q' => $q,
        ]);
    }
    
    public function actionAdminDraft() 
    {
        $q = \Yii::$app->request->get('q');
        if(!isset($q)){
            $galeriQuery = new Query();
            $galeriQuery->select('articles.*, articles.id as article_id, articles.description as articles_desc, master_articles.*, master_articles.id as m_article_id, master_articles_media.*, master_articles_media.id as m_articles_media_id, master_articles_file.*, master_articles_file.id as m_articles_file_id, medias.*, medias.id as m_id, files.*, files.id as f_id, employees.*, employees.id as em_id, article_categories.*, article_categories.id as articles_cat_id')
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
                    ->where(['article_categories_id' => self::GALERI])
                    ->andWhere(['articles.status' => self::ACTIVE_STATUS])
                    ->andWhere(['articles.position' => self::POSITION_DRAFT])
                    ->orderBy(['articles.id' => SORT_DESC])
                    ->all();
        }else if($q !== null){
            $galeriQuery = new Query();
            $galeriQuery->select('articles.*, articles.id as article_id, master_articles.*, master_articles.id as m_article_id, master_articles_media.*, master_articles_media.id as m_articles_media_id, master_articles_file.*, master_articles_file.id as m_articles_file_id, medias.*, medias.id as m_id, medias.description as m_desc, files.*, files.id as f_id, employees.*, employees.id as em_id, article_categories.*, article_categories.id as articles_cat_id')
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
                    ->andWhere(['article_categories_id' => self::BLOG])
                    ->andWhere(['article.status' => self::ACTIVE_STATUS])
                    ->andWhere(['articles.position' => self::POSITION_DRAFT])
                    ->orderBy(['articles.id' => SORT_DESC])
                    ->all();
        }
        $countgaleri = $galeriQuery->count();
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $countgaleri,
        ]);
        
        $galeries = $galeriQuery->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        return $this->render('admin-draft', [
            'galeries' => $galeries,
            'pagination' => $pagination,
            'q' => $q,
        ]);
    }
    
    public function actionContentwriterDraft() 
    {
        $q = \Yii::$app->request->get('q');
        if(!isset($q)){
            $galeriQuery = new Query();
            $galeriQuery->select('articles.*, articles.id as article_id, articles.description as articles_desc, master_articles.*, master_articles.id as m_article_id, master_articles_media.*, master_articles_media.id as m_articles_media_id, master_articles_file.*, master_articles_file.id as m_articles_file_id, medias.*, medias.id as m_id, files.*, files.id as f_id, employees.*, employees.id as em_id, article_categories.*, article_categories.id as articles_cat_id')
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
                    ->where(['article_categories_id' => self::GALERI])
                    ->andWhere(['articles.status' => self::ACTIVE_STATUS])
                    ->andWhere(['articles.position' => self::POSITION_DRAFT])
                    ->andWhere(['master_articles.employees_id' => $this->getEmployeesID()])
                    ->orderBy(['articles.id' => SORT_DESC])
                    ->all();
        }else if($q !== null){
            $galeriQuery = new Query();
            $galeriQuery->select('articles.*, articles.id as article_id, master_articles.*, master_articles.id as m_article_id, master_articles_media.*, master_articles_media.id as m_articles_media_id, master_articles_file.*, master_articles_file.id as m_articles_file_id, medias.*, medias.id as m_id, medias.description as m_desc, files.*, files.id as f_id, employees.*, employees.id as em_id, article_categories.*, article_categories.id as articles_cat_id')
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
                    ->andWhere(['article_categories_id' => self::BLOG])
                    ->andWhere(['article.status' => self::ACTIVE_STATUS])
                    ->andWhere(['articles.position' => self::POSITION_DRAFT])
                    ->andWhere(['master_articles.employees_id' => $this->getEmployeesID()])
                    ->orderBy(['articles.id' => SORT_DESC])
                    ->all();
        }
        $countgaleri = $galeriQuery->count();
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $countgaleri,
        ]);
        
        $galeries = $galeriQuery->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        return $this->render('contentwriter-draft', [
            'galeries' => $galeries,
            'pagination' => $pagination,
            'q' => $q,
        ]);
    }
    
    /**
     * Displays a single Articles model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $employeesID = $this->getEmployeesID();
        $masterArticles = MasterArticles::find()->where(['articles_id' => $model->id])->one();
        $masterMedias = MasterArticlesMedia::find()->where(['master_articles_id' => $masterArticles->id])->one();
        $countMasterMedias = MasterArticlesMedia::find()->where(['master_articles_id' => $masterArticles->id])->count();
        $employees = Employees::find()->where(['id' => $masterArticles->employees_id])->one();
        $articleCategories = ArticleCategories::find()->where(['id' => $masterArticles->article_categories_id])->one();
        
        if($countMasterMedias > 0){
            $countMedias = Medias::find()->where(['id' => $masterMedias->medias_id])->count();
            $medias = Medias::find()->where(['id' => $masterMedias->medias_id])->one();
        }else{
            $countMedias = 0;
            $medias = NULL;
        }
        
        $keywords = explode(',', $model->tags);
        
        
        return $this->render('view', [
            'model' => $model,
            'masterArticles' => $masterArticles,
            'masterMedias' => $masterMedias,
            'countMasterMedias' => $countMasterMedias,
            'medias' => $medias,
            'employees' => $employees,
            'articleCategories' => $articleCategories,
            'employeesID' => $employeesID,
            'keywords' => $keywords,
        ]);
    }

    /**
     * Displays a single Articles model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionContentwriterView($id)
    {
        $model = $this->findModel($id);
        $employeesID = $this->getEmployeesID();
        $masterArticles = MasterArticles::find()->where(['articles_id' => $model->id])->one();
        $masterMedias = MasterArticlesMedia::find()->where(['master_articles_id' => $masterArticles->id])->one();
        $countMasterMedias = MasterArticlesMedia::find()->where(['master_articles_id' => $masterArticles->id])->count();
        $employees = Employees::find()->where(['id' => $masterArticles->employees_id])->one();
        if($employees->id !== Yii::$app->user->identity->id){
            return $this->redirect('/');
        }
        $articleCategories = ArticleCategories::find()->where(['id' => $masterArticles->article_categories_id])->one();
        
        if($countMasterMedias > 0){
            $countMedias = Medias::find()->where(['id' => $masterMedias->medias_id])->count();
            $medias = Medias::find()->where(['id' => $masterMedias->medias_id])->one();
        }else{
            $countMedias = 0;
            $medias = NULL;
        }
        
        $keywords = explode(',', $model->tags);
        
        
        return $this->render('contentwriter-view', [
            'model' => $model,
            'masterArticles' => $masterArticles,
            'masterMedias' => $masterMedias,
            'countMasterMedias' => $countMasterMedias,
            'medias' => $medias,
            'employees' => $employees,
            'articleCategories' => $articleCategories,
            'employeesID' => $employeesID,
            'keywords' => $keywords,
        ]);
    }
    
    
    /**
     * Creates a new Articles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Articles();
        $medias = new Medias();
        $masterArticles = new MasterArticles();
        $masterMedias = new MasterArticlesMedia();
        $model->description = "medias";
        $model->status = self::ACTIVE_STATUS;
        if($model->load(Yii::$app->request->post())){
            if($model->validate(false)){
                $model->save(false);
                $masterArticles->employees_id = \Yii::$app->usershow->findEmployees(\Yii::$app->user->identity->id)->id;
                $masterArticles->articles_id = $model->id;
                $masterArticles->viewer = 0;
                $masterArticles->rate = 0;
                $masterArticles->comments = 0;
                if($masterArticles->load(Yii::$app->request->post())){
                    if($masterArticles->validate()){
                        $masterArticles->save();
                        $masterArticlesID = $masterArticles->id;
                        if($medias->load(Yii::$app->request->post()) OR $files->load(Yii::$app->request->post())){
                            if($medias->load(Yii::$app->request->post())){
                                $medias->uploadPublicMedia(null, $masterArticlesID, $medias->description);
                            }
                        }else{
                            return $this->redirect(['view', 'id' => $model->id]);
                        }
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                    'medias' => $medias,
                    'masterArticles' => $masterArticles,
                    'masterMedias' => $masterMedias,
                ]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'medias' => $medias,
            'masterArticles' => $masterArticles,
            'masterMedias' => $masterMedias,
        ]);
    }

    /**
     * Creates a new Articles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionContentwriterCreate()
    {
        $model = new Articles();
        $medias = new Medias();
        $masterArticles = new MasterArticles();
        $masterMedias = new MasterArticlesMedia();
        //$model->description = "medias";
        $model->status = self::ACTIVE_STATUS;
        if($model->load(Yii::$app->request->post())){
            if($model->validate(false)){
                $model->save(false);
                $masterArticles->employees_id = \Yii::$app->usershow->findEmployees(\Yii::$app->user->identity->id)->id;
                $masterArticles->articles_id = $model->id;
                $masterArticles->viewer = 0;
                $masterArticles->rate = 0;
                $masterArticles->comments = 0;
                if($masterArticles->load(Yii::$app->request->post())){
                    if($masterArticles->validate()){
                        $masterArticles->save();
                        $masterArticlesID = $masterArticles->id;
                        if($medias->load(Yii::$app->request->post()) OR $files->load(Yii::$app->request->post())){
                            if($medias->load(Yii::$app->request->post())){
                                $medias->uploadPublicMedia(null, $masterArticlesID, $medias->description);
                            }
                        }else{
                            return $this->redirect(['view', 'id' => $model->id]);
                        }
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return $this->render('contentwriter-create', [
                    'model' => $model,
                    'medias' => $medias,
                    'masterArticles' => $masterArticles,
                    'masterMedias' => $masterMedias,
                ]);
            }
        }
        return $this->render('contentwriter-create', [
            'model' => $model,
            'medias' => $medias,
            'masterArticles' => $masterArticles,
            'masterMedias' => $masterMedias,
        ]);
    }

    
    /**
     * Updates an existing Articles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $masterArticles = MasterArticles::find()->where(['articles_id' => $model->id])->one();
        $masterMedias = MasterArticlesMedia::find()->where(['master_articles_id' => $masterArticles->id])->one();
        $countMasterMedia = MasterArticlesMedia::find()->where(['master_articles_id' => $masterArticles->id])->count();
        
        if($countMasterMedia > 0){
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
                if($masterArticles->load(Yii::$app->request->post())){
                    if($masterArticles->update());
                    $masterArticlesID = $masterArticles->id;
                    if(Yii::$app->request->post('foto_x') == "1"){
                        $medias_delete = true;
                        $this->handleDeleteFile($mediasID);
                    }else{
                        $medias_delete = false;
                    }
                    
                    if($medias->load(Yii::$app->request->post())){
                        $mediaDescription = Yii::$app->request->post()['Medias']['description'];
                        $this->handleUpdateMedia($mediasID, $masterArticlesID, $mediaDescription);
                    }else{
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
            //echo $mediaDescription;
            return $this->redirect(['view', 'id' => $model->id]);
        }else{
            
            return $this->render('update', [
                'model' => $model,
                'masterArticles' => $masterArticles,
                'masterMedias' => $masterMedias,
                'countMasterMedia' => $countMasterMedia,
                'medias' => $medias,
            ]);
            
        }
        return $this->render('update', [
            'model' => $model,
            'masterArticles' => $masterArticles,
            'masterMedias' => $masterMedias,
            'countMasterMedia' => $countMasterMedia,
            'medias' => $medias,
        ]);
    }
    
    /**
     * Updates an existing Articles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionAdminUpdate($id)
    {
        $model = $this->findModel($id);
        $masterArticles = MasterArticles::find()->where(['articles_id' => $model->id])->one();
        $masterMedias = MasterArticlesMedia::find()->where(['master_articles_id' => $masterArticles->id])->one();
        $countMasterMedia = MasterArticlesMedia::find()->where(['master_articles_id' => $masterArticles->id])->count();
        
        if($countMasterMedia > 0){
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
                if($masterArticles->load(Yii::$app->request->post())){
                    if($masterArticles->update());
                    $masterArticlesID = $masterArticles->id;
                    if(Yii::$app->request->post('foto_x') == "1"){
                        $medias_delete = true;
                        $this->handleDeleteFile($mediasID);
                    }else{
                        $medias_delete = false;
                    }
                    
                    if($medias->load(Yii::$app->request->post())){
                        $mediaDescription = Yii::$app->request->post()['Medias']['description'];
                        $this->handleUpdateMedia($mediasID, $masterArticlesID, $mediaDescription);
                    }else{
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
            //echo $mediaDescription;
            return $this->redirect(['view', 'id' => $model->id]);
        }else{
            
            return $this->render('admin-update', [
                'model' => $model,
                'masterArticles' => $masterArticles,
                'masterMedias' => $masterMedias,
                'countMasterMedia' => $countMasterMedia,
                'medias' => $medias,
            ]);
            
        }
        return $this->render('admin-update', [
            'model' => $model,
            'masterArticles' => $masterArticles,
            'masterMedias' => $masterMedias,
            'countMasterMedia' => $countMasterMedia,
            'medias' => $medias,
        ]);
    }

    /**
     * Updates an existing Articles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionContentwriterUpdate($id)
    {
        $model = $this->findModel($id);
        $masterArticles = MasterArticles::find()->where(['articles_id' => $model->id])->one();
        $masterMedias = MasterArticlesMedia::find()->where(['master_articles_id' => $masterArticles->id])->one();
        $countMasterMedia = MasterArticlesMedia::find()->where(['master_articles_id' => $masterArticles->id])->count();
        
        if($countMasterMedia > 0){
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
                if($masterArticles->load(Yii::$app->request->post())){
                    if($masterArticles->update());
                    $masterArticlesID = $masterArticles->id;
                    if(Yii::$app->request->post('foto_x') == "1"){
                        $medias_delete = true;
                        $this->handleDeleteFile($mediasID);
                    }else{
                        $medias_delete = false;
                    }
                    
                    if($medias->load(Yii::$app->request->post())){
                        $mediaDescription = Yii::$app->request->post()['Medias']['description'];
                        $this->handleUpdateMedia($mediasID, $masterArticlesID, $mediaDescription);
                    }else{
                        return $this->redirect(['contentwriter-view', 'id' => $model->id]);
                    }
                }
            }
            //echo $mediaDescription;
            return $this->redirect(['contentwriter-view', 'id' => $model->id]);
        }else{
            
            return $this->render('contentwriter-update', [
                'model' => $model,
                'masterArticles' => $masterArticles,
                'masterMedias' => $masterMedias,
                'countMasterMedia' => $countMasterMedia,
                'medias' => $medias,
            ]);
            
        }
        return $this->render('contentwriter-update', [
            'model' => $model,
            'masterArticles' => $masterArticles,
            'masterMedias' => $masterMedias,
            'countMasterMedia' => $countMasterMedia,
            'medias' => $medias,
        ]);
    }
    
    /**
     * Deletes an existing Articles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = self::NOTACTIVE_STATUS;
        $model->position = self::POSITION_TRASH;
        $model->update();
        return $this->redirect(['index']);
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
    protected function getArticlesCategories($articlesTypeID) 
    {
        $query = (new Query())
                ->select('*')
                ->from('article_categories')
                ->where(['article_types_id' => $articlesTypeID]);
        return $query->createCommand()->queryAll();
    }
    
    protected function getAllArticleCategories($articlesTypeID) 
    {
        $countArticlesCategoriesID= count($this->getArticlesCategories($articlesTypeID))-1;
        $i = 0;
        $id = array();
        foreach ($this->getArticlesCategories($articlesTypeID) as $data)        {
            $id[$i] = $data['id'];
            $i++;
        }
        return $id;
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
        $masterARticlesMedia = MasterArticlesMedia::find()->where(['medias_id' => $mediasID])->one();
        $masterARticlesMedia->delete();
        $medias->tempDeleteMedia($mediasID);
        return $medias->deleteMedia();
    }
    
    protected function handleUpdateFile($filesID, $publicArticlesID, $description) 
    {
        $file = new Files();
        if($filesID != null){
            return $file->uploadPublicFile($filesID, $publicArticlesID, $description);
        }else{
            return $file->uploadPublicFile(null, $publicArticlesID, $description);
        }
    }
    
    protected function handleDeleteFile($fileID) 
    {
        $file = new Files();
        $masterArtticlesFile = MasterArticlesFile::find()->where(['files_id' => $fileID])->one();
        $masterArtticlesFile->delete();
        $file->tempDeleteFiles($fileID);
        return $file->deleteFile();
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
}
