<?php
namespace gypsyk\quiz\models\renders\qtext_render;

/**
 * Class for rendering the view parts of QuestionText instance
 * 
 * Class QuestionTextRender
 * @package gypsyk\quiz\models\renders\qtext_render
 */
final class QuestionTextRender extends \gypsyk\quiz\models\renders\AbstractQuestionRender
{
    /**
     * QuestionTextRender constructor.
     */
    public function __construct()
    {
        static::$viewFilePath = 'qtext_render/views/';
        parent::__construct();
    }
}