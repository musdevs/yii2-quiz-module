<?php
namespace gypsyk\quiz\models\renders\qone_render;

use gypsyk\quiz\models\renders\Context;

class QuestionOneRender extends \yii\web\View
{
    public static $viewFilePath = 'qone_render/views/';
    public $question;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Load the question object to renderer
     * 
     * @param \gypsyk\quiz\models\questions\QuestionOne $question
     */
    public function loadQuestion(\gypsyk\quiz\models\questions\QuestionOne $question)
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
