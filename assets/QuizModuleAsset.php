<?php

namespace gypsyk\quiz\assets;

class QuizModuleAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/gypsyk/yii2-quiz-module/assets';

    public $css = [
        'css/module.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset'
    ];
}