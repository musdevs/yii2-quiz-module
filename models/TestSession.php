<?php

namespace gypsyk\quiz\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class TestSession for keeping the current user answers and other current test session data
 * @package gypsyk\quiz\models
 */
class TestSession
{
    private $session;

    //Current question number from question page
    private $qSessionNumber;
    
    public function __construct($current_question_session_number = null)
    {
        $this->session = Yii::$app->session;

        if(!$this->session->isActive)
            $this->session->open();

        if(!empty($current_question_session_number))
            $this->qSessionNumber = $current_question_session_number;
    }

    /**
     * Return value of session variable
     *
     * @param $var_name
     * @return mixed
     */
    public function getVar($var_name)
    {
        return $this->session[$var_name]; 
    }

    /**
     * Get database question number
     *
     * @param $q_number
     * @return mixed
     */
    public function getRealQuestionNumber($q_number)
    {
        return $this->session['questionIds'][$q_number];
    }

    /**
     * Check of test is over (User pressed end button)
     *
     * @return bool
     */
    public function checkTestIsOver()
    {
        if(!empty($this->session['isResults'])) {
            if($this->session['isResults'])
                return true;
        }

        return false;
    }

    /**
     * Save user answer to session
     * 
     * @param $post_answer
     */
    public function saveUserAnswer($post_answer)
    {
        //If the answer has already been given
        if(array_key_exists($this->qSessionNumber, $this->session['answers'])) {
            $answersTemp = $this->session['answers'];
            $answersTemp[$this->qSessionNumber] = $post_answer;
            $this->session['answers'] = $answersTemp;
        } else {
            $this->session['answers'] = ArrayHelper::merge(
                $this->session['answers'],
                [$this->qSessionNumber => $post_answer]
            );
        }
    }

    /**
     * Get max question number in question list
     * 
     * @return mixed
     */
    public function getMaxTestQuestionNumber()
    {
        return max(array_keys($this->session['questionIds']));
    }

    /**
     * Prepare session array for new test
     * 
     * @param $test_id
     * @param $question_map
     */
    public function prepareForNewTest($test_id, $question_map)
    {
        $this->session->remove('currentTestId');
        $this->session->remove('questionIds');
        $this->session->remove('answers');
        $this->session->remove('isResults');

        $this->session['currentTestId'] = $test_id;
        $this->session['questionIds'] = $question_map;
        $this->session['answers'] = [];
    }

    /**
     * Mark test as over
     */
    public function markTestAsOver()
    {
        $this->session['isResults'] = true;
    }
}