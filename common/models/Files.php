<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;
use common\models\MasterArticlesFile;

/**
 * This is the model class for table "files".
 *
 * @property int $id
 * @property string $file
 * @property string $extension
 * @property string|null $description
 * @property int $status
 * @property string $created_timestamp
 * @property string $modified_timestamp
 *
 * @property MasterArticlesFile[] $masterArticlesFiles
 */
class Files extends \yii\db\ActiveRecord
{
    public $uploadFiles;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file', 'extension', 'status'], 'required'],
            [['description'], 'string'],
            [['status'], 'integer'],
            [['created_timestamp', 'modified_timestamp'], 'safe'],
            [['file'], 'string', 'max' => 255],
            [['extension'], 'string', 'max' => 45],
            [['uploadFiles'],'file', 'skipOnEmpty'=> TRUE, 'extensions' => 'doc, docx, pdf, xls, xlsx, ppt, pptx'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => 'File',
            'extension' => 'Extension',
            'description' => 'Description',
            'status' => 'Status',
            'created_timestamp' => 'Created Timestamp',
            'modified_timestamp' => 'Modified Timestamp',
        ];
    }

    /**
     * Gets query for [[MasterArticlesFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMasterArticlesFiles()
    {
        return $this->hasMany(MasterArticlesFile::className(), ['files_id' => 'id']);
    }
    
    public static function find() 
    {
        return new FilesQuery(get_called_class());
    }
    
    public function tempDeleteFiles($id) 
    {
        $file = self::findOne($id);
        $file->status = 0;
        return $file->update();
    }
    
    public function deleteFile() 
    {
        return self::deleteAll(['status' => 0]);
    }
    
    public function uploadPublicFile($id=null, $masterArticlesID, $description) 
    {
        $masterArticlesFile = new MasterArticlesFile();
        $file = UploadedFile::getInstance($this, 'uploadFiles');
        if(isset($id)){
            $masterFilesFile = self::findAll(['id' => $id]);
        }else{
            $masterFilesFile = null;
        }
        
        if(empty($file)){
            return FALSE;
        }else{
            if((!isset($id)) OR (count($masterFilesFile) == 0)){
                $this->file = 'vacationuraban'.'_'.time().'_'.$file->baseName.'.'.$file->extension;
                $this->extension = $file->extension;
                $this->description = $description;
                $this->status = 1;
                if($this->validate()){
                    $this->save();
                    $file->saveAs($this->getUploadPublicPath().$this->file);
                    return $masterArticlesFile->saveMasterFile($this->id, $masterArticlesID);
                }
            }else if((isset($id)) OR (count($masterFilesFile) > 0)){
                $doc = self::findOne($id);
                $doc->file = 'vacationurban'.'_'.time().'_'.$file->baseName.'.'.$file->extension;
                $doc->extension = $file->extension;
                $doc->description = $description;
                if($doc->validate()){
                    $doc->update();
                    $file->saveAs($this->getUploadPublicPath().$doc->file);
                }
            }
        }
    }
    
    public function getUploadPublicPath() 
    {
        //production path
        //$path = \Yii::getAlias('@frontend').'/uploads/files/public/';
        
        //develop path
        $path = \Yii::getAlias('@frontend').'/web/uploads/files/public/';
        
        return $path;
    }
}
