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
        $this->questionTypeId = $ar_question->type;
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
    public static function prepareAnswer($parameters)
    {
        //Prepare the right answer
        $item['id'] = Yii::$app->security->generateRandomString(5);
        $item['text'] = $parameters['custom'];
        $right[] = $item;
        $rightId = $item['id'];

        $ret['answer'] = Json::encode($right);
        $ret['r_answer'] = Json::encode($rightId);

        return $ret;
    }
}
