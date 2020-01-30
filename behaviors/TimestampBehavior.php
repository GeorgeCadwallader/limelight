<?php

declare(strict_types = 1);

namespace app\behaviors;

use app\components\Moment;

use Yii;
use yii\db\ActiveRecord;
use yii\base\ModelEvent;

/**
 * @category  Project
 * @package   {{package}}
 * @author    Ade Attwood <ade@practically.io>
 * @copyright 2018 Practically.io
 */
class TimestampBehavior extends \yii\base\Behavior
{

    /**
     * @var string the attribute that will receive timestamp value
     * Set this property to false if you do not want to record the creation time.
     */
    public $createdAtAttribute = 'created_at';

    /**
     * @var string the attribute that will receive timestamp value.
     * Set this property to false if you do not want to record the update time.
     */
    public $updatedAtAttribute = 'updated_at';

    /**
     * @var boolean
     */
    public $encodeBeforeValidation = true;

    /**
     * @return array
     */
    public function events(): array
    {
        return [
            ActiveRecord::EVENT_INIT => function () {
                $this->initialization();
            },
            ActiveRecord::EVENT_AFTER_FIND => function () {
                $this->decode();
            },
            ActiveRecord::EVENT_BEFORE_INSERT => function ($event) {
                $this->encode($event);
            },
            ActiveRecord::EVENT_BEFORE_UPDATE => function ($event) {
                $this->encode($event);
            },
            ActiveRecord::EVENT_AFTER_INSERT => function () {
                $this->decode();
            },
            ActiveRecord::EVENT_AFTER_UPDATE => function () {
                $this->decode();
            },
            ActiveRecord::EVENT_BEFORE_VALIDATE => function ($event) {
                if ($this->encodeBeforeValidation) {
                    $this->encode($event);
                }
            },
            ActiveRecord::EVENT_AFTER_VALIDATE  => function () {
                if ($this->encodeBeforeValidation) {
                    $this->decode();
                }
            },
        ];
    }

    /**
     * Sets the date time attributes to now on init
     *
     * @return void
     */
    protected function initialization(): void
    {
        $this->touch($this->createdAtAttribute);
        $this->touch($this->updatedAtAttribute);
    }

    /**
     * Encodes the moment values into string for inserting into the database
     *
     * @param ModelEvent $event
     *
     * @return void
     */
    public function encode(ModelEvent $event): void
    {
        if ($event->name === ActiveRecord::EVENT_BEFORE_UPDATE) {
            $this->touch($this->updatedAtAttribute);
        }

        $this->encodeAttribute($this->createdAtAttribute);
        $this->encodeAttribute($this->updatedAtAttribute);
    }

    /**
     * Converts a moment object into a string
     *
     * @param string $attribute
     *
     * @return void
     */
    protected function encodeAttribute($attribute): void
    {
        $owner = $this->owner;

        if (!$owner->hasProperty($attribute)) {
            return;
        }

        $moment = $owner->getAttribute($attribute);
        if (!($moment instanceof Moment)) {
            $moment = Moment::createNull();
        }

        $owner->setAttribute($attribute, $moment->format(Moment::FORMAT_MYSQL));
    }

    /**
     * Decodes the values from the database into Moment objects
     *
     * @return void
     */
    protected function decode(): void
    {
        $this->decodeAttribute($this->createdAtAttribute);
        $this->decodeAttribute($this->updatedAtAttribute);
    }

    /**
     * Converts a string into a Moment object
     *
     * @param string $attribute
     *
     * @return void
     */
    protected function decodeAttribute($attribute): void
    {
        $owner = $this->owner;

        if (!$owner->hasProperty($attribute)) {
            return;
        }

        $timestamp = Yii::$app->formatter->asTimestamp($owner->getAttribute($attribute));

        $moment = new Moment();
        $moment->setTimestamp((int)$timestamp);
        $owner->setAttribute($attribute, $moment);
    }

    /**
     * Sets a attribute to a new Moment object with the time of now
     *
     * @param string $attribute
     *
     * @return void
     */
    public function touch($attribute): void
    {
        if ($this->owner->hasProperty($attribute)) {
            $this->owner->setAttribute($attribute, new Moment);
        }
    }

}
