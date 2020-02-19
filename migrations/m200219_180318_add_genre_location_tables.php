<?php

/**
 * Class m200219_180318_add_genre_location_tables
 */
class m200219_180318_add_genre_location_tables extends \app\core\Migration
{

    public function tables(): array
    {
        return [
            '{{%region}}' => [
                'region_id' => $this->primaryKey(),
                'name' => $this->string()->notNull(),
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
                'created_by' => $this->integer(),
                'updated_by' => $this->integer(),
            ],
            '{{%county}}' => [
                'county_id' => $this->primaryKey(),
                'name' => $this->string()->notNull(),
                'region_id' => $this->integer()->notNull(),
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
                'created_by' => $this->integer(),
                'updated_by' => $this->integer(),
            ],
            '{{%genre}}' => [
                'genre_id' => $this->primaryKey(),
                'name' => $this->string()->notNull(),
                'parent_id' => $this->integer(),
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
                'created_by' => $this->integer(),
                'updated_by' => $this->integer(),
            ],
            '{{%user_data}}' => [
                'user_data_id' => $this->primaryKey(),
                'user_id' => $this->integer()->notNull(),
                'first_name' => $this->string(),
                'last_name' => $this->string(),
                'date_of_birth' => $this->date(),
                'telephone' => $this->string(),
                'county_id' => $this->integer(),
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
                'created_by' => $this->integer(),
                'updated_by' => $this->integer(),
            ],
            '{{%user_genre}}' => [
                'user_genre_id' => $this->primaryKey(),
                'user_id' => $this->integer()->notNull(),
                'genre_id' => $this->integer()->notNull(),
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
