<?php
declare(strict_types=1);

namespace Rarus\BonusServer\Util;

use Rarus\BonusServer\Exceptions\ApiClientException;

/**
 * Class DateTimeParser
 *
 * @package Rarus\BonusServer\Util
 */
class DateTimeParser
{
    /**
     * @var int
     */
    private const MIN_TIMESTAMP_LENGTH = 12;

    /**
     * парсим время в виде timestamp + milliseconds
     *
     * @param string $timestampStr
     *
     * @return \DateTime
     * @throws ApiClientException
     */
    public static function parseTimestampFromServerResponse(string $timestampStr): \DateTime
    {
        if (\strlen($timestampStr) < self::MIN_TIMESTAMP_LENGTH) {
            throw new ApiClientException(sprintf('неизвестный формат времени в ответе сервера [%s], ожидали %s или больше символов, получили %s',
                $timestampStr,
                self::MIN_TIMESTAMP_LENGTH,
                \strlen($timestampStr)
            ));
        }
        // отделяем миллисекунды - 4 последних цифры
        $timestampStr = substr($timestampStr, 0, 9) . '.' . substr($timestampStr, 9);
        $timestamp = \DateTime::createFromFormat('U.u', $timestampStr);
        if (false === $timestamp) {
            throw new ApiClientException(sprintf('ошибка при разборе поля время в ответе сервера [%s]', $timestampStr));
        }

        return $timestamp;
    }

    /**
     * сервер принимает значения таймстемпа с учётом микросекунд
     *
     * @param \DateTime $dateTime
     *
     * @return int
     */
    public static function convertToServerFormatTimestamp(\DateTime $dateTime): int
    {
        return $dateTime->getTimestamp() * 1000;
    }
}