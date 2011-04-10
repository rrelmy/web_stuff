<?php
/**
 * Description of Profiler
 *
 * @author Rémy Böhler
 */
class Profiler {

    /**
     *
     * @var bool
     */
    protected static $_enabled = false;

    /**
     *
     * @var array
     */
    protected static $_timers = array();

    /**
     *
     * @param string $name
     */
    public static function start($name)
    {
        if (!array_key_exists($name, self::$_timers)) {
            self::$_timers[$name] = array(
                'name' => $name,
                'start' => null,
                'realmem' => 0,
                'emalloc' => 0,
                'profiles' => array(),
            );
        }
        self::$_timers[$name]['start'] = microtime(true);
        self::$_timers[$name]['realmem'] = memory_get_usage(true);
        self::$_timers[$name]['emalloc'] = memory_get_usage(false);
    }

    /**
     *
     * @param string $name
     * @param string $comment optional
     */
    public static function stop($name, $comment = null)
    {
        $timer = &self::$_timers[$name];
        if (!$timer['start']) {
            return;
        }
        $profile = array(
            'comment' => $comment,
            'start' => $timer['start'],
            'duration' => microtime(true) - $timer['start'],
            'realmem' => memory_get_usage(true) - $timer['realmem'],
            'emalloc' => memory_get_usage(false) - $timer['emalloc'],
        );
        $timer['start'] = null;
        $timer['realmem'] = 0;
        $timer['emalloc'] = 0;

        $timer['profiles'][] = $profile;
    }

    public static function enable()
    {
        self::$_enabled = true;
    }

    public static function disable()
    {
        self::$_enabled = false;
    }

    /**
     *
     * @return bool
     */
    public static function enabled()
    {
        return self::$_enabled;
    }

    /**
     *
     * @return array
     */
    public static function getTimers()
    {
        return self::$_timers;
    }
}

