<?php

namespace gypsyk\quiz\models\questions;

use Yii;
use yii\helpers\{Json, ArrayHelper};
use gypsyk\quiz\models\AR_QuizQuestion;

/**
 * Class for representing question that have multiple correct answers
 * 
 * Class QuestionMultiple
 * @package gypsyk\quiz\models\questions
 */
class QuestionMultiple extends \gypsyk\quiz\models\questions\AbstractQuestion
{
    /**
     * QuestionMultiple constructor.
     * @param AR_QuizQuestion $ar_question
     */
    public function __construct(\gypsyk\quiz\models\AR_QuizQuestion $ar_question)
    {
        $this->renderClass = self::getRenderClass(); 
        $jcorrectAnswer = Json::decode($ar_question->r_answers, false);
        $this->correctAnswer = $jcorrectAnswer;
        $this->text = $ar_question->question;
        $this->jsonVariants = $ar_question->answers;

        foreach (Json::decode($ar_question->answers, false) as $jVariant) {
            $isCorrect = in_array($jVariant->id, $jcorrectAnswer) ? true : false;
            $this->variants[$jVariant->id] = [
                'text' => $jVariant->text,
                'is_correct' => $isCorrect,
                'is_user_checked' => false
            ];
        }
    }

    /**
     * @inheritdoc
     */
    public static function getRenderClass()
    {
        return '\gypsyk\quiz\models\renders\qmultiple_render\QuestionMultipleRender';
    }

    /**
     * Mark a variant as user checked and save the user answer
     *
     * @param array $session_answer
     */
    public function loadUserAnswer($session_answer)
    {
        foreach ($session_answer as $answer) {
            $this->variants[$answer]['is_user_checked'] = true;    
        }
        $this->userAnswer = $session_answer;
    }

    /**
     * @inheritdoc
     */
    public function isUserAnswerIsCorrect()
    {
        if(!empty($this->userCorrect))
            return $this->userCorrect;

        if($this->correctAnswer == $this->userAnswer) {
            $this->userCorrect = true;
            return true;
        }

        $this->userCorrect = false;
        return false;
    }

    /**
     * @inheritdoc
     */
    public static function saveToDb($parameters, $test_id)
    {
        $question = new AR_QuizQuestion();
        $question->question = $parameters['question_text'];
        $question->type = $parameters['question_type'];

        foreach (Yii::$app->request->post('wrong_many') as $wrongMany) {
            $item['id'] = Yii::$app->security->generateRandomString(5);
            $item['text'] = $wrongMany;
            $wrong[] = $item;
        }
        foreach (Yii::$app->request->post('right_many') as $rightMany) {
            $item['id'] = Yii::$app->security->generateRandomString(5);
            $item['text'] = $rightMany;
            $right[] = $item;
            $rightIds[] = $item['id'];
        }
        $all = ArrayHelper::merge($wrong, $right);

        $question->answers = Json::encode($all);
        $question->r_answers = Json::encode($rightIds);
        $question->test_id = $test_id;

        return $question->save();
    }
}
