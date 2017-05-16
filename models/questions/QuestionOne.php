<?php

namespace gypsyk\quiz\models\questions;

use Yii;
use yii\helpers\Json;
use gypsyk\quiz\models\questions\AbstractQuestion;
use gypsyk\quiz\models\AR_QuizQuestion;
use yii\helpers\ArrayHelper;

class QuestionOne extends AbstractQuestion
{
    public $variants;
    
    public function __construct(\gypsyk\quiz\models\AR_QuizQuestion $ar_question)
    {
        $this->renderClass = '\gypsyk\quiz\models\renders\qone_render\QuestionOneRender';
        $jCorrectAnswer = Json::decode($ar_question->r_answers, false);
        $this->correctAnswer = $jCorrectAnswer;
        $this->text = $ar_question->question;
        $this->jsonVariants = $ar_question->answers;
        
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
     * Пометить сделанный пользователем ответ
     * 
     * @param string $session_answer
     */
    public function loadUserAnswer(string $session_answer)
    {
        $this->variants[$session_answer]['is_user_checked'] = true;
        $this->userAnswer = $session_answer;
    }

    /**
     * Проверка правльности ответа на вопрос
     *
     * @return bool
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