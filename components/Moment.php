<?php

declare(strict_types = 1);

namespace app\components;

use Yii;

use Moment\Moment as BaseMoment;
use Moment\CustomFormats\MomentJs;
use Moment\FormatsInterface;

/**
 * An extension to the moment php lib with functions for this project in it
 */
class Moment extends BaseMoment
{

    const FORMAT_MYSQL = 'YYYY-MM-DD HH:mm:s';
    const FORMAT_DATE = 'dddd Do MMMM YYYY';

    public function __construct($dateTime = 'now', $timezone = null, $immutableMode = false)
    {
        if (!$this->isMoment($dateTime) && $dateTime !== null) {
            $dateTime = Yii::$app->formatter->asDateTime($dateTime);
        }


        return parent::__construct($dateTime, $timezone, $immutableMode);
    }

    /**
     * Gets the format interface that will be used to format by default
     *
     * @return FormatsInterface
     */
    public function getFormatInterface(): FormatsInterface
    {
        return new MomentJs;
    }

    /**
     * Formats this instance of the datetime
     *
     * @param string           $format           The format to display the datetime
     * @param FormatsInterface $formatsInterface The formatter to use
     *
     * @return string
     */
    public function format($format = null, $formatsInterface = null): string
    {
        if ($formatsInterface === null) {
            $formatsInterface = $this->getFormatInterface();
        }

        return parent::format($format, $formatsInterface);
    }

    /**
     * Calculates if the weekday if monday to friday
     *
     * @return bool
     */
    public function isWeekday(): bool
    {
        return (int)$this->format('e') < 4;
    }

    /**
     * Creates a new date object with an timestamp of 0
     *
     * @return self
     */
    public static function createNull(): Moment
    {
        return (new self)->setTimestamp(0);
    }

    /**
     * Tests to see if a date is null
     *
     * @return bool
     */
    public function isNull(): bool
    {
        return $this->getTimestamp() === 0;
    }

    /**
     * Formats the date into the default date format
     *
     * @return string
     */
    public function asDate(): string
    {
        return $this->format(self::FORMAT_DATE);
    }

    /**
     * Converts the date into relative words
     *
     * @return string
     */
    public function asWords(): string
    {
        return Yii::$app->formatter->asRelativeTime($this);
    }

    /**
     * Method to implement stringable
     *
     * @return string
     */
    public function __toString(): string
    {
        if ($this->isNull()) {
            return '';
        }

        return $this->format(self::FORMAT_MYSQL);
    }

    public function serialize()
    {
        return $this->getTimestamp();
    }

    public function unserialize($timestamp)
    {
        $this->setTimestamp((int)$timestamp);
    }

}
