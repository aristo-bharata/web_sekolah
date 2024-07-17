<?php
namespace common\components;

use yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use common\models\Articles;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ArticleStatistic extends Component
{
    public function viewStar($articlesID)
    {
        $article = Articles::findOne($articlesID);
        return $article->star;
    }
    
    public function viewLike($articlesID)
    {
        $article = Articles::findOne($articlesID);
        return $article->like;
    }
    
    public function viewDislike($articlesID)
    {
        $article = Articles::findOne($articlesID);
        return $article->dislike;
    }
    
    public function viewViews($articlesID)
    {
        $article = Articles::findOne($articlesID);
        return $article->views;
    }
    
    public function addStar($articlesID)
    {
        $article = Articles::findOne($articlesID);
        return $article->updateCounters(['star' => 1]);
    }
    
    public function addLike($articlesID)
    {
        $article = Articles::findOne($articlesID);
        return $article->updateCounters(['like' => 1]);
    }
    
    public function addDislike($articlesID)
    {
        $article = Articles::findOne($articlesID);
        return $article->updateCounters(['dislike' => 1]);
    }
    
    public function addViewer($articlesID)
    {
        $article = Articles::findOne($articlesID);
        return $article->updateCounters(['viewer' => 1]);
    }
    
    public function tagsManager($articlesID)
    {
        $article = Articles::findOne($articlesID);
        $splitTags = explode(',', $article->tags);
        return $splitTags;
    }
    
    private function countTagsWord($articlesID)
    {
        $article = Articles::findOne($articlesID);
        $splitTags = explode(',', $article->tags);
        return count($splitTags);
    }
}