<?php

namespace gypsyk\quiz\controllers;

use gypsyk\quiz\models\AR_QuizQuestion;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;

class AdminController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionCreate()
    {
        if(Yii::$app->request->isPost) {
            $question = new AR_QuizQuestion();
            $question->question = Yii::$app->request->post('question_text');
            $question->type = Yii::$app->request->post('question_type');

            if(Yii::$app->request->post('question_type') == 1) {
                foreach (Yii::$app->request->post('wrong_one') as $wrongOne) {
                    $item['id'] = Yii::$app->security->generateRandomString(5);
                    $item['text'] = $wrongOne;
                    $wrong[] = $item;
                }
                foreach (Yii::$app->request->post('right_one') as $rightOne) {
                    $item['id'] = Yii::$app->security->generateRandomString(5);
                    $item['text'] = $rightOne;
                    $right[] = $item;
                    $rightIds[] = $item['id'];
                }
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

            $question->test_id = 1;

            if($question->validate()) {
                $question->save();
            }
        }
        
        return $this->render('create');
    }
}
