<?php

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m200321_010950_add_email_new_column_to_user_table extends \app\core\Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'email_new', $this->string()->after('email'));

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'email_new');

        return true;
    }

}
