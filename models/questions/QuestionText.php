<?php

namespace gypsyk\quiz\models\questions;

use Yii;
use yii\helpers\{Json};
use gypsyk\quiz\models\AR_QuizQuestion;

class QuestionText extends \gypsyk\quiz\models\questions\AbstractQuestion
{
    /**
     * QuestionText constructor.
     * @param AR_QuizQuestion $ar_question
     */
    public function __construct(\gypsyk\quiz\models\AR_QuizQuestion $ar_question)
    {
        $this->renderClass = self::getRenderClass(); 
        $jCorrectAnswers = Json::decode($ar_question->answers, false)[0];
        $this->correctAnswer = $jCorrectAnswers->text;
        $this->text = $ar_question->question;
        $this->jsonVariants = $ar_question->answers;
    }

    /**
     * @inheritdoc
     */
    public static function getRenderClass()
    {
        return '\gypsyk\quiz\models\renders\qtext_render\QuestionTextRender';
    }

    /**
     * Save user answer
     * 
     * @param string $session_answer
     */
    public function loadUserAnswer($session_answer)
    {
        $this->userAnswer = $session_answer;
    }

    /**
     * @inheritdoc
     */
    public function isUserAnswerIsCorrect()
    {
        if(!empty($this->userCorrect))
            return $this->userCorrect;
        
        if(trim(mb_strtolower($this->correctAnswer)) == trim(mb_strtolower($this->userAnswer))) {
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

        //Prepare the right answer
        $item['id'] = Yii::$app->security->generateRandomString(5);
        $item['text'] = Yii::$app->request->post('custom');
        $right[] = $item;
        $rightId = $item['id'];

        $question->answers = Json::encode($right);
        $question->r_answers = Json::encode($rightId);

        $question->test_id = $test_id;

        return $question->save();
    }
}
