<?php

namespace frontend\controllers;

use yii;
use yii\web\Controller;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\MasterArticles;
use common\models\Articles;
use common\models\ArticleCategories;
use common\models\MasterArticlesMedia;
use common\models\Medias;
use common\models\Employees;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

class SearchController extends Controller
{
    public $bodyID;
    
    const ARTICLES = array(1,2,3,4);
    const ABOUT = array(9);
    const ACTIVE_STATUS = 1;
    const NOTACTIVE_STATUS = 0;
    const POSITION_LIVE = 1;
    const POSITION_DRAFT = 0;
    const POSITION_TRASH = 10;
    
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($keystring = null) 
    {
        if(!isset($keystring)){
            return $this->redirect(Url::home());
        }else{
            $tag = str_replace('-', ' ', $keystring);
            $query = (new Query());
            $query->select('articles.*, articles.id as article_id, articles.description as article_desc, master_articles.*,  master_articles.id as m_article_id, master_articles_media.*, master_articles_media.id as m_articles_media_id, medias.description as media_desc, master_articles_file.*, master_articles_file.id as m_articles_file_id, medias.*, medias.id as m_id, files.*, files.id as f_id, employees.*,employees.id as em_id, article_categories.*, article_categories.id as articles_cat_id')
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
                    ->andWhere(['IN','article_categories_id', self::ARTICLES])
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
                'tag' => $tag,
                'articles' => $articles,
                'pagination' => $pagination,
                'about' => self::ABOUT,
            ]);
        }
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



