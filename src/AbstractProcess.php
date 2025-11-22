<?php
namespace HSK\HotReload;

use EasySwoole\Component\Process\AbstractProcess as Base;
use EasySwoole\Component\Process\Config;

abstract class AbstractProcess extends Base {

   protected $swooleProcess;  // Add protected property

    function __construct(...$args)
    {
        $old = error_reporting();
        error_reporting($old & ~E_WARNING);   // disable warnings only
        
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

       error_reporting($old);
    }

    public function getProcess(): \Swoole\Process  {
        return $this->swooleProcess;
    }
}
