st_name . ' ' . $model->last_name;
                        if($this->countMasterEmployeesMedia($model->id) > 0){
                            $medias->uploadEmployeesMedia($masterEmployeesMedia->getEmployeesFoto($id)['medias_id'], $id, $description);
                        } else {
                            $medias->uploadEmployeesMedia(null, $id, $description);
                        } 
                    } else {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
            'user' => $user,
            'medias' => $medias,
            'medias_' => $medias_,
            'masterEmployeesMedia' => $masterEmployeesMedia,
        ]);
    }

    /**
     * Updates an existing Employees model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionContentwriterUpdate($id)
    {
        $model = $this->findModel($id);
        $user = User::findOne($this->getMasterEmployees($id)['user_id']);

        if($this->countMasterEmployeesMedia($model->id) > 0){
            $medias_ = Medias::findOne($this->getMasterEmployeesMedia($model->id)['medias_id']);
        }else{
            $medias_ = null;
        }
        
        $medias = new Medias();
        $masterEmployeesMedia = new MasterEmployeesMedia();
        
        if($model->load(Yii::$app->request->post())){
            if(isset(\Yii::$app->request->post()['User']['username'])){
                $email = Yii::$app->request->post()['User']['username'];
            } else {
                $email = null;
            }
            
            if(isset(Yii::$app->request->post()['User']['password'])){
                $password = Yii::$app->request->post()['User']['password'];
            } else {
                $password = null;
            }
            
            if((isset(Yii::$app->request->post()['User']['password_hint']))){
                $passwordHint = \Yii::$app->request->post()['User']['password_hint'];
            }else{
                $passwordHint = null;
            }
            
            $uid = $user->id;
            $user->actionUser($uid, $email, $password, $passwordHint, 2);
            if($model->validate()){
                $model->update();
                if(Yii::$app->request->post('foto_x') == "1"){
                    $masterEmployeesMedia->deleteEmployeesFoto($id);
                    $medias->deleteMedia();
                } else {
                    if($medias->load(\Yii::$app->request->post())){
                        $description = $model->first_name . ' ' . $model->last_name;
                        if($this->countMasterEmployeesMedia($model->id) > 0){
                            $medias->uploadEmployeesMedia($masterEmployeesMedia->getEmployeesFoto($id)['medias_id'], $id, $description);
                        } else {
                            $medias->uploadEmployeesMedia(null, $id, $description);
                        } 
                    } else {
                        return $this->redirect(['contentwriter-view', 'id' => $model->id]);
                    }
                }
            }
            return $this->redirect(['contentwriter-view', 'id' => $model->id]);
        }
        return $this->render('contentwriter-update', [
            'model' => $model,
            'user' => $user,
            'medias' => $medias,
            'medias_' => $medias_,
            'masterEmployeesMedia' => $masterEmployeesMedia,
        ]);
    }
    
    /**
     * Updates an existing Employees model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionContentwriterChangepass($id) {
        $model = $this->findModel($id);
        $user = User::findOne($this->getMasterEmployees($id)['user_id']);

        if($this->countMasterEmployeesMedia($model->id) > 0){
            $medias_ = Medias::findOne($this->getMasterEmployeesMedia($model->id)['medias_id']);
        }else{
            $medias_ = null;
        }
        
        $medias = new Medias();
        $masterEmployeesMedia = new MasterEmployeesMedia();
        
        if($user->load(Yii::$app->request->post())){
            
            if(isset(Yii::$app->request->post()['new_password'])){
                $password = Yii::$app->request->post()['new_password'];
            } else {
                $password = null;
            }
            
            if((isset(Yii::$app->request->post()['new_password-hint']))){
                $passwordHint = \Yii::$app->request->post()['new_password-hint'];
            }else{
                $passwordHint = null;
            }
            
            $uid = $user->id;
            $user->actionUser($uid, null, $password, $passwordHint, 2);
            
            //echo $uid .' ' . $password .' ' . $passwordHint;
            
            return $this->redirect(['contentwriter-view', 'id' => $model->id]);
        }
        
        return $this->render('contentwriter-changepass', [
            'model' => $model,
            'user' => $user,
            'medias' => $medias,
            'medias_' => $medias_,
            'masterEmployeesMedia' => $masterEmployeesMedia,
        ]);
        
    }
    
    /**
     * Deletes an existing Employees model.
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
     * Finds the Employees model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Employees the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employees::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function getMasterEmployees($id) {
        $query = (new Query())
                ->select('*')
                ->from('master_employees')
                ->where(['=', 'employees_id', $id]);
        return $query->createCommand()->queryOne();
    }
    protected function getMasterEmployeesMedia($id) 
    {
        $query = (new Query())
                ->select('*')
                ->from('master_employees_media')
                ->where(['=', 'employees_id', $id]);
        return $query->createCommand()->queryOne();
    }
    
    protected function countMasterEmployeesMedia($id) 
    {
        $query = (new Query())
                ->select('*')
                ->from('master_employees_media')
                ->where(['=', 'employees_id', $id]);
        return $query->createCommand()->query()->count();
    }
    protected function ge