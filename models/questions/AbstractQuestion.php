<?php
namespace gypsyk\quiz\models\questions;

use Yii;
use yii\helpers\Html;
use gypsyk\quiz\models\AR_QuizQuestion;

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
     * @var integer - Question type id from database
     */
    public $questionTypeId;

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
        return Html::decode($this->text);
    }

    /**
     * @inheritdoc
     */
    public static function saveToDb($parameters, $test_id)
    {
        $question = new AR_QuizQuestion();
        $question->question = $parameters['question_text'];
        $question->type = $parameters['question_type'];

        $pAnswers = static::prepareAnswer($parameters);

        $question->answers = $pAnswers['answer'];
        $question->r_answers = $pAnswers['r_answer'];

        $question->test_id = $test_id;

        return $question->save();
    }

    /**
     * Update question data in database
     *
     * @param $parameters
     * @param $question_id
     * @return false|int
     * @throws \Exception
     * @throws \Throwable
     */
    public static function updateInDb($parameters, $question_id)
    {
        $question = AR_QuizQuestion::findOne($question_id);
        $question->question = $parameters['question_text'];
        $question->type = $parameters['question_type'];

        $pAnswers = static::prepareAnswer($parameters);

        $question->answers = $pAnswers['answer'];
        $question->r_answers = $pAnswers['r_answer'];

        return $question->update();
    }

    /**
     * Preparing the variants and answers for database
     *
     * @param $parameters
     * @return array - ['answer' => <json_encode_variants>, 'r_answer' => <json_encode_right_answers>]
     */
    abstract public static function prepareAnswer($parameters);
}
