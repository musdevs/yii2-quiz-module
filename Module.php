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

        // custom initialization code goes here
    }
}
