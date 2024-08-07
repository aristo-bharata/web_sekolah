<?php

namespace backend\controllers;

use Yii;
use common\models\Webidentity;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\db\Query;
use yii\filters\VerbFilter;

/**
 * WebIdentityController implements the CRUD actions for WebIdentity model.
 */
class WebidentityController extends Controller
{
    const ACTIVE_STATUS = 1;
    const NOTACTIVE_STATUS = 0;
    const POSITION_LIVE = 1;
    const POSITION_DRAFT = 0;
    const POSITION_TRASH = 10;


    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all WebIdentity models.
     *
     * @return string
     * SELECT  master_web_identity.id as mweb_id, master_web_identity.article_types_id, 
            medias.media, medias.description, medias.status, 
            social_medias.social_media, social_medias.link_account,
            web_identity.id as wi_id, web_identity.title, web_identity.tags, 
            web_identity.description, web_identity.position, web_identity.status, 
            web_identity.create_timestamp, web_identity.modified_timestamp
        FROM master_web_identity
        LEFT JOIN web_identity ON master_web_identity.web_identity_id = web_identity.id
        LEFT JOIN master_social_medias_web_identity ON master_social_medias_web_identity.web_identity_id = master_web_identity.web_identity_id
        LEFT JOIN master_web_identity_media ON master_web_identity_media.master_web_identity_id = master_web_identity.id
        LEFT JOIN social_medias ON social_medias.id = master_social_medias_web_identity.social_medias_id
        LEFT JOIN medias ON medias.id = master_web_identity_media.medias_id
        LEFT JOIN article_types ON article_types.id = master_web_identity.article_types_id
        ORDER BY web_identity.id DESC
     */
    public function actionIndex()
    {
        $webidentity = new Query();
        $webidentity->select('master_web_identity.id as mweb_id, master_web_identity.article_types_id, medias.media, medias.description, medias.status, social_medias.social_media, social_medias.link_account, web_identity.id as wi_id, web_identity.title, web_identity.tags, web_identity.description, web_identity.position, web_identity.status, web_identity.create_timestamp, web_identity.modified_timestamp')
                ->from('master_web_identity')
                ->join('LEFT JOIN', 'web_identity', 'master_web_identity.web_identity_id = web_identity.id')
                ->join('LEFT JOIN', 'master_social_medias_web_identity', 'master_social_medias_web_identity.web_identity_id = master_web_identity.web_identity_id')
                ->join('LEFT JOIN', 'master_web_identity_media', 'master_web_identity_media.master_web_identity_id = master_web_identity.id')
                ->join('LEFT JOIN', 'social_medias', 'social_medias.id = master_social_medias_web_identity.social_medias_id')
                ->join('LEFT JOIN', 'medias', 'medias.id = master_web_identity_media.medias_id')
                ->join('LEFT JOIN', 'article_types', 'article_types.id = master_web_identity.article_types_id')
                ->where(['web_identity.status' => self::ACTIVE_STATUS])
                ->andWhere(['web_identity.position' => self::POSITION_LIVE])
                ->orderBy(['wi_id' => SORT_DESC])
                ->all();
        $countWebidentity = $webidentity->count();

        return $this->render('index', [
            'webidentity' => $webidentity,
            'countWebidentity' => $countWebidentity,
        ]);
    }

    /**
     * Displays a single WebIdentity model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new WebIdentity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new WebIdentity();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing WebIdentity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing WebIdentity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the WebIdentity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return WebIdentity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WebIdentity::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
