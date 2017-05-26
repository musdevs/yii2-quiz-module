<?php

use yii\db\Migration;

/**
 * Handles adding description to table `quiz_test`.
 */
class m170525_085413_add_description_column_to_quiz_test_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quiz_test', 'description', $this->string(1000));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('quiz_test', 'description');
    }
}
