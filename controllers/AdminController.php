<?php

namespace gypsyk\quiz\controllers;

use gypsyk\quiz\models\AR_QuizQuestion;
use gypsyk\quiz\models\AR_QuizTest;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AdminController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

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

    public function actionNewQuestion($test_id)
    {
        if(empty($test_id)) {
            throw new NotFoundHttpException('Такого теста не найдено');
        }
            
        if(Yii::$app->request->isPost) {
            $question = new AR_QuizQuestion();
            $question->question = Yii::$app->request->post('question_text');
            $question->type = Yii::$app->request->post('question_type');

            if(Yii::$app->request->post('question_type') == 1) {

                //Prepare the wrong answers
                foreach (Yii::$app->request->post('wrong_one') as $wrongOne) {
                    $item['id'] = Yii::$app->security->generateRandomString(5);
                    $item['text'] = $wrongOne;
                    $wrong[] = $item;
                }

                //Prepare the right answer
                $item['id'] = Yii::$app->security->generateRandomString(5);
                $item['text'] = Yii::$app->request->post('right_one');
                $right[] = $item;
                $rightIds = $item['id'];

                $all = ArrayHelper::merge($wrong, $right);

                $question->answers = Json::encode($all);
                $question->r_answers = Json::encode($rightIds);
            }

            if(Yii::$app->request->post('question_type') == 2) {
                foreach (Yii::$app->request->post('wrong_many') as $wrongMany) {
                    $item['id'] = Yii::$app->security->generateRandomString(5);
                    $item['text'] = $wrongMany;
                    $wrong[] = $item;
                }
                foreach (Yii::$app->request->post('right_many') as $rightMany) {
                    $item['id'] = Yii::$app->security->generateRandomString(5);
                    $item['text'] = $rightMany;
                    $right[] = $item;
                    $rightIds[] = $item['id'];
                }
                $all = ArrayHelper::merge($wrong, $right);

                $question->answers = Json::encode($all);
                $question->r_answers = Json::encode($rightIds);
            }

            if(Yii::$app->request->post('question_type') == 3) {
                $question->answers = null;
                $question->r_answers = Json::encode(Yii::$app->request->post('custom'));
            }

            $question->test_id = $test_id;

            if($question->validate()) {
                $question->save();

                return $this->refresh();
            }
        }
        
        $questionList = AR_QuizQuestion::getTestQuestions($test_id);
        $testModel = AR_QuizTest::findone($test_id);

        return $this->render('new_question', [
            'questionList' => $questionList,
            'testModel' => $testModel
        ]);
    }
}
