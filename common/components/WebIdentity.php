<?php

namespace common\components;

use Yii;
use yii\base\Component;
use common\models\Previleges;
use yii\helpers\ArrayHelper;
use common\models\Articles;
use common\models\MasterArticles;
use common\models\MasterArticlesMedia;
use common\models\ArticleTypes;
use common\models\ArticleCategories;
use common\models\Medias;
use yii\db\Query;

class WebIdentity extends Component
{
    const SETTING = 11;
    
    public function pageLogo() 
    {
        //return $this->findModel();
        return $this->getLogo();
    }
    
    public function pageCompanyname() {
        return $this->getCompanyName();
    }
    
    public function pageTag() {
        return $this->getTag();
    }
    
    public function pageDescription() {
        return $this->getDescription();
    }
    
    private function getLogo() 
    {
        $model = $this->findModel();
        if($countMasterArticles = MasterArticles::find()->where(['article_categories_id' => $model->id])->count() !== 0){
            $masterArticles = MasterArticles::find()->where(['article_categories_id' => $model->id])->one();
            $masterMedias = MasterArticlesMedia::find()->where(['master_articles_id' => $masterArticles->id])->one();
            $medias = Medias::find()->where(['id' => $masterMedias->medias_id])->one();
            return $medias;
            
        }else{
            $medias = NULL;
            return $medias;
        }
    }
    
    private function getCompanyName() {
        $model = $this->findModel();
        if($countMasterArticles = MasterArticles::find(['article_categories_id' => $model->id])->count() !== 0){
            $masterArticles = MasterArticles::find()->where(['article_categories_id' => $model->id])->one();
            $articles = Articles::find()->where(['id' => $masterArticles->articles_id])->one();
            return $articles->title;
        }else{
            $articles = NULL;
            return $articles;
        }
    }
    
    private function getTag() {
        $model = $this->findModel();
        if($countMasterArticles = MasterArticles::find(['article_categories_id' => $model->id])->count() !== 0){
            $masterArticles = MasterArticles::find()->where(['article_categories_id' => $model->id])->one();
            $articles = Articles::find()->where(['id' => $masterArticles->articles_id])->one();
            return $articles->tags;
        }else{
            $articles = NULL;
            return $articles;
        }
    }
    
    private function getDescription() {
        $model = $this->findModel();
        if($countMasterArticles = MasterArticles::find(['article_categories_id' => $model->id])->count() !== 0){
            $masterArticles = MasterArticles::find()->where(['article_categories_id' => $model->id])->one();
            $articles = Articles::find()->where(['id' => $masterArticles->articles_id])->one();
            return $articles->article;
        }else{
            $articles = NULL;
            return $articles;
        }
    }
    
    private function findModel() 
    {
        if($articleCategories = ArticleCategories::find()->where(['article_types_id' => self::SETTING])->count() !== 0){            
            $articleCategories = ArticleCategories::find()->where(['article_types_id' => self::SETTING])->one();
            return $articleCategories;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}