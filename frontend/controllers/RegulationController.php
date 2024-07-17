<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

namespace frontend\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Employees;
use common\models\Articles;
use common\models\MasterEmployeesMedia;
use common\models\MasterArticles;
use common\models\MasterArticlesMedia;
use common\models\MasterArticlesFile;
use common\models\Medias;
use common\models\Files;
use yii\data\Pagination;

class RegulationController extends Controller
{
    public $bodyID;
    
    const ACTIVE_STATUS = 1;
    const POSITION_LIVE = 1;
    const POSITION_DRAFT = 0;
    const POSITION_TRASH = 10;
    const NOTACTIVE_STATUS = 0;
    const PRIVACY_POLICY = array(6);
    const TERMS_CONDITION = array(7);
    const DISCLAIMER = array(8);
    const ABOUT = array(9);
    const CONTACT = array(10);
    const NOT_BLOG = array(6,7,8,9,10);
    
    public function actionIndex()
    {
        $query = (new Query());
        $query->select('articles.*, articles.id as article_id, articles.description as article_desc, master_articles.*,  master_articles.id as m_article_id, master_articles_media.*, master_articles_media.id as m_articles_media_id, master_articles_file.*, master_articles_file.id as m_articles_file_id, medias.*, medias.id as m_id, files.*, files.id as f_id, employees.*,employees.id as em_id, article_categories.*, article_categories.id as articles_cat_id')
                ->from('articles')
                ->join('LEFT JOIN', 'master_articles', 'master_articles.articles_id = articles.id')
                ->join('LEFT JOIN', 'master_articles_media', 'master_articles_media.master_articles_id = master_articles.id')
                ->join('LEFT JOIN', 'master_articles_file', 'master_articles_file.master_articles_id = master_articles.id')
                ->join('LEFT JOIN', 'article_categories', 'article_categories.id = master_articles.article_categories_id')
                ->join('LEFT JOIN', 'employees', 'employees.id = master_articles.employees_id')    
                ->join('LEFT JOIN', 'medias', 'medias.id = master_articles_media.medias_id')
                ->join('LEFT JOIN', 'files', 'files.id = master_articles_file.files_id')
                ->join('LEFT JOIN', 'master_employees', 'master_employees.employees_id = employees.id')
                ->join('LEFT JOIN', 'user', 'user.id = master_employees.user_id')
                ->join('LEFT JOIN', 'previleges', 'previleges.id = user.previleges_id')
                ->where(['articles.status' => self::ACTIVE_STATUS])
                ->andWhere(['articles.position' => self::POSITION_LIVE])
                ->andWhere(['IN', 'article_categories_id', self::NOT_BLOG])
                ->orderBy(['articles.date' => SORT_DESC])
                ->all();
        
        
        //$countArticles = $query->count();
        $pagination = new Pagination([
            'defaultPageSize' => 12,
            'totalCount' => $query->count(),
        ]);
        
        $articles = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        
        $this->bodyID = 'index';
        
        \Yii::$app->view->title = 'Regulation - vacationurban.com';
        
        \Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'the vacationurban.com regulation page there are About Us, Privacy Policy, Terms & Condition, Disclaimer, and Contact',
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'property' => 'og:title',
            'content' => 'Regulation - vacationurban.com',
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'property' => 'og:url',
            'content' => \Yii::$app->params['homeLink'].'/regulation'
        ]);
        
        Yii::$app->view->registerLinkTag([
            'rel' => 'canonical',
            'href' => Yii::$app->params['homeLink'].'/regulation',
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'vacation, tourism, cultures, urban tourism, vacationurban, vacation urban, regulation, About Us, Privacy Policy, Terms & Condition, Disclaimer, and Contact',
        ]);
        
        return $this->render('index', [
            'countArticles' => $query->count(),
            'articles' => $articles,
            'pagination' => $pagination,
        ]);
        
    }
    
    /**
     * 
     * @return mixed
     */
    public function actionPrivacyPolicy() 
    {
        $this->bodyID = 'privacy-policy';
        
        $id = MasterArticles::find()->where([
                'article_categories_id' => self::PRIVACY_POLICY,
            ])->one();
        $model = $this->findModel($id->articles_id);
        $masterMedia = MasterArticlesMedia::find()->where(['master_articles_id' => $id->id])->one();
        $countMedia = MasterArticlesMedia::find()->where(['master_articles_id' => $id->id])->count();
        $employee = Employees::find()->where(['id' => $id->employees_id])->one();
        
        \Yii::$app->view->title = ucwords($model->title) . ' - vacationurban.com';
        
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $model->description,
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'property' => 'og:title',
            'content' => ucwords($model->title) . '- vacationurban.com',
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'property' => 'og:description',
            'content' => $model->description,
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'property' => 'og:url',
            'content' => Yii::$app->params['homeLink'].'/regulation/privacy-policy',
        ]);
        
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'vacation, tourism, cultures, urban tourism, '. $this->getTags($model->tags, ', '). ', vacationurban, regulation',
        ]);
        
        if($countMedia > 0){
            $countMedia = 1;
            $media = Medias::find()->where(['id' => $masterMedia->medias_id])->one();
            \Yii::$app->view->registerMetaTag([
                'property' => 'og:image',
                'itemprop' => 'image',
                'content' => Yii::$app->params['publicImageLink'].$media->media,
            ]);
        }else{
            $countMedia = 0;
            $media = null;
            \Yii::$app->view->registerMetaTag([
                'property' => 'og:image',
                'itemprop' => 'image',
                'content' => Yii::$app->params['publicImageLink'].'image-1.webp',
            ]);
        }
        
        Yii::$app->view->registerMetaTag([
            'property' => 'og:type',
            'content' => 'website',
        ]);
        
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'vacation, tourism, cultures, urban tourism, '.$model->title.', '. $model->mini_title.', '. $this->getTags($model->tags, ', '). 'vacationurban, regulation, vacationurban.com',
        ]);
        
        Yii::$app->view->registerLinkTag([
            'rel' => 'canonical',
            'href' => Yii::$app->params['homeLink'].'/regulation/privacy-policy',
        ]);
        
        $this->updateViewer($model->id);
        
        $tags = $this->getTags($model->tags, ', ');
        
        return $this->render('privacy-policy',[
            'model' => $model,
            'countMedia' => $countMedia,
            'media' => $media,
            'employee' => $employee,
            'tags' => $tags,
        ]);
    }
    
    /**
     * 
     * @return mixed
     */    
    public function actionTermsCondition() 
    {
        $this->bodyID = 'terms-and-condition';
        
        $id = MasterArticles::find()->where([
                'article_categories_id' => self::TERMS_CONDITION,
            ])->one();
        $model = $this->findModel($id->articles_id);
        $masterMedia = MasterArticlesMedia::find()->where(['master_articles_id' => $id->id])->one();
        $countMedia = MasterArticlesMedia::find()->where(['master_articles_id' => $id->id])->count();
        $employee = Employees::find()->where(['id' => $id->employees_id])->one();
        
        \Yii::$app->view->title = ucwords($model->title) . ' - vacationurban.com';
        
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $model->description,
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'property' => 'og:title',
            'content' => ucwords($model->title) . '- vacationurban.com',
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'property' => 'og:description',
            'content' => $model->description,
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'property' => 'og:url',
            'content' => Yii::$app->params['homeLink'].'/regulation/terms-condition',
        ]);
        
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'vacation, tourism, cultures, urban tourism, '. $this->getTags($model->tags, ', '). 'vacationurban, regulation',
        ]);
        
        if($countMedia > 0){
            $countMedia = 1;
            $media = Medias::find()->where(['id' => $masterMedia->medias_id])->one();
            \Yii::$app->view->registerMetaTag([
                'property' => 'og:image',
                'itemprop' => 'image',
                'content' => Yii::$app->params['publicImageLink'].$media->media,
            ]);
        }else{
            $countMedia = 0;
            $media = null;
            \Yii::$app->view->registerMetaTag([
                'property' => 'og:image',
                'itemprop' => 'image',
                'content' => Yii::$app->params['publicImageLink'].'image-1.webp',
            ]);
        }
        
        Yii::$app->view->registerMetaTag([
            'property' => 'og:type',
            'content' => 'website',
        ]);
        
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'vacation, tourism, cultures, urban tourism, '.$model->title.', '. $model->mini_title.', '. $this->getTags($model->tags, ', '). 'vacationurban, regulation, vacationurban.com',
        ]);
        
        Yii::$app->view->registerLinkTag([
            'rel' => 'canonical',
            'href' => Yii::$app->params['homeLink'].'/regulation/terms-condition',
        ]);
        
        $this->updateViewer($model->id);
        
        $tags = $this->getTags($model->tags, ', ');
        
        return $this->render('terms-condition',[
            'model' => $model,
            'countMedia' => $countMedia,
            'media' => $media,
            'employee' => $employee,
            'tags' => $tags,
        ]);
    }
    
    /**
     * 
     * @return mixed
     */
    public function actionDisclaimer() 
    {
        $this->bodyID = 'terms-and-condition';
        
        $id = MasterArticles::find()->where([
                'article_categories_id' => self::DISCLAIMER,
            ])->one();
        $model = $this->findModel($id->articles_id);
        $masterMedia = MasterArticlesMedia::find()->where(['master_articles_id' => $id->id])->one();
        $countMedia = MasterArticlesMedia::find()->where(['master_articles_id' => $id->id])->count();
        $employee = Employees::find()->where(['id' => $id->employees_id])->one();
        
        \Yii::$app->view->title = ucwords($model->title) . ' - vacationurban.com';
        
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $model->description,
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'property' => 'og:title',
            'content' => ucwords($model->title) . '- vacationurban.com',
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'property' => 'og:description',
            'content' => $model->description,
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'property' => 'og:url',
            'content' => Yii::$app->params['homeLink'].'/regulation/disclaimer',
        ]);
        
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'vacation, tourism, cultures, urban tourism, '. $this->getTags($model->tags, ', '). 'vacationurban, regulation',
        ]);
        
        if($countMedia > 0){
            $countMedia = 1;
            $media = Medias::find()->where(['id' => $masterMedia->medias_id])->one();
            \Yii::$app->view->registerMetaTag([
                'property' => 'og:image',
                'itemprop' => 'image',
                'content' => Yii::$app->params['publicImageLink'].$media->media,
            ]);
        }else{
            $countMedia = 0;
            $media = null;
            \Yii::$app->view->registerMetaTag([
                'property' => 'og:image',
                'itemprop' => 'image',
                'content' => Yii::$app->params['publicImageLink'].'image-1.webp',
            ]);
        }
        
        Yii::$app->view->registerMetaTag([
            'property' => 'og:type',
            'content' => 'website',
        ]);
        
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'vacation, tourism, cultures, urban tourism, '.$model->title.', '. $model->mini_title.', '. $this->getTags($model->tags, ', '). 'vacationurban, regulation, vacationurban.com',
        ]);
        
        Yii::$app->view->registerLinkTag([
            'rel' => 'canonical',
            'href' => Yii::$app->params['homeLink'].'/regulation/disclaimer',
        ]);
        
        $this->updateViewer($model->id);
        
        $tags = $this->getTags($model->tags, ', ');
        
        return $this->render('disclaimer',[
            'model' => $model,
            'countMedia' => $countMedia,
            'media' => $media,
            'employee' => $employee,
            'tags' => $tags,
        ]);
    }
    
    /**
     * 
     * @return mixed
     */
    public function actionContact() 
    {
        $this->bodyID = 'contact';
        
        $id = MasterArticles::find()->where([
                'article_categories_id' => self::CONTACT,
            ])->one();
        $model = $this->findModel($id->articles_id);
        $masterMedia = MasterArticlesMedia::find()->where(['master_articles_id' => $id->id])->one();
        $countMedia = MasterArticlesMedia::find()->where(['master_articles_id' => $id->id])->count();
        $employee = Employees::find()->where(['id' => $id->employees_id])->one();
        
        \Yii::$app->view->title = ucwords($model->title) . ' - vacationurban.com';
        
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $model->description,
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'property' => 'og:title',
            'content' => ucwords($model->title) . '- vacationurban.com',
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'property' => 'og:description',
            'content' => $model->description,
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'property' => 'og:url',
            'content' => Yii::$app->params['homeLink'].'/regulation/contact',
        ]);
        
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'vacation, tourism, cultures, urban tourism, '. $this->getTags($model->tags, ', '). 'vacationurban, regulation',
        ]);
        
        if($countMedia > 0){
            $countMedia = 1;
            $media = Medias::find()->where(['id' => $masterMedia->medias_id])->one();
            \Yii::$app->view->registerMetaTag([
                'property' => 'og:image',
                'itemprop' => 'image',
                'content' => Yii::$app->params['publicImageLink'].$media->media,
            ]);
        }else{
            $countMedia = 0;
            $media = null;
            \Yii::$app->view->registerMetaTag([
                'property' => 'og:image',
                'itemprop' => 'image',
                'content' => Yii::$app->params['publicImageLink'].'image-1.webp',
            ]);
        }
        
        Yii::$app->view->registerMetaTag([
            'property' => 'og:type',
            'content' => 'website',
        ]);
        
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'vacation, tourism, cultures, urban tourism, '.$model->title.', '. $model->mini_title.', '. $this->getTags($model->tags, ', '). 'vacationurban, regulation, vacationurban.com',
        ]);
        
        Yii::$app->view->registerLinkTag([
            'rel' => 'canonical',
            'href' => Yii::$app->params['homeLink'].'/regulation/contact',
        ]);
        
        $this->updateViewer($model->id);
        
        $tags = $this->getTags($model->tags, ', ');
        
        return $this->render('contact',[
            'model' => $model,
            'countMedia' => $countMedia,
            'media' => $media,
            'employee' => $employee,
            'tags' => $tags,
        ]);
    }
    
    /**
     * 
     * @return mixed
     */
    public function actionAboutUs() 
    {
        $this->bodyID = 'about-us';
        
        $id = MasterArticles::find()->where([
                'article_categories_id' => self::ABOUT,
            ])->one();
        $model = $this->findModel($id->articles_id);
        $masterMedia = MasterArticlesMedia::find()->where(['master_articles_id' => $id->id])->one();
        $countMedia = MasterArticlesMedia::find()->where(['master_articles_id' => $id->id])->count();
        $employee = Employees::find()->where(['id' => $id->employees_id])->one();
        
        \Yii::$app->view->title = ucwords($model->title) . ' - vacationurban.com';
        
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $model->description,
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'property' => 'og:title',
            'content' => ucwords($model->title) . '- vacationurban.com',
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'property' => 'og:description',
            'content' => $model->description,
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'property' => 'og:url',
            'content' => Yii::$app->params['homeLink'].'/regulation/about-us',
        ]);
        
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'vacation, tourism, cultures, urban tourism, '. $this->getTags($model->tags, ', '). 'vacationurban, regulation',
        ]);
        
        if($countMedia > 0){
            $countMedia = 1;
            $media = Medias::find()->where(['id ' => $masterMedia->medias_id])->one();
            \Yii::$app->view->registerMetaTag([
                'property' => 'og:image',
                'itemprop' => 'image',
                'content' => Yii::$app->params['publicImageLink'].$media->media,
            ]);
        }else{
            $countMedia = 0;
            $media = null;
            \Yii::$app->view->registerMetaTag([
                'property' => 'og:image',
                'itemprop' => 'image',
                'content' => Yii::$app->params['publicImageLink'].'image-1.webp',
            ]);
        }
        
        Yii::$app->view->registerMetaTag([
            'property' => 'og:type',
            'content' => 'website',
        ]);
        
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'vacation, tourism, cultures, urban tourism, '.$model->title.', '. $model->mini_title.', '. $this->getTags($model->tags, ', '). 'vacationurban, regulation, vacationurban.com',
        ]);
        
        Yii::$app->view->registerLinkTag([
            'rel' => 'canonical',
            'href' => Yii::$app->params['homeLink'].'/regulation/about-us',
        ]);
        
        $this->updateViewer($model->id);
        
        $tags = $this->getTags($model->tags, ', ');
        
        return $this->render('about-us',[
            'model' => $model,
            'countMedia' => $countMedia,
            'media' => $media,
            'employee' => $employee,
            'tags' => $tags,
        ]);
    }
    
    /**
     * 
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id) {
        if(($model = Articles::find()
                ->where(['id' => $id])
                ->andWhere(['status' => self::ACTIVE_STATUS])
                ->one()) !== null)
        {
            return $model;
        }else{
            throw new NotFoundHttpException('Page Not Found');
        }
    }
    
    /**
     * 
     * @param string $tags
     * @param string $splitBy
     * @return string
     */
    protected function getTags($tags, $splitBy) 
    {
        $splitTags = explode($splitBy, $tags);
        $tgs = '';
        foreach ($splitTags as $tg){
            $tgs .= ' '.$tg.', ';
        }       
        return $tgs;
    }
    
    /**
     * 
     * @param int $id
     * @return true
     */
    protected function updateViewer($id) {
        $masterArticles = MasterArticles::find()->where(['articles_id' => $id])->one();
        return $masterArticles->updateCounters(['viewer' => 1]);
    }
    
}
