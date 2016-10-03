<?php

use yii\db\Schema;
use yii\db\Migration;

class m161003_120711_spending_category extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%spending_category}}',
            [
                'id'=> $this->primaryKey(11),
                'parent_id'=> $this->integer(11)->null()->defaultValue(null),
                'name'=> $this->string(255)->notNull(),
                'sort'=> $this->integer(11)->null()->defaultValue(null),
            ],$tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%spending_category}}');
    }
}
