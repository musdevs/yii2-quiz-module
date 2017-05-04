<?php

namespace gypsyk\quiz\models;

use Yii;

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
//    public function getType0()
//    {
//        return $this->hasOne(QuizQuestionType::className(), ['id' => 'type']);
//    }
}
