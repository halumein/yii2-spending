<?php

use yii\db\Schema;
use yii\db\Migration;

class m161003_125211_spending_spending extends Migration
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
            '{{%spending_spending}}',
            [
                'id'=> $this->primaryKey(11),
                'date'=> $this->datetime()->notNull(),
                'category_id'=> $this->integer(11)->notNull(),
                'name'=> $this->string(255)->notNull(),
                'amount'=> $this->decimal(10, 3)->notNull(),
                'cost'=> $this->decimal(19, 2)->notNull(),
                'cashbox_id'=> $this->integer(11)->notNull(),
                'user_id'=> $this->integer(11)->notNull(),
                'comment'=> $this->text()->null()->defaultValue(null),
            ],$tableOptions
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%spending_spending}}');
    }
}
