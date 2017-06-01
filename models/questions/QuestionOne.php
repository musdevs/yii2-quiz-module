<?php

namespace gypsyk\quiz\models\questions;

use Yii;
use yii\helpers\{Json, ArrayHelper};
use gypsyk\quiz\models\AR_QuizQuestion;

/**
 * Class that representing the question that have only one correct answer
 * 
 * Class QuestionOne
 * @package gypsyk\quiz\models\questions
 */
class QuestionOne extends \gypsyk\quiz\models\questions\AbstractQuestion
{
    /**
     * QuestionOne constructor.
     * @param AR_QuizQuestion $ar_question
     */
    public function __construct(\gypsyk\quiz\models\AR_QuizQuestion $ar_question)
    {
        $this->renderClass = self::getRenderClass();
        $jCorrectAnswer = Json::decode($ar_question->r_answers, false);
        $this->correctAnswer = $jCorrectAnswer;
        $this->text = $ar_question->question;
        $this->jsonVariants = $ar_question->answers;
        $this->questionTypeId = $ar_question->type;
        
        foreach (Json::decode($ar_question->answers, false) as $jVariant) {
            $isCorrect = ($jCorrectAnswer == $jVariant->id) ? true : false; 
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
        return '\gypsyk\quiz\models\renders\qone_render\QuestionOneRender';
    }

    /**
     * Mark a variant as user checked and save the user answer
     * 
     * @param string $session_answer
     */
    public function loadUserAnswer($session_answer)
    {
        $this->variants[$session_answer]['is_user_checked'] = true;
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

        //Prepare the wrong answers
        foreach (Yii::$app->request->post('wrong_one') as $wrongOne) {
            $item['id'] = Yii::$app->security->generateRandomString(5);
            $item['text'] = $wrongOne;
            $wrong[] = $item;
        }

        //Prepare the right answer
        $item['id'] = Yii::$app->security->generateRandomString(5);
        $item['text'] = Yii::$app->request->post('right_one');
        $right[] = $item;
        $rightIds = $item['id'];

        $all = ArrayHelper::merge($wrong, $right);

        $question->answers = Json::encode($all);
        $question->r_answers = Json::encode($rightIds);
        $question->test_id = $test_id;
        
        return $question->save();
    }
}
