<?php
namespace gypsyk\quiz\models\renders\qone_render;

final class QuestionOneRender extends \gypsyk\quiz\models\renders\AbstractQuestionRender
{
    public function __construct()
    {
        static::$viewFilePath = 'qone_render/views/';
        parent::__construct();
    }
}
