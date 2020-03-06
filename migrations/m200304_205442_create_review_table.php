<?php

/**
 * Handles the creation of table `{{%review}}`.
 */
class m200304_205442_create_review_table extends \app\core\Migration
{
    
    /**
     * Creates a table in the migration
     * 
     * @return array
     */
    public function tables(): array
    {
        return [
            '{{%review_artist}}' => [
                'review_artist_id' => $this->primaryKey(),
                'artist_id' => $this->integer()->notNull(),
                'content' => $this->string(),
                'overall_rating' => $this->float(),
                'upvotes' => $this->integer()->defaultValue(0),
                'downvotes' => $this->integer()->defaultValue(0),
                'status' => $this->integer()->notNull(),
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime(),
                'created_by' => $this->integer(),
                'updated_by' => $this->integer(),
            ],
            '{{%review_venue}}' => [
                'review_venue_id' => $this->primaryKey(),
                'venue_id' => $this->integer()->notNull(),
                'content' => $this->string(),
                'overall_rating' => $this->float(),
                'upvotes' => $this->integer()->defaultValue(0),
                'downvotes' => $this->integer()->defaultValue(0),
                'status' => $this->integer()->notNull(),
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
