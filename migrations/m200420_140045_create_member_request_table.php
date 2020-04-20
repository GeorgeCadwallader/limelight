<?php

/**
 * Handles the creation of table `{{%member_request}}`.
 */
class m200420_140045_create_member_request_table extends \app\core\Migration
{
    
    /**
     * The tables for the migration
     * 
     * @return array
     */
    public function tables(): array
    {
        return [
            '{{%member_request}}' => [
                'member_request_id' => $this->primaryKey(),
                'request_name' => $this->string()->notNull(),
                'type' => $this->integer()->notNull(),
                'status' => $this->integer()->notNull(),
                'request_count' => $this->integer()->defaultValue(1),
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
