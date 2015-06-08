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
			$scripts = $block['block']->getExternalFiles($group);
			foreach ($scripts as $key => $asset) {
				if (!isset($array[$key])) {
					$array[$key] = $asset;
				} elseif (is_array($array[$key])){
					array_push($array[$key], $asset);
				} else {
					$array[$key] = array($array[$key], $asset);
				}
			}
		}
		return $array;
	}

	public function getScripts($group = null) {
		$array = array();
		foreach ($this->blocks as $block) {
			$scripts = $block['block']->getScripts($group);
			foreach ($scripts as $key => $asset) {
				if (!isset($array[$key])) {
					$array[$key] = $asset;
				} elseif (is_array($array[$key])){
					array_push($array[$key], $asset);
				} else {
					$array[$key] = array($array[$key], $asset);
				}
			}
		}
		return $array;
	}



	public function addBlock(BlockInterface $block, $id, $priority) {
		if ($id) {
			$this->blocks[$id] = array('block' => $block, 'priority' => $priority);
		} else {
			$this->blocks[] = array('block' => $block, 'priority' => $priority);
		}
		uasort($this->blocks, array($this, "_cmp"));
	}

	public function getBlock($id) {
		return (isset($this->blocks[$id])) ? $this->blocks[$id]['block'] : null;
	}

	public function hasBlock($id) {
		return isset($this->blocks[$id]);
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
