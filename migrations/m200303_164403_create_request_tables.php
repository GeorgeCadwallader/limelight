<?php

/**
 * Class m200303_164403_create_request_tables
 */
class m200303_164403_create_request_tables extends \app\core\Migration
{
    
    public function tables(): array
    {
        return [
            '{{%owner_request}}' => [
                'owner_request_id' => $this->primaryKey(),
                'fk' => $this->integer()->notNull(),
                'type' => $this->integer()->notNull(),
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
                'created_by' => $this->integer(),
                'updated_by' => $this->integer(),
            ],
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
