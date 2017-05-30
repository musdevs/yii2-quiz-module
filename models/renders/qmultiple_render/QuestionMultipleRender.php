<?php

namespace gypsyk\quiz\models\renders\qmultiple_render;

final class QuestionMultipleRender extends \gypsyk\quiz\models\renders\AbstractQuestionRender
{
    public function __construct()
    {
        static::$viewFilePath = 'qmultiple_render/views/';
        parent::__construct();
    }
}
