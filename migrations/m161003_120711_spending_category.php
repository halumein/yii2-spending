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

        $this->insert('{{%spending_category}}', [
            'id' => '1',
            'parent_id' => NULL,
            'name' => 'Офисные',
            'sort' => NULL,
        ]);

        $this->insert('{{%spending_category}}', [
            'id' => '2',
            'parent_id' => NULL,
            'name' => 'Зарплаты',
            'sort' => NULL,
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%spending_category}}');
    }
}
