<?php

namespace gypsyk\quiz\controllers;

use Yii;
use yii\helpers\Json;
use gypsyk\quiz\models\{AR_QuizQuestion, Quiz, AR_QuizTest};
use yii\web\{NotAcceptableHttpException, NotFoundHttpException, BadRequestHttpException};

/**
 * Default controller for the `quiz` module
 */
class DefaultController extends \yii\web\Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTest($question)
    {
        Yii::$app->session->open();
        $session = Yii::$app->session;

        if(empty($session['currentTestId'])) {
            throw new BadRequestHttpException('Во время загрузки вопросов произошла ошибка. Попрубуйте зайти в тест заново');
        }

        if(!empty($session['isResults']) && $session['isResults']) {
            throw new NotAcceptableHttpException('Доступ к тесту невозможен после его завершения');
        }
        
        $questionModel = AR_QuizQuestion::findOne($session['questionIds'][$question]);

        if(Yii::$app->request->isPost) {

            $_SESSION['answers'][$question] = Yii::$app->request->post('answer');

            if(Yii::$app->request->post('save_btn')) {
                $max = max(array_keys($session['questionIds']));
                if((int)$question < $max) {
                    return $this->redirect(['test', 'question' => $question+1]);
                } else {
                    return $this->refresh();
                }
            }
        }

        return $this->render('test', [
            'questionModel' => $questionModel,
            'questionList' => $session['questionIds'],
            'answers' => Json::decode($questionModel->answers, false)
        ]);
    }

    public function actionEnter($test_id)
    {
        if(empty($test_id)) {
            throw new NotFoundHttpException('Такого теста не найдено');
        }

        $testModel = AR_QuizTest::findone($test_id);

        Yii::$app->session->open();
        $session = Yii::$app->session;

        //Clear all the quiz session vars
        $session->remove('currentTestId');
        $session->remove('questionIds');
        $session->remove('answers');
        $session->remove('isResults');

        $session['currentTestId'] = $test_id;
        $session['questionIds'] = AR_QuizQuestion::getShuffledQuestionArray($test_id);

        return $this->redirect(['test', 'question' => 1]);
    }

    public function actionTestIndex($test_id)
    {
        if(empty($test_id)) {
            throw new NotFoundHttpException('Такого теста не найдено');
        }

        $testModel = AR_QuizTest::findone($test_id);

        return $this->render('test_index', [
            'testModel' => $testModel
        ]);
    }

    public function actionResults()
    {
        Yii::$app->session->open();
        $session = Yii::$app->session;
        $session['isResults'] = true;

        $questionList = AR_QuizQuestion::findAll(['test_id' => $session['currentTestId']]);

        $quizModel = new Quiz($questionList, $session['questionIds']);
        $quizModel->loadUserAnswers($_SESSION['answers']);
        $quizModel->checkAnswers();

        return $this->render('results', [
            'quizModel' => $quizModel            
        ]);


    }
}
