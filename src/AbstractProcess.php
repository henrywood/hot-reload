<?php
namespace HSK\HotReload;

use EasySwoole\Component\Process\AbstractProcess as Base;
use EasySwoole\Component\Process\Config;

abstract class AbstractClass extends Base {

        /**
         * name  args  false 2 true
         * AbstractProcess constructor.
         * @param string $processName
         * @param null $arg
         * @param bool $redirectStdinStdout
         * @param int $pipeType
         * @param bool $enableCoroutine
         */
        function __construct(...$args)
        {
                $arg1 = array_shift($args);
                if($arg1 instanceof Config){
                        $this->config = $arg1;
                }else{
                        $this->config = new Config();
                        $this->config->setProcessName($arg1);
                        $arg = array_shift($args);
                        $this->config->setArg($arg);
                        $redirectStdinStdout = (bool)array_shift($args) ?: false;
                        $this->config->setRedirectStdinStdout($redirectStdinStdout);
                        $pipeType = array_shift($args);
                        $pipeType = $pipeType === null ? Config::PIPE_TYPE_SOCK_DGRAM : $pipeType;
                        $this->config->setPipeType($pipeType);
                        $enableCoroutine = (bool)array_shift($args) ?: false;
                        $this->config->setEnableCoroutine($enableCoroutine);
                }

                $this->swooleProcess = new \Swoole\Process([$this,'__start'],$this->config->isRedirectStdinStdout(),$this->config->getPipeType(),$this->config->isEnableCoroutine());
                //$this->swooleProcess = new \Swoole\Process([$this,'__start'],false,0,true);
                //$this->swooleProcess = new \swoole_process([$this,'__start'],$this->config->isRedirectStdinStdout(),$this->config->getPipeType(),$this->config->isEnableCoroutine());
        }
}
