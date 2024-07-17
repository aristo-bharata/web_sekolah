<?php

namespace common\models;

use Yii;
use backend\controllers\EmployeesController;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\Security;
use yii\db\Query;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property int $previleges_id
 * @property string $username
 * @property string $password
 * @property string $password_hash
 * @property string $password_hint
 * @property int $remember_me
 * @property string $auth_key
 * @property string $token
 * @property string $password_reset_token
 * @property int $status
 * @property string $created_timestamp
 * @property string $modified_timestamp
 *
 * @property MasterEmployees[] $masterEmployees
 * @property MasterStudents[] $masterStudents
 * @property Previleges $previleges
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['previleges_id', 'username', 'password', 'password_hash', 'password_hint', 'remember_me', 'auth_key', 'token', 'password_reset_token', 'status'], 'required'],
            [['previleges_id', 'remember_me', 'status'], 'integer'],
            [['auth_key'], 'string'],
            [['created_timestamp', 'modified_timestamp'], 'safe'],
            [['username', 'password', 'password_hash', 'password_hint', 'password_reset_token'], 'string', 'max' => 255],
            [['token'], 'string', 'max' => 16],
            [['previleges_id'], 'exist', 'skipOnError' => true, 'targetClass' => Previleges::className(), 'targetAttribute' => ['previleges_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'previleges_id' => 'Previleges ID',
            'username' => 'Username',
            'password' => 'Password',
            'password_hash' => 'Password Hash',
            'password_hint' => 'Password Hint',
            'remember_me' => 'Remember Me',
            'auth_key' => 'Auth Key',
            'token' => 'Token',
            'password_reset_token' => 'Password Reset Token',
            'status' => 'Status',
            'created_timestamp' => 'Created Timestamp',
            'modified_timestamp' => 'Modified Timestamp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMasterEmployees()
    {
        return $this->hasMany(MasterEmployees::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrevileges()
    {
        return $this->hasOne(Previleges::className(), ['id' => 'previleges_id']);
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
    
    public static function findIdentity($id) 
    {
        return static::findOne(['id' => $id, 'status' => 1]);
    }
    
    public static function findIdentityByAccessToken($token, $type = null)
    {
          return static::findOne(['access_token' => $token]);
    }
    
    /**
     * Finds user by username
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
    
    /**
     * Finds user by password reset token
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public function getId() 
    {
        return $this->getPrimaryKey();
    }
    
    /**
     * @inheritdoc
     */
    public function getAuthKey() 
    {
        return $this->auth_key;
    }
    
    /**
     * inheritdoc
     */
    public function validateAuthKey($authKey) 
    {
        return $this->getAuthKey() == $authKey;
    }
    
    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        //return $this->password === sha1($password);
        return $this->password_hash === hash('md5', $password);
    }
    
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    
    public function setPassword($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }
    
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $security = new Security;
        //$this->auth_key = Security::generateRandomKey();
        $this->auth_key = $security->generateRandomString();
        return $this->auth_key;
    }
    
    public function generateToken(){
        $characters = 16;
        $letters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str='';
        for ($i=0; $i<$characters; $i++) { 
                $str .= substr($letters, mt_rand(1, strlen($letters)-1), 1);
        }
        return $str;
    }
    
    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $security = new Security;
        $this->password_reset_token = $security->generateRandomString() . '_' . time();
        //$this->password_reset_token = Security::generateRandomKey() . '_' . time();
        return $this->password_reset_token;
    }
    
    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    public function getUser($email){
        $_email = self::find()
                ->where(['=', 'username', $email])
                ->count();
        if($_email > 0){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    
    public function setUser($email){
        $query = (new Query())
                ->select('*')
                ->from('user')
                ->where(['username' => $email]);
        return $query->createCommand()->queryOne();
                
    }
    
    public function actionUser($userID=null, $email=null, $password=null, $passwordHint=null, $previlegesID=null)
    {
        if(isset($userID)){
            self::findAll(['id' => $userID]);
            if(isset($email)){
                $this->username = $email;
            }

            if(isset($password)){
                $this->password = $this->setPassword($password);
                $this->password_hash = hash('md5', $password);
            }

            if(isset($passwordHint)){
                $this->password_hint = $passwordHint;
            }
            if(isset($previlegesID)){
                $this->previleges_id  = $previlegesID;
            }

            if($this->validate()){
                $this->update();
            }
        }else{
            $this->username = $email;
            $this->password = $this->setPassword($password);
            $this->previleges_id = $previlegesID;
            //$this->user_type_id = $userTypeID;
            $this->password_hash = hash('md5', $password);
            $this->password_hint = $passwordHint;
            $this->remember_me = 0;
            $this->password_reset_token = $this->generateToken();
            $this->generateAuthKey();
            $this->token = $this->generateToken();
            //$this->password_reset_token = $this->generateToken();
            $this->status = 1;
            if($this->validate()){
                return $this->save();
            }
        }
    }
    
    public function actionChangepass($userID=null, $password=null, $passwordHint=null) {
        
    }
}