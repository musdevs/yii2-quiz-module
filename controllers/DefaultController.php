<?php

namespace gypsyk\quiz\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use gypsyk\quiz\models\{AR_QuizQuestion, Quiz, AR_QuizTest, TestSession};
use yii\web\{NotAcceptableHttpException, NotFoundHttpException, BadRequestHttpException};

/**
 * Default controller for the `quiz` module
 *
 * Class DefaultController
 * @package gypsyk\quiz\controllers
 */
//TODO: Translate http_error messages
class DefaultController extends \yii\web\Controller
{
    /**
     * @var \yii\di\Container
     */
    protected $_container;

    /**
     * Includes some necessary assets
     *
     * @param $view
     */
    private function preparePage($view)
    {
        \gypsyk\quiz\assets\QuizModuleAsset::register($view);  //is this a good practice?))
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $this->preparePage($this->getView());
        $this->_container =  Yii::$app->controller->module->container;

        return true;
    }

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
     * @param $question - index number of question
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     * @throws NotAcceptableHttpException
     */
    public function actionTest($question)
    {
        $session = new TestSession($question);

        if(empty($session->getVar('currentTestId'))) {
            throw new BadRequestHttpException('Во время загрузки вопросов произошла ошибка. Попрубуйте зайти в тест заново');
        }

        if($session->checkTestIsOver()) {
            throw new NotAcceptableHttpException('Доступ к тесту невозможен после его завершения');
        }
        
        $qModel = $this->_container->get('Question', [$session->getRealQuestionNumber($question)]);
        $testTitle = AR_QuizTest::findOne($session->getVar('currentTestId'))->name;

        if(Yii::$app->request->isPost) {

            //$_POST['answer] keeps the symbolic code of users choosed variants
            $session->saveUserAnswer(Yii::$app->request->post('answer'));

            if(Yii::$app->request->post('save_btn')) {
                $max = $session->getMaxTestQuestionNumber();
                if((int)$question < $max) {
                    return $this->redirect(['test', 'question' => $question+1]);
                } else {
                    return $this->refresh();
                }
            }
        }

        return $this->render('test', [
            'questionText' => $qModel->getQuestionText(),
            'questionRender' => $qModel->loadRender(),
            'jsonVariants' => $qModel->jsonVariants,
            'questionList' => $session->getVar('questionIds'),
            'questionId' => $question,
            'sAnswers' => $session->getVar('answers'),
            'testTitle' => $testTitle
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

        $session = new TestSession();
        $session->prepareForNewTest($test_id, AR_QuizQuestion::getShuffledQuestionArray($test_id));

        return $this->redirect(['test', 'question' => 1]);
    }

    /**
     * The index page of test
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

        $testModel = AR_QuizTest::findOne($test_id);
        $countQuestion = AR_QuizQuestion::count($test_id);

        return $this->render('test_index', [
            'testModel' => $testModel,
            'countQuestion' => $countQuestion
        ]);
    }

    /**
     * Page for displaying the results of testing
     * 
     * @return string
     */
    public function actionResults()
    {
        $session = new TestSession();
        $session->markTestAsOver();

        $quizModel = $this->_container->get('Quiz',[$session->getVar('currentTestId'), $session->getVar('questionIds')]);
        $quizModel->loadUserAnswers($session->getVar('answers'));
        $quizModel->checkAnswers();

        return $this->render('results', [
            'quizModel' => $quizModel            
        ]);
    }
}
