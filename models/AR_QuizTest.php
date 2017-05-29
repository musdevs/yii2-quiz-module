<?php

namespace gypsyk\quiz\models;

/**
 * This is the model class for table "quiz_test".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 *
 */
class AR_QuizTest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_test';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => \gypsyk\quiz\Module::t('app', 'Test name'),
            'description' => \gypsyk\quiz\Module::t('app', 'Description')
        ];

    }
}
