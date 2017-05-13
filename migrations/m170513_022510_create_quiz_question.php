<?php

use yii\db\Migration;

class m170513_022510_create_quiz_question extends Migration
{
    public function up()
    {
        $this->createTable('quiz_question', [
            'id' => $this->primaryKey(),
            'test_id' => $this->integer()->notNull()->comment('Test id'),
            'type' => $this->integer()->notNull()->comment('Question type'),
            'question' => $this->text()->notNull()->comment('Question text'),
            'answers' => 'JSON' . ' DEFAULT NULL COMMENT "Variants of answers"',
            'r_answers' => 'JSON' . ' NOT NULL COMMENT "Right answer(-s)"'
        ]);

        $this->addCommentOnTable('quiz_question', 'List of tests questions');

        //Foreign key for test table
        $this->createIndex('idx-quiz_question-test_id', 'quiz_question', 'test_id');
        $this->addForeignKey('fk-quiz_question-test_id', 'quiz_question', 'test_id', 'quiz_test', 'id', 'CASCADE', 'CASCADE');

        //Foreign key for question-type table
        $this->createIndex('idx-quiz_question-type', 'quiz_question', 'type');
        $this->addForeignKey('fk-quiz_question-type', 'quiz_question', 'type', 'quiz_question_type', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk-quiz_question-test_id', 'quiz_question');
        $this->dropIndex('idx-quiz_question-test_id', 'quiz_question');

        $this->dropForeignKey('fk-quiz_question-type', 'quiz_question');
        $this->dropIndex('idx-quiz_question-type', 'quiz_question');

        $this->dropTable('quiz_question');
    }
}
