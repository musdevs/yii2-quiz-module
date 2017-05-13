<?php

use yii\db\Migration;

class m170513_022427_create_quiz_test extends Migration
{
    public function up()
    {
        $this->createTable('quiz_test', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Test title'),
        ]);

        $this->addCommentOnTable('quiz_test', 'List of tests');
    }

    public function down()
    {
        $this->dropTable('quiz_test');
    }
}
