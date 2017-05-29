<?php

namespace gypsyk\quiz\models\renders\qmultiple_render;

use gypsyk\quiz\models\renders\Context;

class QuestionMultipleRender extends \yii\web\View
{
    public static $viewFilePath = 'qmultiple_render/views/';
    public $question;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Load the question object to renderer
     * 
     * @param \gypsyk\quiz\models\questions\QuestionMultiple $question
     */
    public function loadQuestion(\gypsyk\quiz\models\questions\QuestionMultiple $question)
    {
        $this->question = $question;
    }

    /**
     * Render the result part of question on results page
     *
     * @return string
     */
    public function renderResult()
    {
        return parent::render(self::$viewFilePath . 'results', ['question' => $this->question], new Context());
    }

    /**
     * Render the view part of question on quiz page
     *
     * @param $answers[] obj - json decoded variants of answers from `quiz_question`.`answers`
     * @return string
     */
    public function renderTesting($answers)
    {
        return parent::render(self::$viewFilePath . 'testing', ['answers' => $answers], new Context());
    }

    /**
     * Render the view part of question on create page
     *
     * @return string
     */
    public function renderCreate($parentViewObject)
    {
        return parent::render(self::$viewFilePath . 'create', ['parentViewObject' => $parentViewObject], new Context());
    }
}
