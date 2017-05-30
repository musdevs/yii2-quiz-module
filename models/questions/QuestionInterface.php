<?php

namespace gypsyk\quiz\models\questions;

/**
 * Interface that question object must implement
 * 
 * Interface QuestionInterface
 * @package gypsyk\quiz\models\questions
 */
interface QuestionInterface
{
    /**
     * Return the question render class name
     *
     * @return mixed
     */
    public static function getRenderClass();

    /**
     * Save the user answer info
     *
     * @param $session_answer
     */
    public function loadUserAnswer($session_answer);

    /**
     * Check if user answer is correct
     *
     * @return bool|null
     */
    public function isUserAnswerIsCorrect();

    /**
     * Save question info to database
     *
     * @param $parameters
     * @param $test_id
     * @return bool
     */
    public static function saveToDb($parameters, $test_id);
}
