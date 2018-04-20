<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m180219_105135_create_category_table extends Migration
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

        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey()->unsigned(),
            'title' => $this->string(200)->notNull(),
            'slug' => $this->string(200)->notNull()
        ], $tableOptions);

        $this->createIndex('title', '{{%category}}', ['title'], false);
        $this->createIndex('slug', '{{%category}}', ['slug'], false);
        $this->createIndex('slug_title', '{{%category}}', ['slug, title'], false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('slug', '{{%category}}');
        $this->dropIndex('title', '{{%category}}');
        $this->dropIndex('slug_title', '{{%category}}');
        $this->dropTable('{{%category}}');
    }
}
