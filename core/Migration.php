<?php

declare(strict_types = 1);

namespace app\core;

use yii\rbac\DbManager;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\StringHelper;

/**
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020
 */
class Migration extends \yii\db\Migration
{

    /**
     * @return bool
     */
    public function isMSSQL(): bool
    {
        return $this->db->driverName === 'mssql' || $this->db->driverName === 'sqlsrv' || $this->db->driverName === 'dblib';
    }

    /**
     * @throws yii\base\InvalidConfigException
     * @return DbManager
     */
    protected function getAuthManager(): DbManager
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }
        return $authManager;
    }

    /**
     * Creates the data array for inserting a auth rule into the database
     *
     * @param string  $ruleClass
     * @param integer $created
     *
     * @return array
     */
    public function createRule(string $ruleClass, int $created): array
    {
        $rule = Yii::createObject($ruleClass);

        return [
            'name' => $rule->name,
            'data' => serialize($rule),
            'created_at' => $created,
            'updated_at' => $created,
        ];
    }

    public function createForeignKeyName(string $table, string $field, string $targetTable): string
    {
        $baseName = "{$table}_{$field}_{$targetTable}";

        if (strlen('fk_'.$baseName) < 64) {
            return 'fk_'.$baseName;
        }

        return 'fk_'.substr(md5($baseName), 0, 60);
    }

    /**
     * Adds a foreign keys biased on naming conventions
     *
     * A key will be added to the users table for fields ending `_by`
     * eg `created_by`
     *
     * A key will be added to a table if the field name ends in `_id` the table
     * name will be the string before the `_id` eg: `user_id` is a key to the
     * `user` table `user_id`
     *
     * @param array $tableArray
     *
     * @return boolean
     */
    public function addForeignKeys(array $tableArray): bool
    {
        $this->foreachTableFiled($tableArray, function ($tableName, $fieldName) {
            $name = str_replace(['{{%', '}}'], '', $tableName);
            if (StringHelper::endsWith($fieldName, '_by')) {
                $this->addForeignKey(
                    $this->createForeignKeyName($name, $fieldName, 'user'),
                    $tableName,
                    $fieldName,
                    '{{%user}}',
                    'user_id'
                );
            }

            if (StringHelper::endsWith($fieldName, '_id')) {
                $targetTable = str_replace('_id', '', $fieldName);
                if ($name === $targetTable) {
                    return;
                }

                if ($targetTable === 'parent') {
                    $this->addForeignKey(
                        $this->createForeignKeyName($name, $name, $fieldName),
                        $tableName,
                        $fieldName,
                        $tableName,
                        $name.'_id'
                    );
                } else {
                    $this->addForeignKey(
                        $this->createForeignKeyName($name, $targetTable, $fieldName),
                        $tableName,
                        $fieldName,
                        $targetTable,
                        $fieldName
                    );
                }
            }
        });

        return true;
    }

    /**
     * Removes keys added by `Migration::addUserForeignKeys`
     *
     * @param array $tableArray
     *
     * @return boolean
     */
    public function dropForeignKeys(array $tableArray): bool
    {
        $this->foreachTableFiled($tableArray, function ($tableName, $fieldName) {
            $name = str_replace(['{{%', '}}'], '', $tableName);
            if (StringHelper::endsWith($fieldName, '_by')) {
                $this->dropForeignKey("fk_{$name}_{$fieldName}_user", $tableName);
            }

            if (StringHelper::endsWith($fieldName, '_id')) {
                $targetTable = str_replace('_id', '', $fieldName);
                if ($name === $targetTable) {
                    return;
                }

                $this->dropForeignKey("fk_{$name}_{$targetTable}_{$fieldName}", $tableName);
            }
        });

        return true;
    }

    /**
     * Runs a callback on each table field in a table array
     *
     * @param array   $tableArray
     * @param Closure $callback
     *
     * @return void
     */
    public function foreachTableFiled($tableArray, $callback): void
    {
        foreach ($tableArray as $tableName => $fields) {
            foreach ($fields as $fieldName => $type) {
                $callback($tableName, $fieldName, $type);
            }
        }
    }

    /**
     * Runs a callback foreach table
     *
     * @param array   $tableArray
     * @param Closure $callback
     *
     * @return void
     */
    public function foreachTable($tableArray, $callback): void
    {
        foreach ($tableArray as $tableName => $fields) {
            $callback($tableName, $fields);
        }
    }

}
