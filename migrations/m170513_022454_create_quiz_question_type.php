<?php

use yii\db\Migration;

class m170513_022454_create_quiz_question_type extends Migration
{
    public function up()
    {
        $this->createTable('quiz_question_type', [
            'id' => $this->primaryKey(),
            'description' => $this->string()->notNull()->comment('Type description'),
            'code' => $this->string()->notNull()->comment('Code for type identification')
        ]);

        $this->addCommentOnTable('quiz_question_type', 'Types of questions');

        $this->insert('quiz_question_type', ['description' => 'One correct answer', 'code' => 'ONE']);
        $this->insert('quiz_question_type', ['description' => 'Multiple correct answers', 'code' => 'MULTIPLE']);
        $this->insert('quiz_question_type', ['description' => 'Text answer', 'code' => 'TEXT']);
    }

    public function down()
    {
        $this->dropTable('quiz_question_type');
    }
}
