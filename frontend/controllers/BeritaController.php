<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Articles;
use common\models\MasterArticles;
use common\models\MasterArticlesFile;
use common\models\MasterArticlesMedia;
use common\models\Employees;
use common\models\Medias;
use common\models\Files;
use yii\db\Query;
use yii\data\Pagination;

class BeritaController extends Controller
{
    public $bodyID;
    
    const ARTICLES = array(1,2,3,4,5,6,7,8.9,10,11,12);
    const VISI_MISI = array(1); // 1 Visi Misi
    const SEJARAH = array(2); // 2 Sejarah Singkat
    const GTK = array(3); // 3 GTK
    const PD = array(4); // 4 PD
    const KOSP = array(5); // 5 KOSP
    const KURTILAS = array(6); // 6 Kurtilas
    const P_LIMA = array(8); // 8 P5
    const PENGUMUMAN = array(9); // 9 Pengumuman
    const BERITA = array(10); // 10 Berita Umum
    const SAMBUTAN = array(11); // 11 Sambutan
    const SARPRAS = array(12); // 12 Sarpras
    const ABOUT = array(19); // 18 About Us
    const ACTIVE_STATUS = 1;
    const NOTACTIVE_STATUS = 0;
    const POSITION_LIVE = 1;
    const POSITION_DRAFT = 0;
    const POSITION_TRASH = 10;
    
    public function actions() {
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
    
    protected function header() {
        Yii::$app->articleattribute->header();
    }


    public function actionIndex() {
        $this->header();
        //$berita = $this->getGenericContent(self::BERITA, 20);
        $query = new Query();
        $query->select('articles.*, articles.id as article_id, articles.description as article_desc, master_articles.*, master_articles.id as master_article_id, medias.*, medias.id as media_id, medias.description as media_desc, files.*, files.id as file_id, files.description as file_desc, employees.*, employees.id as  employees_id, employees.description as employee_desc')
                ->from('master_articles')
                ->join('LEFT JOIN', 'articles', 'articles.id = master_articles.articles_id')
                ->join('LEFT JOIN', 'master_articles_media', 'master_articles_media.master_articles_id = master_articles.id')
                ->join('LEFT JOIN', 'master_articles_file', 'master_articles_file.master_articles_id = master_articles.id')
                ->join('LEFT JOIN', 'medias', 'medias.id = master_articles_media.medias_id')
                ->join('LEFT JOIN', 'files', 'files.id = master_articles_file.files_id')
                ->join('LEFT JOIN', 'employees', 'employees.id = master_articles.employees_id')
                ->where(['article_categories_id' => self::BERITA])
                ->andWhere(['articles.status' => self::ACTIVE_STATUS])
                ->andWhere(['articles.position' => self::POSITION_LIVE])
                ->orderBy(['articles.date' => SORT_DESC, 
                    'articles.id' => SORT_DESC])
                ->all();
        
        $countBerita = $query->count();
        $pagination = new Pagination([
            'defaultPageSize' => 12,
            'totalCount' => $countBerita,
        ]);
        
        $indexBerita = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        
        //$allNiche = $this->getAllNiche(self::ARTICLES);
        
        $indexPengumuman = $this->getGenericContent(self::PENGUMUMAN, 5);
        $indexBeritaTerbaru = $this->getGenericContent(self::BERITA, 5);
        //$indexBeritaTerkait = $this->getGenericContentByString(self::BERITA, $model->mini_title, 5, $model->id);
        
        
        $this->bodyID = 'index-berita';
        \Yii::$app->view->title = 'Berita - sdn2tamanbaru.sch.id';
        \Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'website resmi SDN 2 Taman Baru halaman Berita Terbaru',
        ]);
        
        return $this->render('index',[
            'indexBerita' => $indexBerita,
            'about' => self::ABOUT,
            'indexPengumuman' => $indexPengumuman,
            'indexBeritaTerbaru' => $indexBeritaTerbaru,
            //'indexBeritaTerkait' => $indexBeritaTerkait,
            'pagination' => $pagination,
            //'contact' => self::CONTACT,
        ]);
    }
    
    public function actionRead($id, $slug) {
        $this->header();
        $this->bodyID = 'read-blog';
        $model = $this->findModel($id, $slug);
        $masterArticles = MasterArticles::find()->where(['articles_id' => $model->id])->one();
        $masterMedias = MasterArticlesMedia::find()->where(['master_articles_id' => $masterArticles->id])->one();
        $countMasterMedias = MasterArticlesMedia::find()->where(['master_articles_id' => $masterArticles->id])->count();
        $masterFiles = MasterArticlesFile::find()->where(['master_articles_id' => $masterArticles->id])->one();
        $countMasterFiles = MasterArticlesFile::find()->where(['master_articles_id' => $masterArticles->id])->count();
        $employees = Employees::find()->where(['id' => $masterArticles->employees_id])->one();
        
        $this->updateViewer($model->id);
        
        $countIndexRelatedArticles = count($this->getCountGenericContentByString(self::BERITA, $model->mini_title, $model->id));
        $limitIndexRelatedArticles = 4;
        $indexRelatedArticles = $this->getGenericContentByString(self::BERITA, $model->mini_title, $limitIndexRelatedArticles, $model->id);
        
        $countLatestArticles = count($this->getCountGenericContent(self::ARTICLES));
        $limitLatesArticles = 8;
        $latestArticles = $this->getGenericContent(self::ARTICLES, $limitLatesArticles);
        
        $indexPengumuman = $this->getGenericContent(self::PENGUMUMAN, 5);
        $indexBeritaTerbaru = $this->getGenericContent(self::BERITA, 5);
        
        $miniTitle = ucfirst($model->mini_title);
        $pTag = array('<p>', '</p>', '<br>', '&nbsp;');
        $tagP_replace = str_replace($pTag, '', $model->description);
        
        Yii::$app->view->title = $model->title . ' | ' . $miniTitle;
        Yii::$app->view->registerLinkTag([
            'rel' => 'canonical',
            'href' => Yii::$app->params['homeLink'].'/blog/read/'.$model->id.'/'.$model->slug,
        ]);
        
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $tagP_replace),
        ]);
        
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $model->title.', '.$this->getTags($model->tags, ', ').$model->mini_title.', '.'sdn 2 taman baru',
        ]);
        
        Yii::$app->view->registerMetaTag([
            'property' => 'og:title',
            'content' => $model->title,
        ]);
        
        if($countMasterMedias > 0){
            $medias = Medias::find()->where(['id' => $masterMedias->medias_id])->one();
            $countMedias = Medias::find()->where(['id' => $masterMedias->medias_id])->count();
            Yii::$app->view->registerMetaTag([
                'property' => 'og:image',
                'content' => Yii::$app->params['publicImageLink'].$medias['media'],
            ]);
            Yii::$app->view->registerMetaTag([
                'property' => 'twitter:image',
                'content' => Yii::$app->params['publicImageLink'].$medias['media'],
            ]);
        }else{
            $countMedias = 0;
            $medias = NULL;
            Yii::$app->view->registerMetaTag([
                'property' => 'og:image',
                'content' => Yii::$app->params['publicImageLink'].'image-1.webp?h=3fd0f2ccdf0f07d295029bd930fe6e5e',
            ]);
            Yii::$app->view->registerMetaTag([
                'property' => 'twitter:image',
                'content' => Yii::$app->params['publicImageLink'].'image-1.webp?h=3fd0f2ccdf0f07d295029bd930fe6e5e',
            ]);
        }
        
        if($countMasterFiles > 0){
            $files = Files::find()->where(['id' => $masterFiles->files_id])->one();
            $countFiles = Files::find()->where(['id' => $masterFiles->files_id])->count();
        }else{
            $countFiles = 0;
            $files = NULL;
        }
        
        Yii::$app->view->registerMetaTag([
            'property' => 'og:description',
            'content' => preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $tagP_replace),
        ]);
        
        
        Yii::$app->view->registerMetaTag([
            'property' => 'og:url',
            'content' => Yii::$app->params['homeLink'].'/blog/read/'.$model->id.'/'.$model->slug,
        ]);
        
        Yii::$app->view->registerMetaTag([
            'property' => 'og:article:section',
            'content' => $miniTitle,
        ]);
        
        Yii::$app->view->registerMetaTag([
            'property' => 'og:article:published_time',
            'content' => $model->date,
            ]);
        
        Yii::$app->view->registerMetaTag([
            'property' => 'og:article:author',
            'content' => ucwords($masterArticles->employees->first_name.' '.$masterArticles->employees->last_name),
            ]);
        
        Yii::$app->view->registerMetaTag([
            'property' => 'og:article:tag',
            'content' => $model->title.', '.$this->getTags($model->tags, ', ').$model->mini_title.', '.'sdn 2 taman baru',
            ]);
       
        Yii::$app->view->registerMetaTag([
            'property' => 'twitter:card',
            'content' => 'summary',
        ]);        
        
        Yii::$app->view->registerMetaTag([
            'property' => 'twitter:site',
            'content' => '@aristo_bharata',
        ]);
        
        Yii::$app->view->registerMetaTag([
            'property' => 'twitter:title',
            'content' => $model->title,
        ]);
        
        Yii::$app->view->registerMetaTag([
            'property' => 'twitter:description',
            'content' => preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $tagP_replace),
        ]);
        
        Yii::$app->view->registerMetaTag([
            'property' => 'twitter:image:alt',
            'content' => $model->title,
        ]);
        
        $tags = explode(',', $model->tags);
        
        
        return $this->render('read',[
            'model' => $model,
            'masterArticles' => $masterArticles,
            'countMedias' => $countMedias,
            'countFiles' => $countFiles,
            'medias' => $medias,
            'files' => $files,
            'employees' => $employees,
            'countIndexRelatedArticles' => $countIndexRelatedArticles,
            'limitIndexRelatedArticles' => $limitIndexRelatedArticles,
            'indexRelatedArticles' => $indexRelatedArticles,
            'countLatestArticles' => $countLatestArticles,
            'limitLatestArticles' => $limitLatesArticles,
            'latestArticles' => $latestArticles,
            'indexPengumuman' => $indexPengumuman,
            'tags' => $tags,
            'employees' => $employees,
            'indexBeritaTerbaru' => $indexBeritaTerbaru,
            'about' => self::ABOUT,
        ]);
    }
    
    public function actionNiche($keystring) {
        $this->header();
        $keys = str_replace('-', ' ', $keystring);
        $query = (new Query());
        $query->select('articles.*, articles.id as article_id, articles.description as article_desc, master_articles.*, master_articles.id as master_article_id, medias.*, medias.id as media_id, medias.description as media_desc, files.*, files.id as file_id, files.description as file_desc, employees.*, employees.id as  employees_id, employees.description as employee_desc')
                ->from('master_articles')
                ->join('LEFT JOIN', 'articles', 'articles.id = master_articles.articles_id')
                ->join('LEFT JOIN', 'master_articles_media', 'master_articles_media.master_articles_id = master_articles.id')
                ->join('LEFT JOIN', 'master_articles_file', 'master_articles_file.master_articles_id = master_articles.id')
                ->join('LEFT JOIN', 'medias', 'medias.id = master_articles_media.medias_id')
                ->join('LEFT JOIN', 'files', 'files.id = master_articles_file.files_id')
                ->join('LEFT JOIN', 'employees', 'employees.id = master_articles.employees_id')
                ->where(['IN','article_categories_id', self::BERITA])
                ->andWhere(['articles.mini_title' => $keys])
                ->andWhere(['articles.status' => self::ACTIVE_STATUS])
                ->andWhere(['articles.position' => self::POSITION_LIVE])
                ->orderBy(['articles.date' => SORT_DESC, 'articles.id' => SORT_DESC])
                ->all();
        
        $countArticles = $query->count();
        $pagination = new Pagination([
            'defaultPageSize' => 12,
            'totalCount' => $countArticles,
        ]);
        $articles = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        
        //$allNiche = $this->getContentByString(self::DESTINATIONS, 'niche', $keys);
        
        $countIndexBeritaTerbaru = count($this->getCountGenericContent(self::BERITA));
        $limitIndexBeritaTerbaru = 8;
        $indexBeritaTerbaru = $this->getGenericContent(self::BERITA, $limitIndexBeritaTerbaru);
        
        $countPengumuman = count($this->getCountPopularContent(self::PENGUMUMAN));
        $limitPengumuman = 8;
        $indexPengumuman= $this->getPopularContent(self::PENGUMUMAN, $limitPengumuman);
        
        $this->bodyID = 'index-berita-niche';
        /**
         * meta property
         */
        $miniTitles = '';
        foreach ($articles as $article){
            $miniTitles .= $article['title'].', '.$this->getTags($article['tags'], ',');
        }
        
        Yii::$app->view->title = ucwords($keys). ' | Blog';
        Yii::$app->view->registerMetaTag([
            'property' => 'description',
            'content' => 'Library of '. ucwords($keys).' in sdn2tamanbaru.sch.id',
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'keywords',
            'content' => 'sdn 2 taman baru, berita, '.$miniTitles,
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:title',
            'content' => ucwords($keys). ' | Berita',
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:description',
            'content' => 'Library of '. ucwords($keys).' in sdn2tamanbaru.sch.id',
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:url',
            'content' => Yii::$app->params['homeLink'].'/berita/niche/'.$keystring,
            
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:type',
            'content' => 'website',
        ]);
        Yii::$app->view->registerLinkTag([
            'rel' => 'canonical',
            'href' => Yii::$app->params['homeLink'].'/berita/niche/'.$keystring,
        ]);
        
        return $this->render('niche',[
            'keys' => $keys,
            'countArticles' => $countArticles,
            'articles' => $articles,
            'pagination' => $pagination,
            //'allNiche' => $allNiche,
            //'latestArticles' => $latestArticles,
            //'popularArticles' => $popularArticles,
            'indexBeritaTerbaru' => $indexBeritaTerbaru,
            'indexPengumuman' => $indexPengumuman,
            'about' => self::ABOUT,
        ]);
    }
    
    public function actionTag($keystring) {
        
        $this->header();
        $keys = str_replace("-", " ", $keystring);
        
        $query = (new Query());
        $query->select('articles.*, articles.id as article_id, articles.description as article_desc, master_articles.*, master_articles.id as master_article_id, medias.*, medias.id as media_id, medias.description as media_desc, files.*, files.id as file_id, files.description as file_desc, employees.*, employees.id as  employees_id, employees.description as employee_desc')
                ->from('master_articles')
                ->join('LEFT JOIN', 'articles', 'articles.id = master_articles.articles_id')
                ->join('LEFT JOIN', 'master_articles_media', 'master_articles_media.master_articles_id = master_articles.id')
                ->join('LEFT JOIN', 'master_articles_file', 'master_articles_file.master_articles_id = master_articles.id')
                ->join('LEFT JOIN', 'medias', 'medias.id = master_articles_media.medias_id')
                ->join('LEFT JOIN', 'files', 'files.id = master_articles_file.files_id')
                ->join('LEFT JOIN', 'employees', 'employees.id = master_articles.employees_id')
                ->where(['LIKE','articles.mini_title', $keys])
                ->orWhere(['LIKE', 'articles.tags', $keys])
                ->orWhere(['LIKE','articles.title', $keys])
                ->orWhere(['LIKE','articles.description', $keys])
                ->orWhere(['LIKE','articles.article', $keys])
                ->orWhere(['LIKE','employees.first_name',$keys])
                ->orWhere(['LIKE','employees.last_name',$keys])
                ->orWhere(['LIKE','medias.media',$keys])
                ->orWhere(['LIKE','medias.description',$keys])
                ->orWhere(['LIKE','files.file',$keys])
                ->orWhere(['LIKE','files.description',$keys])
                ->andwhere(['article_categories_id' => self::BERITA])
                ->andWhere(['articles.status' => self::ACTIVE_STATUS])
                ->andWhere(['articles.position' => self::POSITION_LIVE])
                ->orderBy(['articles.date' => SORT_DESC, 'articles.id' => SORT_DESC])
                ->all();
        $countArticles = $query->count();
        $pagination = new Pagination([
            'defaultPageSize' => 12,
            'totalCount' => $countArticles,
        ]);
        
        $articles = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        
        $countIndexBeritaTerbaru = count($this->getCountGenericContent(self::BERITA));
        $limitIndexBeritaTerbaru = 8;
        $indexBeritaTerbaru = $this->getGenericContent(self::BERITA, $limitIndexBeritaTerbaru);
        
        $countPengumuman = count($this->getCountPopularContent(self::PENGUMUMAN));
        $limitPengumuman = 8;
        $indexPengumuman= $this->getPopularContent(self::PENGUMUMAN, $limitPengumuman);
        
        $this->bodyID = 'index-berita-tag';
        
        /**
         * Meta Property
         */
        
        $miniTitles = '';
        foreach ($articles as $article){
            $miniTitles .= $article['title'].', '.$this->getTags($article['tags'], ',');
        }
        
        Yii::$app->view->title = ucwords($keys). ' | Berita';
        Yii::$app->view->registerMetaTag([
            'property' => 'description',
            'content' => 'Library of '. ucwords($keys).' in sdn2tamanbaru.sch.id',
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'keywords',
            'content' => 'sdn 2 tamanbaru, sdn 2 tamanbaru, destinations, '.$miniTitles,
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:title',
            'content' => ucwords($keys). ' | Berita',
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:description',
            'content' => 'Library of '. ucwords($keys).' in sdn2tamanbaru.sch.id',
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:url',
            'content' => Yii::$app->params['homeLink'].'/berita/tag/'.$keystring,
            
        ]);
        Yii::$app->view->registerMetaTag([
            'property' => 'og:type',
            'content' => 'website',
        ]);
        Yii::$app->view->registerLinkTag([
            'rel' => 'canonical',
            'href' => Yii::$app->params['homeLink'].'/berita/tag/'.$keystring,
        ]);
        
        return $this->render('tag',[
            'keys' => $keys,
            'countArticles' => $countArticles,
            'articles' => $articles,
            'pagination' => $pagination,
            //'latestArticles' => $latestArticles,
            //'popularArticles' => $popularArticles,
            'indexBeritaTerbaru' => $indexBeritaTerbaru,
            'indexPengumuman' => $indexPengumuman,
            'about' => self::ABOUT,
        ]);
    }
    
    /**
     * 
     * @param int $id
     * @param string $slug
     * @return array
     * @throws NotFoundHttpException
     */
    protected function findModel($id,$slug) 
    {
        if(($model = Articles::find()
                ->where(['id' => $id])
                ->andWhere(['slug' => $slug])
                ->andWhere(['status' => self::ACTIVE_STATUS])
                ->andWhere(['position' => self::POSITION_LIVE])
                ->one()) !== null){
            return $model;
        }else{
            throw new NotFoundHttpException('Page Not Found');
        }
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
            ->where(['IN','article_categories_id', $categoriesID])
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
    
    protected function getGenericContentByString($categoriesID, $keystring, $limit, $articlesID) {
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
            ->andWhere(['articles.mini_title' => $keystring])
            ->andWhere(['!=', 'articles.id', $articlesID])
            ->andwhere(['articles.status' => self::ACTIVE_STATUS])
            ->andwhere(['articles.position' => self::POSITION_LIVE])
            ->limit($limit)
            ->orderBy(['articles.date' => SORT_DESC, 
                'articles.id' => SORT_DESC]);
        return $query->createCommand()->queryAll();
    }
    
    protected function getCountGenericContentByString($categoriesID, $keystring, $articlesID) {
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
            ->andWhere(['articles.mini_title' => $keystring])
            ->andWhere(['!=', 'articles.id', $articlesID])
            ->andwhere(['articles.status' => self::ACTIVE_STATUS])
            ->andwhere(['articles.position' => self::POSITION_LIVE])
            ->orderBy(['articles.date' => SORT_DESC, 
                'articles.id' => SORT_DESC]);
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

    protected function getCountPopularContent($categoriesID) {
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
            ->orderBy(['articles.date' => SORT_DESC,
                        'articles.id' => SORT_DESC,
                        'master_articles.viewer' => SORT_ASC]);
        return $query->createCommand()->queryAll();
    }
    
    protected function getPopularContent($categoriesID, $limit) {
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
            ->limit($limit)
            ->orderBy(['articles.date' => SORT_DESC,
                        'articles.id' => SORT_DESC,
                        'master_articles.viewer' => SORT_ASC]);
        return $query->createCommand()->queryAll();
    }
    
    protected function getAllNiche($categoriesID, $miniTitle=null) 
    {
        if($miniTitle != null){
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
                ->andWhere(['!=', 'mini_title' , $miniTitle])
                ->andWhere(['articles.status' => self::ACTIVE_STATUS])
                ->andWhere(['articles.position' => self::POSITION_LIVE])
                ->orderBy(['articles.date' => SORT_DESC, 'articles.id' => SORT_DESC])
                ->groupBy(['articles.mini_title']);
        }else{
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
                ->orderBy(['articles.date' => SORT_DESC, 'articles.id' => SORT_DESC])
                ->groupBy(['articles.mini_title']);
        }
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