<?php
namespace gypsyk\quiz\models\renders\qone_render;

/**
 * Class for rendering the view parts of QuestionOne instance
 * 
 * Class QuestionOneRender
 * @package gypsyk\quiz\models\renders\qone_render
 */
final class QuestionOneRender extends \gypsyk\quiz\models\renders\AbstractQuestionRender
{
    /**
     * QuestionOneRender constructor.
     */
    public function __construct()
    {
        static::$viewFilePath = 'qone_render/views/';
        parent::__construct();
    }
}
