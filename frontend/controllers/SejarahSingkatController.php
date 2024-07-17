<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Articles;
use common\models\MasterArticles;
use common\models\MasterArticlesFile;
use common\models\MasterArticlesMedia;
use common\models\Employees;
use common\models\Medias;
use common\models\Files;
use yii\db\Query;
use yii\data\Pagination;

class SejarahsingkatController extends Controller
{
    public $bodyID;
    
    const ARTICLES = array(1,2,3,4,5,6,7,8.9,10,11,12);
    const VISI_MISI = array(1); // 1 Visi Misi
    const SEJARAH = array(2); // 2 Sejarah Singkat
    const GTK = array(3); // 3 GTK
    const PD = array(4); // 4 PD
    const KOSP = array(5); // 5 KOSP
    const KURTILAS = array(6); // 6 Kurtilas
    const EKSKUL = array(7); // 7 Ekskul
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
    
    protected function header() {
        Yii::$app->articleattribute->header();
    }
    
    public function actionIndex() 
    {
        $this->header();
        $this->bodyID = 'index-ekskul';
        $query = new Query();
        $query->select('articles.*, articles.id as article_id, articles.description as article_desc, master_articles.*, master_articles.id as master_article_id, medias.*, medias.id as media_id, medias.description as media_desc, files.*, files.id as file_id, files.description as file_desc, employees.*, employees.id as  employees_id, employees.description as employee_desc')
                ->from('master_articles')
                ->join('LEFT JOIN', 'articles', 'articles.id = master_articles.articles_id')
                ->join('LEFT JOIN', 'master_articles_media', 'master_articles_media.master_articles_id = master_articles.id')
                ->join('LEFT JOIN', 'master_articles_file', 'master_articles_file.master_articles_id = master_articles.id')
                ->join('LEFT JOIN', 'medias', 'medias.id = master_articles_media.medias_id')
                ->join('LEFT JOIN', 'files', 'files.id = master_articles_file.files_id')
                ->join('LEFT JOIN', 'employees', 'employees.id = master_articles.employees_id')
                ->where(['article_categories_id' => self::VISI_MISI])
                ->andWhere(['articles.status' => self::ACTIVE_STATUS])
                ->andWhere(['articles.position' => self::POSITION_LIVE])
                ->orderBy(['articles.date' => SORT_DESC, 
                    'articles.id' => SORT_DESC])
                ->all();
        $countSejarahsingkat = $query->count();
        $pagination = new Pagination([
            'defaultPageSize' => 1,
            'totalCount' => $countSejarahsingkat,
        ]);
        
        $indexSejarahsingkat = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        
        $indexPengumuman = $this->getGenericContent(self::PENGUMUMAN, 5);
        $indexBeritaTerbaru = $this->getGenericContent(self::BERITA, 5);
        
        Yii::$app->view->title = 'Ekstra Kurikuler - sdn2tamanbaru.sch.id';
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'website resmi sdn 2 taman baru halaman visi misi sekolah',
        ]);
        
        return $this->render('index', [
            'indexSejarahsingkat' => $indexSejarahsingkat,
            'about' => self::ABOUT,
            'indexPengumuman' => $indexPengumuman,
            'indexBeritaTerbaru' => $indexBeritaTerbaru,
            'pagination' => $pagination,
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
    
    protected function getGenericContentByString($categoriesID, $keystring, $limit, $articlesID) 
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
    
    protected function getCountGenericContentByString($categoriesID, $keystring, $articlesID) 
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
            ->where(['in', 'article_categories_id', $categoriesID])
            ->andWhere(['articles.mini_title' => $keystring])
            ->andWhere(['!=', 'articles.id', $articlesID])
            ->andwhere(['articles.status' => self::ACTIVE_STATUS])
            ->andwhere(['articles.position' => self::POSITION_LIVE])
            ->orderBy(['articles.date' => SORT_DESC, 
                'articles.id' => SORT_DESC]);
        return $query->createCommand()->queryAll();
    }
    
    protected function getAllContent($categoriesID)
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
                ->where(['in', 'article_categories_id', $categoriesID])
                ->andWhere(['articles.status' => self::ACTIVE_STATUS])
                ->andWhere(['articles.position' => self::POSITION_LIVE])
                ->orderBy(['articles.date' => SORT_DESC]);
        return $query->createCommand()->queryAll();
    }

    protected function getCountPopularContent($categoriesID) 
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
            ->where(['in', 'article_categories_id', $categoriesID])
            ->andWhere(['articles.status' => self::ACTIVE_STATUS])
            ->andWhere(['articles.position' => self::POSITION_LIVE])
            ->orderBy(['articles.date' => SORT_DESC,
                        'articles.id' => SORT_DESC,
                        'master_articles.viewer' => SORT_ASC]);
        return $query->createCommand()->queryAll();
    }
    
    protected function getPopularContent($categoriesID, $limit) 
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