<?php
namespace gypsyk\quiz\models\questions;

use Yii;
use yii\helpers\Html;

/**
 * Main parent class for all question instances
 *
 * Class AbstractQuestion
 * @package gypsyk\quiz\models\questions
 */
abstract class AbstractQuestion implements QuestionInterface
{
    /**
     * @var bool|null - Flag to mark user answer correct/not correct
     */
    public $userCorrect;

    /**
     * @var string - Text of question
     */
    public $text;

    /**
     * @var string|array|object - Keeps the json decoded object or just a text answer from `quiz_question`.`r_answers`
     */
    public $correctAnswer;

    /**
     * @var string|array - Keeps the user answer for question. Can be just text (for text question) or array of codes,
     * that stored in `quiz_question`.`r_answers` in 'id' property of json string
     */
    public $userAnswer;

    /**
     * @var string - Json string form `quiz_question`.`answers` field
     */
    public $jsonVariants;

    /**
     * @var null|array - Keeps the info about question variants of answer.
     * It is an array of the following type [
     *  'text' => (string)question text,
     *  'is_correct' => (bool) flag to mark as correct,
     *  'is_user_checked' => (bool) flag to mark id user checked this variant
     * ]
     */
    public $variants = null;

    /**
     * @var string - Keeps the class name of question render object
     */
    protected $renderClass;

    /**
     * @var object - Instance of $this->renderClass class
     */
    protected $renderer;

    /**
     * Get the question render object. And load question object to it.
     *
     * @return object
     * @throws \yii\base\InvalidConfigException
     */
    public function loadRender()
    {
        if(empty($this->renderer)) {
            $this->renderer = Yii::createObject($this->renderClass);
            $this->renderer->loadQuestion($this);
        }

        return $this->renderer;
    }

    /**
     * Get the text of the question
     * 
     * @return string
     */
    public function getQuestionText()
    {
        return Html::encode($this->text);
    }
}
