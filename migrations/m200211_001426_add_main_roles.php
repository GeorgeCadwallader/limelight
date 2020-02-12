<?php

use app\auth\Item;

/**
 * Class m200211_001426_add_main_roles
 */
class m200211_001426_add_main_roles extends \app\core\Migration
{

    public function roles(): array
    {
        return [
            [
                'table' => $this->authManager->itemTable,
                'data' => [
                    'name' => Item::ROLE_ADMIN,
                    'type' => Item::TYPE_ROLE,
                    'description' => 'Can do all the things',
                    'created_at' => '1581380447',
                    'updated_at' => '1581380447',
                ]
            ],
            [
                'table' => $this->authManager->itemTable,
                'data' => [
                    'name' => Item::ROLE_MEMBER,
                    'type' => Item::TYPE_ROLE,
                    'description' => 'Normal user',
                    'created_at' => '1581380447',
                    'updated_at' => '1581380447',
                ]
            ],
            [
                'table' => $this->authManager->itemTable,
                'data' => [
                    'name' => Item::ROLE_ARTIST_OWNER,
                    'type' => Item::TYPE_ROLE,
                    'description' => 'Owner of a artist page',
                    'created_at' => '1581380447',
                    'updated_at' => '1581380447',
                ]
            ],
            [
                'table' => $this->authManager->itemTable,
                'data' => [
                    'name' => Item::ROLE_VENUE_OWNER,
                    'type' => Item::TYPE_ROLE,
                    'description' => 'Owner of a venue page',
                    'created_at' => '1581380447',
                    'updated_at' => '1581380447',
                ]
            ]
        ];
    }

    public function roleChild(): array
    {
        return [
            [
                'child' => Item::ROLE_MEMBER,
                'parent' => Item::ROLE_ADMIN,
            ],
            [
                'child' => Item::ROLE_ARTIST_OWNER,
                'parent' => Item::ROLE_ADMIN
            ],
            [
                'child' => Item::ROLE_VENUE_OWNER,
                'parent' => Item::ROLE_ADMIN
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp(): bool
    {
        foreach ($this->roles() as $item) {
            $this->insert($item['table'], $item['data']);
        }

        foreach ($this->roleChild() as $item) {
            $this->insert(
                $this->authManager->itemChildTable,
                $item
            );
        }
        
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        foreach ($this->roles() as $item) {
            $this->delete($item['table'], $item['data']);
        }

        foreach ($this->roleChild() as $item) {
            $this->delete(
                $this->authManager->itemChildTable,
                $item
            );
        }

        return true;
    }

}
