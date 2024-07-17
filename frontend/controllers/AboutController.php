<?php

namespace frontend\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use common\models\Employees;
use common\models\Articles;
use common\models\MasterEmployeesMedia;
use common\models\MasterArticlesMedia;
use common\models\MasterArticlesFile;
use common\models\MasterArticles;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use common\models\Medias;
use common\models\Files;

class AboutController extends Controller
{
    public $bodyID;
    
    const ACTIVE_STATUS = 1;
    const NOTACTIVE_STATUS = 0;
    const PRIVACY_POLICY = 3;
    const TOC = 4;
    const DISCLAIMER = 5;
    const ABOUT = array(9); 

    /**
     * 
     * @return mixed
     */
    public function actionIndex()
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
            'content' => Yii::$app->params['homeLink'].'/about/',
        ]);
        
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'vacation, tourism, cultures, urban tourism, '. $this->getTags($model->tags, ', '). ', vacationurban, regulation',
        ]);
                
        if($countMedia > 0){
            $countMedia = 1;
            $media = Medias::find()->where(['id' => $masterMedia->medias_id])->one();
            Yii::$app->view->registerMetaTag([
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
        
        $query = new Query();
        $query->select('master_employees.*, master_employees.id as masterEmployeesID, employees.*, employees.id as emp_id, master_employees_media.*, master_employees_media.id as master_employees_media_id, ')
                ->from('employees')
                ->join('LEFT JOIN', 'master_employees_media', 'master_employees_media.employees_id = employees.id')
                ->join('LEFT JOIN', 'master_employees', 'master_employees.employees_id = employees.id')
                ->where(['employees.status' => self::ACTIVE_STATUS])
                ->orderBy(['employees.id' => SORT_DESC])
                ->all();
        
        $pagination = new Pagination([
            'defaultPageSize' => 12,
            'totalCount' => $query->count(),
        ]);
        
        $employees = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        
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
        
        $medias = new Medias();
        
        return $this->render('index',[
            'model' => $model,
            'countMedia' => $countMedia,
            'media' => $media,
            'medias' => $medias,
            'countEmployee' => $query->count(),
            'employees' => $employees,
            'pagination' => $pagination,
            'tags' => $tags,
        ]);
    }

    /**
     * 
     * @param int $id
     * @return mixed
     */
    public function actionTeams($id) 
    {
        $this->bodyID = 'teams';
        $model = $this->findModelEmployees($id);
        $masterMedia = MasterEmployeesMedia::find()->where(['employees_id' => $id])->one();
        $countMedia = MasterEmployeesMedia::find()->where(['employees_id' => $id])->count();
        
        $pTag = array('<p>', '</p>', '<br>', '&nbsp;');
        $tagP_replace = str_replace($pTag, '', $model->description);
        
        Yii::$app->view->title = strtoupper($model->first_name.' '.$model->last_name). ' | vacationurban.com';
        Yii::$app->view->registerLinkTag([
            'rel' => 'canonical',
            'href' => Yii::$app->params['homeLink'].'/about/teams/'.$model->id.'/'.$model->first_name.'-'.$model->last_name,
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $tagP_replace),
        ]);
        
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'vacationurban.com, author, teams, '.$model->first_name.' '.$model->last_name.', vacation urban',
        ]);
        
        Yii::$app->view->registerMetaTag([
            'property' => 'og:title',
            'content' => 'about '.$model->first_name.' '.$model->last_name,
        ]);
        
        if($countMedia > 0){
            $medias = Medias::find()->where(['id' => $masterMedia->medias_id])->one();
            $countMedias = Medias::find()->where(['id' => $masterMedias->medias_id])->count();
            Yii::$app->view->registerMetaTag([
                'property' => 'og:image',
                'content' => Yii::$app->params['employeesImageLink'].'/'.$media->media]);
            Yii::$app->view->registerMetaTag([
                'property' => 'twitter:image',
                'content' => Yii::$app->params['employeesImageLink'].'/'.$media->media]);
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
        
        Yii::$app->view->registerMetaTag([
            'property' => 'og:description',
            'content' => preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $tagP_replace),
        ]);
        
        Yii::$app->view->registerMetaTag([
            'property' => 'og:url',
            'content' => Yii::$app->params['homeLink'].'/about/teams/'.$model->id.'/'.$model->first_name.'-'.$model->last_name,
        ]);
        
        Yii::$app->view->registerMetaTag([
            'property' => 'og:article:section',
            'content' => 'Team',
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
            
        ]);
        
        return $this->render('teams',[
            'model' => $model,
            'countMedia' => $countMedia,
            'medias' => $medias,
        ]);
    }

    /**
     * 
     * @param string $keystring
     * @return mixed
     */
    public function actionTag($keystring) 
    {            
        $model = $this->findModelByString($keystring);
        $masterArticles = MasterArticles::find()->where(['articles_id' => $model->id])->one();
        $masterMedias = MasterArticlesMedia::find()->where(['master_articles_id' => $masterArticles->id])->one();
        $countMedias = MasterArticlesMedia::find()->where(['master_articles_id' => $masterArticles->id])->count();
        $masterFiles = MasterArticlesFile::find()->where(['master_articles_id' => $masterArticles->id])->one();
        $countFiles = MasterArticlesFile::find()->where(['master_articles_id' => $masterArticles->id])->count();
        $employee = Employees::find()->where(['id' => $masterArticles->employees_id])->one();
        
        if($countMedias != 0){
            $countMedia = 1;
            $media = Medias::find()->where(['id' => $masterMedias->medias_id])->one();
        }else{
            $countMedia = 0;
            $media = null;
        }
        
        if($countFiles != 0){
            $countFile = 1;
            $file = Files::find()->where(['id' => $masterFiles->files_id])->one();
        }else{
            $countFile = 0;
            $file = null;
        }
        
        $this->bodyID = 'about-us';
        $this->updateViewer($model->id);
        
        \Yii::$app->view->title = ucwords($model->title).' | vacationurban.com';
        \Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $model->description,
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $model->tags.',about us, tourism, about vacationurban.com'
        ]);
        
        return $this->render('tag',[
            'model' => $model,
            'countMedias' => $countMedias,
            'countMedia' => $countMedia,
            'media' => $media,
            'countFile' => $countFile,
            'file' => $file,
        ]);
    }
    
    /**
     * 
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id) 
    {
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
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModelEmployees($id) 
    {
        if(($model = Employees::find()
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
     * @param string $keystring
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModelByString($keystring) 
    {
        if(($model = Articles::find()
                ->where(['LIKE','title', $keystring])
                ->one()) !== null){
            return $model;
        }else{
            throw new NotFoundHttpException('Page Not Found');
        }
    }

    /**
     * 
     * @param int $id
     * @return mixed
     */
    protected function updateViewer($id) 
    {
        $masterArticles = MasterArticles::find()->where(['articles_id' => $id])->one();
        return $masterArticles->updateCounters(['viewer' => 1]);
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
}