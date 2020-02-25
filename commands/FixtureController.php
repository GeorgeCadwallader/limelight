<?php

declare(strict_types = 1);

namespace app\commands;

use Yii;
use yii\console\ExitCode;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;

/**
 * Add-on fixture functions
 *
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020
 */
class FixtureController extends \yii\faker\FixtureController
{

    /**
     * @var string Alias to the template path, where all tables templates are stored.
     */
    public $templatePath = '@tests/fixtures/templates';

    /**
     * @var string Alias to the fixture data path, where data files should be written.
     */
    public $fixtureDataPath = '@tests/fixtures/data';

    /**
     * @var string default namespace to search fixtures in
     */
    public $namespace = 'app\tests\fixtures';

    public $counter = 0;

    /**
     * @var array
     */
    private $_roles;

    /**
     * @var array
     */
    public $config = [
        'user' => 50,
        'auth_assignment' => 50,
    ];

    /**
     * Generates the fixtures from the above config
     *
     * @return void
     */
    public function actionGenerateFromConfig(): void
    {
        $this->interactive = false;
        foreach ($this->config as $template => $count) {
            $this->count = $count;
            $this->counter = 0;
            $this->actionGenerate($template);
        }
    }

    /**
     * Gets all of the defined roles
     *
     * @return array
     */
    public function getRoles(): array
    {
        if ($this->_roles === null) {
            $this->_roles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name');
        }

        return $this->_roles;
    }

    /**
     * Generates all of the test fixtures and data from all of the database
     * tables
     *
     * @return integer
     */
    public function actionGenerateFromDb(): int
    {
        $db = Yii::$app->db;
        $dataFolder = Yii::getAlias('@app/tests/fixtures/data');
        $fixtureFolder = Yii::getAlias('@app/tests/fixtures');

        foreach ($db->schema->tableNames as $table) {
            $tableClassName = Inflector::camelize($table);
            $quotedTable = '{{%'.str_replace(Yii::$app->db->tablePrefix, '', $table).'}}';
            $rows = VarDumper::export((new Query)->select(['*'])->from($table)->all());
            $output = "<?php\n\nreturn {$rows};\n";
            $depends = [];

            file_put_contents("$dataFolder/$table.php", $output);
            foreach ($db->getTableSchema($table, true)->foreignKeys as $key => $data) {
                if ($data[0] !== $table) {
                    $depends[] = '        '.Inflector::camelize($data[0]).'Fixture::class,';
                }
            }

            if (count($depends) > 0) {
                $depends = "\n".implode("\n", array_unique($depends))."\n    ";
            } else {
                $depends = '';
            }

            file_put_contents("$fixtureFolder/{$tableClassName}Fixture.php", <<<PHP
<?php

declare(strict_types = 1);

namespace app\\tests\\fixtures;

/**
 * @category  Project
 * @package   {{package}}
 * @author    George Cadwallader <georgecadwallader77@gmail.com>
 * @copyright 2020
 */
class {$tableClassName}Fixture extends \\yii\\test\\ActiveFixture
{

    /**
     * The table for the fixture
     *
     * @var string
     */
    public \$tableName = '$quotedTable';

    /**
     * The fixtures that this fixture depends on. This must be a list of the
     * dependent fixture class names
     *
     * @var array .
     */
    public \$depends = [$depends];

}

PHP
);
        }

        return ExitCode::OK;
    }

}
