<?php

/**
 * Handles adding columns to table `{{%venue_data}}`.
 */
class m200424_141247_add_column_to_venue_data_table extends \app\core\Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%venue_data}}', 'county_id', $this->integer()->after('description'));
        
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%venue_data}}', 'county_id');

        return true;
    }

}
