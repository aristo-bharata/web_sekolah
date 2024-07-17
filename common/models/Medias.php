<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;
use common\models\MasterArticles;
use common\models\MasterArticlesMedia;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "medias".
 *
 * @property int $id
 * @property string $media
 * @property string|null $description
 * @property int $status
 * @property string $created_timestamp
 * @property string $modified_timestamp
 *
 * @property MasterArticlesMedia[] $masterArticlesMedia
 * @property MasterEmployeesMedia[] $masterEmployeesMedia
 */
class Medias extends \yii\db\ActiveRecord
{
    public $uploadMedias;
    
    /**
     * {@inheritDoc}
     */
    
    public function behaviors() 
    {
        return[
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_timestamp',
                'updatedAtAttribute' => 'modified_timestamp',
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['media', 'status'], 'required'],
            [['description'], 'string'],
            [['status'], 'integer'],
            [['created_timestamp', 'modified_timestamp'], 'safe'],
            [['media'], 'string', 'max' => 255],
            [['uploadMedias'],'file', 'skipOnEmpty'=> TRUE, 'extensions'=>'png, jpg, jpeg, webp', 'mimeTypes'=>'image/jpeg, image/png',],
        ];
    }
    

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'media' => 'Media',
            'description' => 'Description',
            'status' => 'Status',
            'created_timestamp' => 'Created Timestamp',
            'modified_timestamp' => 'Modified Timestamp',
            'uploadMedias' => 'Upload Medias',
         ];
    }

    /**
     * Gets query for [[MasterArticlesMedia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMasterArticlesMedia()
    {
        return $this->hasMany(MasterArticlesMedia::className(), ['medias_id' => 'id']);
    }

    /**
     * Gets query for [[MasterEmployeesMedia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMasterEmployeesMedia()
    {
        return $this->hasMany(MasterEmployeesMedia::className(), ['medias_id' => 'id']);
    }
    
    public static function find() 
    {
        return new MediasQuery(get_called_class());
    }
    
    public function tempDeleteMedia($id) 
    {
        $media = self::findOne(id);
        $media->status = 0;
        return $media->update();
    }
    
    public function deleteMedia() 
    {
        return self::deleteAll(['status' => 0]);
    }
    
    public function uploadEmployeesMedia($id=null, $employeesID, $description=null) 
    {
        $masterEmployeesMedia = new MasterEmployeesMedia();
        $foto = UploadedFile::getInstance($this, 'uploadMedias');
        if(isset($id)){
            $masterMediaFile = self::findAll(['id' => $id]);
        }else{
            $masterMediaFile = null;
        }
        
        if(empty($foto)){
            return FALSE;
        }else{
            if((!isset($id)) OR (count($masterMediaFile) == 0)){
                $this->media = '_'.time().'_'.$foto->baseName.'.'.$foto->extension;
                $this->description = $description;
                $this->status = 1;
                if($this->validate()){
                    $this->save();
                    $foto->saveAs($this->getUploadEmployeesPath().$this->media);
                    return $masterEmployeesMedia->saveEmployeesFoto($employeesID, $this->id);
                }
            }else if((isset($id)) OR (count($masterMediaFile) > 0)){
                $media = self::findOne($id);
                $media->media = '_'.time().'_'.$foto->baseName.'.'.$foto->extension;
                $media->description;
                if($media->validate()){
                    $media->update();
                    $foto->saveAs($this->getUploadEmployeesPath().$media->media);
                }
            }
        }
    }
    
    public function getUploadEmployeesPath() 
    {
        //production
        //$path = Yii::getAlias('@root').'/uploads/images/employees/';
        
        //develop
        $path = \Yii::getAlias('@frontend').'/web/uploads/images/employees/';
        return $path;
    }
    
    public function uploadPublicMedia($id=null, $masterArticlesID, $description=null) 
    {
        $masterArticleMedia = new MasterArticlesMedia();
        $foto = UploadedFile::getInstance($this, 'uploadMedias');
        if(isset($id)){
            $masterMediaFile = self::findAll(['id' => $id]);
        }else{
            $masterMediaFile = null;
        }
        
        if(empty($foto)){
            return FALSE;
        }else{
            if((!isset($id)) OR count($masterMediaFile) == 0){
                $this->media = '_'.time().'_'.$foto->baseName.'.'.$foto->extension;
                $this->description = $description;
                $this->status = 1;
                if($this->validate()){
                    $this->save();
                    $foto->saveAs($this->getUploadArticlePath().$this->media);
                    return $masterArticleMedia->saveMasterMedia($this->id, $masterArticlesID);
                }
            }else if((isset($id)) OR (count($masterMediaFile) > 0)){
                $media = self::findOne($id);
                $media->media = '_'.time().'_'.$foto->baseName.'.'.$foto->extension;
                //$media->description;
                
                if($media->validate()){
                    //var_dump($media->description);
                    $media->update();
                    $foto->saveAs($this->getUploadArticlePath().$media->media);
                }
            }
        }
    }
    
    public function getUploadArticlePath() 
    {
        //production
        //$path = Yii::getRootAlias('@root').'/uploads/images/public/';
        
        //develop
        $path = \Yii::getAlias('@frontend').'/web/uploads/images/public/';
        return $path;
    }
    
    public function getMedia($articleID) {
        $masterArticlesID = MasterArticles::find()->where(['articles_id' => $articleID])->one();
        //$masterMedia = MasterArticlesMedia::find()->where(['master_articles_id' => $masterArticlesID->id])->one();
        $masterMedia = MasterArticlesMedia::find()->where(['master_articles_id' => $masterArticlesID->id])->one();
        $countMasterMedia = MasterArticlesMedia::find()->where(['master_articles_id' => $masterArticlesID->id])->count();
        if($countMasterMedia !== 0){
            return $this->find()->where(['id' => $masterMedia->medias_id])->one();
        }else{
            return null;
        }
    }
}
