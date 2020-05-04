<?php

/**
 * Handles the creation of table `{{%contact}}`
 */
class m200504_120304_create_contact_table extends \app\core\Migration
{
    
    /**
     * The tables for the migration
     * 
     * @return array
     */
    public function tables(): array
    {
        return [
            '{{%contact}}' => [
                'contact_id' => $this->primaryKey(),
                'first_name' => $this->string()->notNull(),
                'last_name' => $this->string()->notNull(),
                'email' => $this->string()->notNull(),
                'message' => $this->string(2400)->notNull(),
                'status' => $this->integer()->notNull(),
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
            ],
            '{{%contact_reply}}' => [
                'contact_reply_id' => $this->primaryKey(),
                'contact_id' => $this->integer()->notNull(),
                'message' => $this->string(2400)->notNull(),
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
