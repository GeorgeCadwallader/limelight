<?php

/**
 * Handles the creation of table `{{%user_badge}}`.
 */
class m200322_170843_create_user_badge_table extends \app\core\Migration
{

    /**
     * The tables for the migration
     * 
     * @return array
     */
    public function tables(): array
    {
        return [
            '{{%user_badge}}' => [
                'user_badge_id' => $this->primaryKey(),
                'user_id' => $this->integer()->notNull(),
                'type' => $this->integer()->notNull(),
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
                'created_by' => $this->integer(),
                'updated_by' => $this->integer(),
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp(): bool
    {
        $this->foreachTable($this->tables(), function ($tableName, $fields) {
            $this->createTable($tableName, $fields);
        });

        $this->addForeignKeys($this->tables());

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): bool
    {
        $this->dropForeignKeys($this->tables());

        $this->foreachTable($this->tables(), function ($tableName) {
            $this->dropTable($tableName);
        });

        return true;
    }

}
