<?php
namespace gypsyk\quiz\models\renders\qtext_render;

use gypsyk\quiz\models\renders\Context;

class QuestionTextRender extends \yii\web\View
{
    public static $viewFilePath = 'qtext_render/views/';
    public $question;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Load the question object to renderer
     * 
     * @param \gypsyk\quiz\models\questions\QuestionText $question
     */
    public function loadQuestion(\gypsyk\quiz\models\questions\QuestionText $question)
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
        return parent::render(self::$viewFilePath . 'result', ['question' => $this->question], new Context());
    }

    /**
     * Render the view part of question on quiz page
     *
     * @return string
     */
    public function renderTesting()
    {
        return parent::render(self::$viewFilePath . 'testing', [], new Context());
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