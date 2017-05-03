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

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getType0()
//    {
//        return $this->hasOne(QuizQuestionType::className(), ['id' => 'type']);
//    }
}
