<?php

use yii\db\Schema;
use yii\db\Migration;

class m161028_125109_altertable_spending_spending extends Migration
{
    public function up()
    {
    	$this->addColumn('{{%spending_spending}}','model',$this->string(255)->null()->defaultValue(null));
        $this->addColumn('{{%spending_spending}}','item_id',$this->integer(11)->null()->defaultValue(null));
    	$this->addColumn('{{%spending_spending}}','deleted', Schema::TYPE_DATETIME."");
    }

    public function down()
    {
        $this->dropColumn('{{%spending_spending}}', 'model');
        $this->dropColumn('{{%spending_spending}}', 'item_id');
        $this->dropColumn('{{%spending_spending}}', 'item_id');
    }
}
