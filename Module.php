<?php

namespace gypsyk\quiz;

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
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
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
