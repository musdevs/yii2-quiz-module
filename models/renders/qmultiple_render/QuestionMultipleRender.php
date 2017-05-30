<?php

namespace gypsyk\quiz\models\renders\qmultiple_render;

/**
 * Class for rendering the view parts of QuestionMultiple instance
 * 
 * Class QuestionMultipleRender
 * @package gypsyk\quiz\models\renders\qmultiple_render
 */
final class QuestionMultipleRender extends \gypsyk\quiz\models\renders\AbstractQuestionRender
{
    /**
     * QuestionMultipleRender constructor.
     */
    public function __construct()
    {
        static::$viewFilePath = 'qmultiple_render/views/';
        parent::__construct();
    }
}
