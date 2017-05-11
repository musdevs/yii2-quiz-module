<?php

use yii\db\Migration;

//TO DO: MAKE AN TABLE MIGRATIONS
/**
 * Handles the creation of table `quiz_question_type`.
 */
class m170511_030242_create_quiz_question_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('quiz_question_type', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('quiz_question_type');
    }
}
