<?php

use yii\db\Migration;

/**
 * Class m180313_142129_alter_column_date_to_datetime_in_post_table
 */
class m180313_142129_alter_column_date_to_datetime_in_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%post}}', 'date', $this->dateTime()->notNull());//->defaultExpression('CURRENT_TIMESTAMP'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180313_142129_alter_column_date_to_datetime_in_post_table cannot be reverted.\n";
        echo "time in column date will be lost.\n";
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180313_142129_alter_column_date_to_datetime_in_post_table cannot be reverted.\n";

        return false;
    }
    */
}
