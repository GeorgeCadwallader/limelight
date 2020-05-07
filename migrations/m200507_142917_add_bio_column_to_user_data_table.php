<?php

/**
 * Handles adding columns to table `{{%user_data}}`.
 */
class m200507_142917_add_bio_column_to_user_data_table extends \app\core\Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp(): bool
    {
        $this->addColumn('{{%user_data}}', 'bio', $this->string(2500)->after('last_name'));
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): bool
    {
        $this->dropColumn('{{%user_data}}', 'bio');
        return true;
    }

}
