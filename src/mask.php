<?php
namespace lyhiving\mask;

class mask
{
     /**
     * 生成马赛克字符串
     *
     * @param  integer  $strlen 字符串总长度
     * @param  integer  $remain 保留显示的字符串长度
     * @return string
     */
    protected static function _mask($strlen, $remain = 0)
    {
        $l = $strlen - $remain;
        if ($l > 0) {
            return str_repeat('*', $l);
        }
        return '';
    }

    /**
     * 格式化身份证
     *
     * @param  string   $str
     * @param  string   $m     用来打马赛克的字符串，留空则会保留原字符串长度填充
     * @return string
     */
    public static function formatIdCard($str, $m = '')
    {
        $str = trim($str);

        if (!$m) {
            $m = self::_mask(strlen($str), 6);
        }

        return substr_replace($str, $m, 2, -4);
    }

    /**
     * 格式化手机号
     *
     * @param  string   $str
     * @param  string   $m
     * @return string
     */
    public static function formatPhone($str, $m = '')
    {
        $str = trim($str);

        if (!$m) {
            $m = self::_mask(strlen($str), 7);
        }

        return substr_replace($str, $m, 3, -4);
    }

    /**
     * 格式化银行卡号
     *
     * @param  string   $str
     * @param  string   $m
     * @return string
     */
    public static function formatBankCard($str, $m = '')
    {
        $str = trim($str);

        if (!$m) {
            $m = self::_mask(strlen($str), 4);
        }

        return substr_replace($str, $m, 0, -4);
    }

    /**
     * 格式化密码
     *
     * @param  string   $str
     * @param  string   $m
     * @return string
     */
    public static function formatPassword($str, $m = '')
    {
        $str = trim($str);

        if (!$m) {
            $m = self::_mask(strlen($str), 0);
        }

        return substr_replace($str, $m, 0);
    }

    /**
     * 格式化邮箱
     *
     * @param  string   $str
     * @param  string   $m
     * @return string
     */
    public static function formatEmail($str, $m = '')
    {
        $str = trim($str);

        $pos = strpos($str, '@');
        if (!$pos) {
            return $str;
        }

        if (!$m) {
            $m = self::_mask(strlen($str), strlen($str) - $pos + 1);
        }

        return substr_replace($str, $m, 1, $pos - 1);
    }

    /**
     * 替换长字符串
     *
     * @param  string   $str
     * @param  integer  $length
     * @param  string   $m
     * @return string
     */
    public static function formatLongString($str, $length = 100, $m = '...')
    {
        if (mb_strlen($str) > $length) {
            return mb_substr($str, 0, $length) . $m;
        }
        return $str;
    }

    /**
     * 递归对含有敏感信息的数组自行检查打码
     *
     * @param  array   $arr
     * @param  integer $ls    对超过 $ls 长度的字符串进行替换
     * @return array
     */
    public static function format(array $arr, $ls = 0)
    {
        foreach ($arr as $k => $v) {
            if (is_array($v)) {
                $arr[$k] = self::format($v, $ls);
            } elseif (is_string($v)) {
                if (preg_match('/type/i', $k)) {
                    // 例如APP上传的终端信息里面的mobile_phone_type
                    continue;
                } elseif (preg_match('/mail/i', $k)) {
                    // 邮箱
                    $arr[$k] = self::formatEmail($v);
                } elseif (preg_match('/phone|mobile/i', $k)) {
                    // 手机
                    $arr[$k] = self::formatPhone($v);
                } elseif (preg_match('/identity|id(_)?(number|card)/i', $k)) {
                    // 身份证号
                    $arr[$k] = self::formatIdCard($v);
                } elseif (preg_match('/passw(or)?d|pwd/i', $k)) {
                    // 密码
                    $arr[$k] = self::formatPassword($v);
                } elseif (preg_match('/bank(_)?(no|number|card|account)/i', $k)) {
                    // 银行卡
                    $arr[$k] = self::formatBankCard($v);
                }

                if ($ls > 0) {
                    // 长字符串
                    $arr[$k] = self::formatLongString($arr[$k], $ls);
                }
            }
        }

        return $arr;
    }
}
