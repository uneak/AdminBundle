<?php

namespace Uneak\AdminBundle\Block;

use Uneak\AdminBundle\Block\BlockInterface;

class BlockChain {

	protected $blocks;

	public function __construct() {
		$this->blocks = array();
	}


	public function getExternalFiles($group = null) {
		$array = array();
		foreach ($this->blocks as $block) {
			$array = array_merge($array, $block['block']->getExternalFiles($group));
		}
		return $array;
	}

	public function getScripts($group = null) {
		$array = array();
		foreach ($this->blocks as $block) {
			$array = array_merge($array, $block['block']->getScripts($group));
		}
		return $array;
	}

	public function addBlock($id, BlockInterface $block, $priority) {
		$this->blocks[$id] = array('block' => $block, 'priority' => $priority);
		uasort($this->blocks, array($this, "_cmp"));
	}

	public function getBlock($id) {
		return $this->blocks[$id]['block'];
	}

	public function removeBlock($id) {
		unset($this->blocks[$id]);
		return $this;
	}
	
	public function getBlocks() {
		$array = array();
		foreach ($this->blocks as $key => $block) {
			$array[$key] = $block['block'];
		}
		return $array;
	}

	public function clearBlocks() {
		$this->blocks = array();
		return $this;
	}

	private function _cmp($a, $b) {
		if ($a['priority'] == $b['priority']) {
			return 0;
		}
		return ($a['priority'] > $b['priority']) ? -1 : 1;
	}

}
