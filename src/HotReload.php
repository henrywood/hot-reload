<?php

namespace HSK\HotReload;

use Swoole\Server;

/**
 * 热重载管理器
 * Class HotReloadProcess
 * @package EasySwoole\HotReload
 */
class HotReload
{
	protected $hotReloadOptions;
	protected $hotReloadProcess;

	function __construct(HotReloadOptions $hotReloadOptions)
	{
		$this->hotReloadOptions = $hotReloadOptions;
	}

	public function getHotReloadProcess(): HotReloadProcess
	{
		return $this->hotReloadProcess;
	}

	/**
	 * Title of the hot reload process as shown by ps (default: HotReload).
	 * Call it before the server is started: the process takes its title when it starts.
	 */
	public function setProcessTitle(string $title): void
	{
		$this->processTitle = $title;

		if ($this->hotReloadProcess !== null) {            // already attached: the process object is forked at server start, so this still counts
			$this->hotReloadProcess->setProcessTitle($title);
		}
	}

	/**
	 * 附加到当前服务
	 * @param Server $server
	 */
	function attachToServer(Server $server)
	{
		$this->hotReloadProcess = new HotReloadProcess;
		$this->hotReloadProcess->setSwooleServer($server);
		$this->hotReloadProcess->setHotReloadOptions($this->hotReloadOptions);

		$this->hotReloadProcess->setProcessTitle($this->processTitle);   

		$server->addProcess($this->hotReloadProcess->getProcess());
	}
}
