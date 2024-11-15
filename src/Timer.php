<?php
namespace HSK\HotReload;

class Timer {
    public static function delay(int $ms, callable $callback, ...$params) {
        \Swoole\Timer::after($ms, $callback, ...$params);
    }

    public static function loop(int $ms, callable $callback, ...$params) {
        return \Swoole\Timer::tick($ms, $callback, ...$params);
    }
}
