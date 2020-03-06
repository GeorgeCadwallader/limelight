<?php

/**
 * Handles the creation of table `{{%user_vote}}`.
 */
class m200304_223813_create_user_vote_table extends \app\core\Migration
{
    
    /**
     * Creates a table in the migration
     * 
     * @return array
     */
    public function tables(): array
    {
        return [
            '{{%user_vote}}' => [
                'user_vote_id' => $this->primaryKey(),
                'review_artist_id' => $this->integer(),
                'review_venue_id' => $this->integer(),
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
