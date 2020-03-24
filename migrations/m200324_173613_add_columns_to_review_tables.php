<?php

/**
 * Class m200324_173613_add_columns_to_review_tables
 */
class m200324_173613_add_columns_to_review_tables extends \app\core\Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%review_artist}}', 'energy', $this->float()->after('overall_rating'));
        $this->addColumn('{{%review_artist}}', 'vocals', $this->float()->after('energy'));
        $this->addColumn('{{%review_artist}}', 'sound', $this->float()->after('vocals'));
        $this->addColumn('{{%review_artist}}', 'stage_presence', $this->float()->after('sound'));
        $this->addColumn('{{%review_artist}}', 'song_aesthetic', $this->float()->after('stage_presence'));

        $this->addColumn('{{%review_venue}}', 'service', $this->float()->after('overall_rating'));
        $this->addColumn('{{%review_venue}}', 'location', $this->float()->after('service'));
        $this->addColumn('{{%review_venue}}', 'value', $this->float()->after('location'));
        $this->addColumn('{{%review_venue}}', 'cleanliness', $this->float()->after('value'));
        $this->addColumn('{{%review_venue}}', 'size', $this->float()->after('cleanliness'));

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%review_artist}}', 'energy');
        $this->dropColumn('{{%review_artist}}', 'vocals');
        $this->dropColumn('{{%review_artist}}', 'sound');
        $this->dropColumn('{{%review_artist}}', 'stage_presence');
        $this->dropColumn('{{%review_artist}}', 'song_aesthetic');

        $this->dropColumn('{{%review_venue}}', 'service');
        $this->dropColumn('{{%review_venue}}', 'location');
        $this->dropColumn('{{%review_venue}}', 'value');
        $this->dropColumn('{{%review_venue}}', 'cleanliness');
        $this->dropColumn('{{%review_venue}}', 'size');

        return true;
    }

}
