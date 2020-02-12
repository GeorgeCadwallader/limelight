<?php

/**
 * Class m200212_192903_add_band_venue_tables
 */
class m200212_192903_add_band_venue_tables extends \app\core\Migration
{

    public function tables(): array
    {
        return [
            '{{%artist}}' => [
                'artist_id' => $this->primaryKey(),
                'name' => $this->string(),
                'managed_by' => $this->integer(),
                'status' => $this->integer()->defaultValue(1),
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
                'created_by' => $this->integer(),
                'updated_by' => $this->integer(),
            ],
            '{{%venue}}' => [
                'venue_id' => $this->primaryKey(),
                'name' => $this->string(),
                'managed_by' => $this->integer(),
                'status' => $this->integer()->defaultValue(1),
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
