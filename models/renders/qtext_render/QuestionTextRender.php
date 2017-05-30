<?php
namespace gypsyk\quiz\models\renders\qtext_render;

final class QuestionTextRender extends \gypsyk\quiz\models\renders\AbstractQuestionRender
{
    public function __construct()
    {
        static::$viewFilePath = 'qtext_render/views/';
        parent::__construct();
    }
}