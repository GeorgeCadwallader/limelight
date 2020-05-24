<?php

/**
 * Handles the creation of table `{{%advert}}`.
 */
class m200523_131547_create_advert_table extends \app\core\Migration
{
    
    /**
     * The tables for the migration
     * 
     * @return array
     */
    public function tables(): array
    {
        return [
            '{{%advert}}' => [
                'advert_id' => $this->primaryKey(),
                'fk' => $this->integer()->notNull(),
                'type' => $this->integer()->notNull(),
                'message' => $this->string(1200),
                'appearances' => $this->integer()->defaultValue(0),
                'advert_type' => $this->integer()->notNull(),
                'region_id' => $this->integer(),
                'genre_id' => $this->integer(),
                'status' => $this->integer()->notNull(),
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
