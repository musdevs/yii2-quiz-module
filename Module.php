<?php

namespace gypsyk\quiz;

use gypsyk\quiz\models\AR_QuizQuestion;
use Yii;

/**
 * Quiz module class
 * 
 * Class Module
 * @package gypsyk\quiz
 */
class Module extends \yii\base\Module
{
    /**
     * @var bool - If true, shows the list of all test on index page 
     */
    public $showTestListOnIndex = true;

    /**
     * @var int - Test per page in indesx page
     */
    public $testListMaxItems = 10;
    
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'gypsyk\quiz\controllers';

    /**
     * Yii2 dependency injection container
     *
     * @var
     */
    public $container;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
        $this->container = new \yii\di\Container();

        $this->container->set('Mapper', '\gypsyk\quiz\models\helpers\QuestionsTypeMapper');

        //params - array: 0 - question id in database
        $this->container->set('Question', function ($container, $params, $config) {
            $questionModel = AR_QuizQuestion::findOne($params[0]);

            if(empty($questionModel))
                return null;

            $qClass = $container->get('Mapper')->getQuestionClassByTypeName($questionModel->getTypeCode());

            return Yii::createObject($qClass, [$questionModel]);
        });

        //params - array: 0 - test id from db,
        $this->container->set('Quiz', function ($container, $params, $config) {
            $questionList = AR_QuizQuestion::findAll(['test_id' => $params[0]]);

            return Yii::createObject('gypsyk\quiz\models\Quiz', [$questionList, $params[1], $container]);
        });

    }

    /**
     * @inheritdoc
     */
    public function registerTranslations()
    {
        \Yii::$app->i18n->translations['gypsyk/quiz/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@vendor/gypsyk/yii2-quiz-module/messages',
            'fileMap' => [
                'gypsyk/quiz/app' => 'g_app.php',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        return \Yii::t('gypsyk/quiz/' . $category, $message, $params, $language);
    }
}
