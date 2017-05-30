<?php
namespace gypsyk\quiz\models\renders;

use gypsyk\quiz\models\renders\Context;

abstract class AbstractQuestionRender extends \yii\web\View
{
    public $question;
    public static $viewFilePath;

    /**
     * Load the question object to renderer
     *
     * @param $question - object of \gypsyk\quiz\models\questions\* class
     */
    public function loadQuestion($question)
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
     * @return string
     */
    public function renderTesting($answers = null, $sAnswer = null)
    {
        return parent::render(
            self::$viewFilePath . 'testing', 
            ['answers' => $answers, 'sAnswer' => $sAnswer], 
            new Context()
        );
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