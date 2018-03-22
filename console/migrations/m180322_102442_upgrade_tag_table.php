<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m180322_102442_upgrade_tag_table extends Migration
{
    public function safeUp()
    {

        // drops foreign key for table `post`
        $this->dropForeignKey(
            'fk-post_tag-post_id',
            'post_tag'
        );

        // drops foreign key for table `tag`
        $this->dropForeignKey(
            'fk-post_tag-tag_id',
            'post_tag'
        );

        // to BIGINT
        $this->alterColumn('{{%post}}', 'id', $this->integer(11)->notNull());
        $this->dropPrimaryKey('id', '{{%post}}');
        $this->alterColumn('{{%post}}', 'id', $this->bigPrimaryKey()->unsigned());

        $this->alterColumn('{{%post_tag}}', 'id', $this->integer(11)->notNull());
        $this->dropPrimaryKey('id', '{{%post_tag}}');
        $this->alterColumn('{{%post_tag}}', 'id', $this->bigPrimaryKey()->unsigned());

        $this->alterColumn('{{%post_tag}}', 'post_id', $this->bigInteger()->unsigned());
        $this->alterColumn('{{%post_tag}}', 'tag_id', $this->bigInteger()->unsigned());


        $this->alterColumn('{{%tag}}', 'id', $this->integer(11)->notNull());
        $this->dropPrimaryKey('id', '{{%tag}}');
        $this->alterColumn('{{%tag}}', 'id', $this->bigPrimaryKey()->unsigned());
        $this->alterColumn('{{%tag}}', 'title', $this->string(200)->notNull()->defaultValue(''));
        $this->addColumn('{{%tag}}', 'slug', $this->string(200)->notNull()->defaultValue(''));

        $this->createIndex('title', '{{%tag}}', ['title'], false);
        $this->createIndex('slug', '{{%tag}}', ['slug'], false);

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-post_tag-post_id',
            'post_tag',
            'post_id',
            'post',
            'id',
            'CASCADE'
        );

        // add foreign key for table `tag`
        $this->addForeignKey(
            'fk-post_tag-tag_id',
            'post_tag',
            'tag_id',
            'tag',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropIndex('title', '{{%tag}}');
        $this->dropIndex('slug', '{{%tag}}');
        $this->dropColumn('{{%tag}}', 'slug');

        return true;
    }
}
