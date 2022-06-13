<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%lucky_tickets}}`.
 */
class m220611_082848_create_lucky_tickets_table extends Migration
{
    public function safeUp()
    {
        $tableOptions_mysql = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";

        $this->createTable('{{%lucky_tickets}}', [
            'id' => $this->primaryKey(),
            'number_from' => $this->integer(6)->null(),
            'number_to' => $this->integer(6)->null(),
            'tickets' => $this->integer(6)->null(),
            'created' => $this->integer(11)->null(),
        ], $tableOptions_mysql);
    }

    public function safeDown()
    {
        $this->dropTable('{{%lucky_tickets}}');
    }
}
