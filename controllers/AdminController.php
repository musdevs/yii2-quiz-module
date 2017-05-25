<?php

namespace gypsyk\quiz\controllers;

use gypsyk\quiz\models\AR_QuizQuestion;
use gypsyk\quiz\models\AR_QuizTest;
use gypsyk\quiz\models\Quiz;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AdminController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
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

        return $this->render('new_question', [
            'questionList' => $questionList,
            'testModel' => $testModel
        ]);
    }
}
