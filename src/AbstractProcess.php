<?php
namespace HSK\HotReload;

use EasySwoole\Component\Process\AbstractProcess as Base;
use EasySwoole\Component\Process\Config;

abstract class AbstractProcess extends Base {

   protected $swooleProcess;  // Add protected property

    function __construct(...$args)
    {
        $config = new Config();
        $config->setProcessName('HotReload');
        $config->setEnableCoroutine(true);
        
        parent::__construct($config);
        
        $this->swooleProcess = new \Swoole\Process(
            [$this, '__start'],
            false,
            0,
            true
        );
    }

    public function getProcess() {
        return $this->swooleProcess;
    }
}
