<?php

namespace Uneak\AdminBundle\Block;

use Uneak\AdminBundle\Block\BlockInterface;
use Uneak\AdminBundle\Block\BlockChain;

class BlockManager {

	protected $blockChains;

	public function __construct() {
		$this->blockChains = array();
	}

	public function addBlock($id, BlockInterface $block, $priority, $group = null) {
		if (!$group) {
			$group = "__undefined";
		}
		if (!isset($this->blockChains[$group])) {
			$this->blockChains[$group] = new BlockChain();
		}
		$this->blockChains[$group]->addBlock($id, $block, $priority);
	}

	public function getBlocks($group) {
		return $this->blockChains[$group]->getBlocks();
	}

	public function getBlock($id, $group = null) {
		if (!$group) {
			$group = "__undefined";
		}
		return $this->blockChains[$group]->getBlock($id);
	}

	public function removeBlock($id, $group = null) {
		if (!$group) {
			$group = "__undefined";
		}
		return $this->blockChains[$group]->removeBlock($id);
	}
	
	public function clearBlocks($group) {
		$this->blockChains[$group]->clearBlocks();
		return $this;
	}

}
