<?php

namespace gypsyk\quiz;

class Module extends \yii\base\Module
{
    public $showTestListOnIndex = true;
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

    public static function t($category, $message, $params = [], $language = null)
    {
        return \Yii::t('gypsyk/quiz/' . $category, $message, $params, $language);
    }
}
