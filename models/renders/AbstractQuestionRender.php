<?php
namespace gypsyk\quiz\models\renders;

use gypsyk\quiz\models\renders\Context;

/**
 * Class AbstractQuestionRender
 * @package gypsyk\quiz\models\renders
 */
abstract class AbstractQuestionRender extends \yii\web\View
{
    /**
     * @var object - object of \gypsyk\quiz\models\questions\* class
     */
    public $question;

    /**
     * @var string - Keeps the path to renderer views
     */
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
     * Render the view part when testing in process
     *
     * @param null $variants
     * @param null $sAnswer
     * @return string
     */
    public function renderTesting($variants = null, $sAnswer = null)
    {
        return parent::render(
            self::$viewFilePath . 'testing', 
            ['answers' => $variants, 'sAnswer' => $sAnswer],
            new Context()
        );
    }

    /**
     * Render the view part of question on create page
     * 
     * @param $parentViewObject - object of yii\web\View class. Needs for register scripts to correct view
     * @return string
     */
    public function renderCreate($parentViewObject)
    {
        return parent::render(self::$viewFilePath . 'create', ['parentViewObject' => $parentViewObject], new Context());
    }
}