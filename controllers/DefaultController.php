<?php

namespace gypsyk\quiz\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\{Json, ArrayHelper};
use gypsyk\quiz\models\{AR_QuizQuestion, Quiz, AR_QuizTest};
use yii\web\{NotAcceptableHttpException, NotFoundHttpException, BadRequestHttpException};


/**
 * Default controller for the `quiz` module
 */
class DefaultController extends \yii\web\Controller
{
    /**
     * Renders the list of tests
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        if(!Yii::$app->controller->module->showTestListOnIndex)
            throw new NotFoundHttpException('Такой страницы не существует');
        
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
     * Page for rendering test question
     * 
     * @param $question
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     * @throws NotAcceptableHttpException
     */
    public function actionTest($question)
    {
        $session = Yii::$app->session;
        $session->open();

        if(empty($session['currentTestId'])) {
            throw new BadRequestHttpException('Во время загрузки вопросов произошла ошибка. Попрубуйте зайти в тест заново');
        }

        if(!empty($session['isResults']) && $session['isResults']) {
            throw new NotAcceptableHttpException('Доступ к тесту невозможен после его завершения');
        }
        
        $qModel = Quiz::getQuestionObjectById($session['questionIds'][$question]);

        if(Yii::$app->request->isPost) {

            if(array_key_exists($question, $session['answers'])) {
                $answersTemp = $session['answers'];
                $answersTemp[$question] = Yii::$app->request->post('answer');
                $session['answers'] = $answersTemp;
            } else {
                $session['answers'] = ArrayHelper::merge($session['answers'], [$question => Yii::$app->request->post('answer')]);
            }

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
            'questionText' => $qModel->getQuestionText(),
            'questionRender' => $qModel->getRender()->renderTesting(Json::decode($qModel->jsonVariants, false)),
            'questionList' => $session['questionIds']
        ]);
    }

    /**
     * Proxy page for init session vars
     * 
     * @param $test_id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEnter($test_id)
    {
        if(empty($test_id)) {
            throw new NotFoundHttpException('Такого теста не найдено');
        }

        $testModel = AR_QuizTest::findone($test_id);

        $session = Yii::$app->session;
        $session->open();

        //Clear all the quiz session vars
        $session->remove('currentTestId');
        $session->remove('questionIds');
        $session->remove('answers');
        $session->remove('isResults');

        $session['currentTestId'] = $test_id;
        $session['questionIds'] = AR_QuizQuestion::getShuffledQuestionArray($test_id);
        $session['answers'] = [];

        return $this->redirect(['test', 'question' => 1]);
    }

    /**
     * Enter to quiz
     *
     * @param $test_id
     * @return string
     * @throws NotFoundHttpException
     */
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

    /**
     * Page for displaying the results of testing
     * 
     * @return string
     */
    public function actionResults()
    {
        $session = Yii::$app->session;
        $session->open();
        $session['isResults'] = true;

        $questionList = AR_QuizQuestion::findAll(['test_id' => $session['currentTestId']]);

        $quizModel = new Quiz($questionList, $session['questionIds']);
        $quizModel->loadUserAnswers($session['answers']);
        $quizModel->checkAnswers();

        return $this->render('results', [
            'quizModel' => $quizModel            
        ]);


    }
}
