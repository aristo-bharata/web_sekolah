<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\Articles;
use common\models\MasterArticles;
use common\models\MasterArticlesMedia;
use common\models\MasterArticlesFile;
use common\models\Employees;
use common\models\Medias;
use common\models\Files;
use yii\db\Query;
use yii\data\Pagination;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;

/**
 * Site controller
 * 1 Visi Misi 1
 * 2 Sejarah Singkat 1
 * 3 GTK 1
 * 4 PD 1
 * 5 KOSP 1
 * 6 Kurtilas 1
 * 7 Ekstra Kurikuler 1
 * 8 P5 1
 * 9 Pengumuman 1
 * 10 Berita Umum 1
 * 11 Sambutan 1
 * 12 Galeri 2
 * 13 Carousel 2
 * 14 Testimoni 2
 * 15 Kebijakan Privasi 3
 * 16 Terms & Conditions 4
 * 17 Disclaimer 5
 * 18 About Us 6
 * 19 Kontak 7
 * 20 Help 1
 */

class SiteController extends Controller
{
    public $bodyID;
    
    const ARTICLES = array(1,2,3,4,5,6,7,8.9,10,11,12,20);
    const VISI_MISI = array(1); // 1 Visi Misi
    const SEJARAH = array(2); // 2 Sejarah Singkat
    const GTK = array(3); // 3 GTK
    const PD = array(4); // 4 PD
    const KOSP = array(5); // 5 KOSP
    const KURTILAS = array(6); // 6 Kurtilas
    const EKSKUL = array(7); // 7 Ekstra Kurikuler
    const P_LIMA = array(8); // 8 P5
    const PENGUMUMAN = array(9); // 9 Pengumuman
    const BERITA = array(10); // 10 Berita Umum
    const SAMBUTAN = array(11); // 11 Sambutan
    const SARPRAS = array(12); // 11 Sambutan
    const GALERI = array(13); // 13 Galeri
    const TESTIMONI = array(14); // 14 Testimoni
    const CAROUSEL = array(15); // 15 Carousel
    const PRIVACY_POLICY = array(16); // 16 Kebijakan Privasi
    const TERMS_CONDITION = array(17); // 17 Terms & Conditions
    const DISCLAIMER = array(18); // 18 Disclaimer
    const ABOUT = array(19); // 18 About Us
    const CONTACT = array(20); // 19 Kontak
    const ACTIVE_STATUS = 1;
    const NOTACTIVE_STATUS = 0;
    const POSITION_LIVE = 1;
    const POSITION_DRAFT = 0;
    const POSITION_TRASH = 10;
    
    //public $visimisi = self::VISI_MISI;
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    
    /**
     * Call Public Parameter by Component
     * 
     * {@inheritDoc}
     */
    protected function header() {
        Yii::$app->articleattribute->header();
    }
   
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {        
        // call public parameter
        $this->header(); 
        //pengumuman
        $pengumuman = $this->getGenericContent(self::PENGUMUMAN, 2);
        //berita_umum
        $beritaUmum = $this->getGenericContent(self::BERITA, 3);
        //sambutan
        $sambutan = $this->getGenericContent(self::SAMBUTAN, 1);
        //galeri
        $galeri = $this->getGenericContent(self::GALERI, 6);
        //carousel
        $carousel = $this->getGenericContent(self::CAROUSEL, 5);
        //testimoni
        $testimoni = $this->getGenericContent(self::TESTIMONI, 3);
        
        $this->bodyID = 'index';
        Yii::$app->view->title = 'Website Resmi SDN 2 Taman Baru';
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'web sekolah SDN 2 Taman Baru',
        ]);
        
        return $this->render('index',[
            'pengumuman' => $pengumuman,
            'beritaUmum' => $beritaUmum,
            'sambutan' => $sambutan,
            'carousel' => $carousel,
            'testimoni' => $testimoni,
            'galeri' => $galeri,
            'about' => self::ABOUT,
            ]);
        }
    /**
     * 
     * @param string $keystring
     * @return mixed
     */
    public function actionSearch($keystring)
    {
        //call public parameter
        $this->header();
        
        $tag = str_replace('-', ' ', $keystring);
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
                ->Where(['LIKE','articles.mini_title', $tag])
                ->orWhere(['LIKE','articles.title', $tag])
                ->orWhere(['LIKE','articles.description', $tag])
                ->orWhere(['LIKE','articles.article', $tag])
                ->orWhere(['LIKE','articles.date', $tag])
                ->orWhere(['LIKE','employees.first_name', $tag])
                ->orWhere(['LIKE','employees.last_name', $tag])
                ->orWhere(['LIKE','employees.description', $tag])
                ->orWhere(['LIKE','medias.media', $tag])
                ->orWhere(['LIKE','medias.description', $tag])
                ->orWhere(['LIKE','files.file', $tag])
                ->orwhere(['LIKE','files.description', $tag])
                ->andWhere(['IN','article_categories_id', self::BLOG])
                ->andWhere(['articles.status' => self::ACTIVE_STATUS])
                ->andWhere(['articles.position' => self::POSITION_LIVE])
                ->orderBy(['articles.date' => SORT_DESC])
                ->all();
        $countArticles = $query->count();
        $pagination = new Pagination([
            'defaultPageSize' => 12,
            'totalCount' => $countArticles,
        ]);
        
        $articles = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        
        $this->bodyID = 'index';
        
        \Yii::$app->view->title = 'Your Tourism Guide - vacationurban.com';
        
        \Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Tourism dictionary, tells about the cultures, arts and foods you can find anywhere in the world'
        ]);
        
        $tags = '';
        foreach ($articles as $article){
            $tags .= $article['mini_title'].', '.$article['title'].', '.$this->getTags($article['tags'], ', ');
        }
        
        \Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'vacation, tourism, cultures, urban tourism, '.$tags.', vacationurban, vacation urban',
        ]);
        
        return $this->render('index',[
            'countArticles' => $countArticles,
            'articles' => $articles,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * 
     * @param int $id
     * @return true
     */
    protected function updateViewer($id) 
    {
        $masterArticles = MasterArticles::find()->where(['articles_id' => $id])->one();
        return $masterArticles->updateCounters(['viewer' => 1]);
    }
    
    protected function getArticlesCategoriesByType($articlesTypeID) 
    {
        $query = (new Query())
                ->select('*')
                ->from('article_categories')
                ->where(['article_types_id' =>  $articlesTypeID]);
        return $query->createCommand()->queryOne();
    }
    
    protected function getGenericContent($categoriesID, $limit) 
    {
        $query = (new Query())
                ->select('articles.*, articles.id as articles_id, articles.description as article_desc, master_articles.*, master_articles.id as master_articles_id, medias.media, medias.description as media_desc, files.file, files.description as file_desc, files.extension, employees.*, employees.id as employees_id, employees.description as employee_desc')
                ->from('master_articles')
                ->join('LEFT JOIN', 'articles', 'articles.id = master_articles.articles_id')
                ->join('LEFT JOIN', 'master_articles_media', 'master_articles_media.master_articles_id = master_articles.id')
                ->join('LEFT JOIN', 'master_articles_file', 'master_articles_file.master_articles_id = master_articles.id')
                ->join('LEFT JOIN', 'medias', 'medias.id = master_articles_media.medias_id')
                ->join('LEFT JOIN', 'files', 'files.id = master_articles_file.files_id')
                ->join('LEFT JOIN', 'employees', 'employees.id = master_articles.employees_id')
                ->where(['article_categories_id' => $categoriesID])
                ->andWhere(['articles.status' => self::ACTIVE_STATUS])
                ->andWhere(['articles.position' => self::POSITION_LIVE])
                ->limit($limit)
                ->orderBy(['articles.date' => SORT_DESC]);
        return $query->createCommand()->queryAll();
    }
    
    protected function getCountGenericContent($categoriesID) 
    {
        $query = (new Query())
                ->select('articles.*, articles.id as articles_id, articles.description as desc, master_articles.*, master_articles.id as master_articles_id, medias.media, medias.description as media_desc, files.file, files.description as file_desc, files.extension, employees.*')
                ->from('master_articles')
                ->join('LEFT JOIN', 'articles', 'articles.id = master_articles.articles_id')
                ->join('LEFT JOIN', 'master_articles_media', 'master_articles_media.master_articles_id = master_articles.id')
                ->join('LEFT JOIN', 'master_articles_file', 'master_articles_file.master_articles_id = master_articles.id')
                ->join('LEFT JOIN', 'medias', 'medias.id = master_articles_media.medias_id')
                ->join('LEFT JOIN', 'files', 'files.id = master_articles_file.files_id')
                ->join('LEFT JOIN', 'employees', 'employees.id = master_articles.employees_id')
                ->where(['IN','article_categories_id', $categoriesID])
                ->andWhere(['articles.status' => self::ACTIVE_STATUS])
                ->andWhere(['articles.position' => self::POSITION_LIVE])
                ->orderBy(['articles.date' => SORT_DESC]);
        return $query->createCommand()->queryAll();
    }
    
    protected function getAllContent($categoriesID){
        $query = (new Query())
                ->select('articles.*, articles.id as articles_id, articles.description as article_desc, master_articles.*, master_articles.id as master_articles_id, medias.media, medias.description as media_desc, files.file, files.description as file_desc, files.extension, employees.*, employees.id as employees_id, employees.description as employee_desc')
                ->from('master_articles')
                ->join('LEFT JOIN', 'articles', 'articles.id = master_articles.articles_id')
                ->join('LEFT JOIN', 'master_articles_media', 'master_articles_media.master_articles_id = master_articles.id')
                ->join('LEFT JOIN', 'master_articles_file', 'master_articles_file.master_articles_id = master_articles.id')
                ->join('LEFT JOIN', 'medias', 'medias.id = master_articles_media.medias_id')
                ->join('LEFT JOIN', 'files', 'files.id = master_articles_file.files_id')
                ->join('LEFT JOIN', 'employees', 'employees.id = master_articles.employees_id')
                ->where(['in', 'article_categories_id', $categoriesID])
                ->andWhere(['articles.status' => self::ACTIVE_STATUS])
                ->andWhere(['articles.position' => self::POSITION_LIVE])
                ->orderBy(['articles.date' => SORT_DESC]);
        return $query->createCommand()->queryAll();
    }
    
    protected function getTags($tags,$splitBy) 
    {
        $splitTags = explode($splitBy, $tags);
        $tgs = '';
        foreach ($splitTags as $tg){
            $tgs .= ' '.$tg.', ';
        }
        return $tgs;
    }
}
