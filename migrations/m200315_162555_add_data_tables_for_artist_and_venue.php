<?php

/**
 * Class m200315_162555_add_data_tables_for_artist_and_venue
 */
class m200315_162555_add_data_tables_for_artist_and_venue extends \app\core\Migration
{

    /**
     * The tables for the migration
     * 
     * @return array
     */
    public function tables(): array
    {
        return [
            '{{%artist_data}}' => [
                'artist_data_id' => $this->primaryKey(),
                'artist_id' => $this->integer(),
                'profile_path' => $this->string(),
                'description' => $this->string(),
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
                'created_by' => $this->integer(),
                'updated_by' => $this->integer(),
            ],
            '{{%venue_data}}' => [
                'venue_data_id' => $this->primaryKey(),
                'venue_id' => $this->integer(),
                'profile_path' => $this->string(),
                'description' => $this->string(),
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
                'created_by' => $this->integer(),
                'updated_by' => $this->integer(),
            ],
            '{{%artist_genre}}' => [
                'artist_genre_id' => $this->primaryKey(),
                'genre_id' => $this->integer(),
                'artist_id' => $this->integer(),
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
                'created_by' => $this->integer(),
                'updated_by' => $this->integer(),
            ],
            '{{%venue_genre}}' => [
                'venue_genre_id' => $this->primaryKey(),
                'genre_id' => $this->integer(),
                'venue_id' => $this->integer(),
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
