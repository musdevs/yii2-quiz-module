<?php

namespace gypsyk\quiz\models;

use Yii;
use gypsyk\quiz\models\AR_QuizQuestionType;

/**
 * This is the model class for table "quiz_question".
 *
 * @property integer $id
 * @property integer $type
 * @property string $question
 * @property string $answers
 * @property string $r_answers
 * @property string $test_id
 * 
 *
 * @property QuizQuestionType $type0
 */
class AR_QuizQuestion extends \yii\db\ActiveRecord
{
    const TYPE_ONE = 'ONE';
    const TYPE_MULTIPLE = 'MULTIPLE';
    const TYPE_TEXT = 'TEXT';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'question', 'r_answers', 'test_id'], 'required'],
            [['type', 'test_id'], 'integer'],
            [['question', 'answers', 'r_answers'], 'string'],
        ];
    }
    
    public static function getTestQuestions($test_id)
    {
        return static::findAll(['test_id' => $test_id]);
    }

    /**
     * Перемешивает вопросы теста.
     * Возвращает массив вида [1 => 43, 2 => 46, ... {counter} => {db_id}]
     *
     * @param $test_id
     * @return array
     */
    public static function getShuffledQuestionArray($test_id)
    {
        $questionList = static::findAll(['test_id' => $test_id]);
        shuffle($questionList);

        //Make a normal question order to hide real ids
        $i = 1;
        $tempList = [];
        foreach ($questionList as $question) {
            $tempList[$i] = $question->getPrimaryKey();
            $i++;
        }
        
        return $tempList;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType_q()
    {
        return $this->hasOne(AR_QuizQuestionType::className(), ['id' => 'type']);
    }

    /**
     * Get question type code
     *
     * @return mixed
     */
    public function getTypeCode()
    {
        return $this->type_q->code;
    }

    /**
     * Count the questions in test
     * 
     * @param $test_id
     * @return int
     */
    public static function count($test_id)
    {
        return count(static::findAll(['test_id' => $test_id]));
    }
}
