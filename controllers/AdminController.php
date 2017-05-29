<?php

namespace gypsyk\quiz\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\{Controller, NotFoundHttpException};
use gypsyk\quiz\models\{Quiz, AR_QuizTest, AR_QuizQuestionType, AR_QuizQuestion};
use yii\data\ActiveDataProvider;

class AdminController extends Controller
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        \gypsyk\quiz\assets\QuizModuleAsset::register($this->getView()); //is this a good practice?))

        return true;
    }
    
    public function actionIndex()
    {
        $provider = new ActiveDataProvider([
            'query' => AR_QuizTest::find(),
            'pagination' => [
                'pageSize' => Yii::$app->controller->module->testListMaxItems,
            ],
        ]);

        return $this->render('index', [
            'testList' => $provider->getModels(),
            'pages' => $provider->getPagination()
        ]);
    }

    /**
     * Page for creating the test
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $testModel = new AR_QuizTest();

        if(Yii::$app->request->isPost) {
            if($testModel->load(Yii::$app->request->post()) && $testModel->validate()) {
                $testModel->save();

                return $this->redirect(['new-question', 'test_id' => $testModel->getPrimaryKey()]);
            }
        }
        
        return $this->render('create', [
            'testModel' => $testModel
        ]);
    }

    /**
     * Page for adding new question to test
     *
     * @param $test_id int - test id from database
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionNewQuestion($test_id)
    {
        if(empty($test_id)) {
            throw new NotFoundHttpException('Такого теста не найдено');
        }
        
        if(Yii::$app->request->isPost) {
            $result = Quiz::saveQuestionToDb(Yii::$app->request->post(), $test_id);
            
            if($result) {
                return $this->refresh();
            }
        }
        
        $questionList = AR_QuizQuestion::getTestQuestions($test_id);
        $testModel = AR_QuizTest::findOne($test_id);

        $types = AR_QuizQuestionType::find()->all();
        $tList[0] = Yii::$app->controller->module->t('app', 'Select type of answer...');
        foreach ($types as $type) {
            $tList[$type->getPrimaryKey()] = Yii::$app->controller->module->t('app', $type->description);
        }
        
        return $this->render('new_question', [
            'questionList' => $questionList,
            'testModel' => $testModel,
            'tList' => $tList,
            'questionViews' => Quiz::renderQuestionCreate($this->getView())
        ]);
    }
}
