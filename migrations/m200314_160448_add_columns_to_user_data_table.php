<?php

/**
 * Handles adding columns to table `{{%user_data}}`.
 */
class m200314_160448_add_columns_to_user_data_table extends \app\core\Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user_data}}', 'profile_path', $this->string()->after('telephone'));

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user_data}}', 'profile_path');

        return true;
    }

}
