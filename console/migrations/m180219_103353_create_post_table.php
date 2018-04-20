<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post`.
 */
class m180219_103353_create_post_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'category_id' => $this->integer(),
            'title' => $this->string(),
            'content' => $this->text(),
            'url' => $this->string(),
            'active' => $this->boolean(),
            'date' => $this->date(),
        ], $tableOptions);
}

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%post}}');
    }
}
