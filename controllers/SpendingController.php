<?php

namespace halumein\spending\controllers;

use Yii;
use halumein\spending\models\Spending;
use halumein\spending\models\search\SpendingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use halumein\spending\models\Category;

/**
 * SpendingController implements the CRUD actions for Spending model.
 */
class SpendingController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $this->module->adminRoles,
                    ],
                ]
            ],
        ];
    }

    /**
     * Lists all Spending models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SpendingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $userModelModel = $this->module->userModel;
        $activeUsers = $userModelModel::find()->active()->all();

        $cashboxClassName = $this->module->cashboxModel;
        $cashboxModel = new $cashboxClassName;
        $activeCashboxes = $cashboxModel->activeCashboxes;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'activeUsers' => $activeUsers,
            'activeCashboxes' => $activeCashboxes,
        ]);
    }

    /**
     * Displays a single Spending model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Spending model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Spending();

        if ($model->load(Yii::$app->request->post())){
            $postData = Yii::$app->request->post()['Spending'];

            $name = $postData['name'];
            $categoryId = $postData['category_id'];
            $cost = $postData['cost'];
            $cashboxId = $postData['cashbox_id'];

            $params = [];
            if ($postData['amount'] != "") {
                $params['amount'] = $postData['amount'];
            }

            if ($postData['comment']) {
                $params['comment'] = $postData['comment'];
            }

            //записываем на основаниии затраты через метод
            Yii::$app->spending->add($name, $cost, $categoryId, $cashboxId, $params);
            return $this->redirect(['index']);

        } else {
            $data = $model::find()
                ->select(['name as value', 'name as label'])
                ->distinct()
                ->asArray()
                ->all();
            $cashboxClassName = $this->module->cashboxModel;
            $cashboxModel = new $cashboxClassName;
            $activeCashboxes = $cashboxModel->activeCashboxes;

            return $this->render('create', [
                'model' => $model,
                'data' => $data,
                'activeCashboxes' => $activeCashboxes,
            ]);
        }
    }

    /**
     * Updates an existing Spending model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Spending model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Spending model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Spending the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Spending::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //=========== testMethods ============
    public function actionByPeriod()
    {
        $get = Yii::$app->request->get();
        $dateStart = $get['dateStart'];
        $dateStop = $get['dateStop'];

        $arrayTransactionByPeriod = Yii::$app->spending->getSumByPeriod($dateStart, $dateStop);

        echo "<pre>";
        var_dump($arrayTransactionByPeriod);
        die;
    }

    public function actionByCategory()
    {
        $get = Yii::$app->request->get();
        $dateStart = $get['dateStart'];
        $dateStop = $get['dateStop'];
        $modelCategory = Category::findOne($get['id']);
        $sumByCategory =  Yii::$app->spending->getAmountByCategory($modelCategory, $dateStart, $dateStop);

        echo "<pre>";
        var_dump($sumByCategory);
        die;

    }

    public function actionByCashbox()
    {
        $get = Yii::$app->request->get();
        $dateStart = $get['dateStart'];
        $dateStop = $get['dateStop'];
        $cashboxId = $get['id'];
        $sumByCashbox =  Yii::$app->spending->getAmountByCashbox($cashboxId, $dateStart, $dateStop);

        echo "<pre>";
        var_dump($sumByCashbox);
        die;

    }

    public function actionByName()
    {
        $get = Yii::$app->request->get();
        $name = $get['name'];
        $sumByName =  Yii::$app->spending->getSumByName($name);

        echo "<pre>";
        var_dump($sumByName);
        die;

    }
}
