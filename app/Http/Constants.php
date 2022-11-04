<?php
/**
 * User: daniel odeh
 * Date: 04/11/22
 * Time: 02:42 PM
 */

/**
 * Class UserType
 *
 * @package App\Http
 */
final class UserType
{
    const USER = '10';

    /**
     * Returns respective value.
     *
     * @param $x
     *
     * @return null
     */
    public static function getValue($x)
    {
        $value = null;
        switch ($x) {
            case '10':
                $value = __('User');
                break;
        }

        return $value;
    }

    /**
     * @return array
     */
    public static function getAll()
    {
        return [
            self::USER => UserType::getValue(self::USER)
        ];
    }
}