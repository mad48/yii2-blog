<?php

use yii\db\Migration;

/**
 * Class m180327_113405_post_table_add_updated_field
 */
class m180327_113405_post_table_add_updated_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%post}}', 'active', $this->boolean()->notNull());//->defaultValue('1'));
        $this->addColumn('{{%post}}', 'updated',  $this->dateTime()->notNull());//->defaultExpression("CURRENT_TIMESTAMP"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180327_113405_post_table_add_updated_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180327_113405_post_table_add_updated_field cannot be reverted.\n";

        return false;
    }
    */
}
