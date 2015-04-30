<?php

	namespace Uneak\AdminBundle\Block;

	class BlockManager {

		protected $blocks;

		public function __construct() {
			$this->blocks = array();
		}

		public function getExternalFiles($group = null) {
			
			$array = array();
			foreach ($this->blocks as $block) {
				$array = array_merge($array, $block->getExternalFiles($group));
			}
			usort($array, array($this, "cmpByPriority"));

			return $array;
		}

		public function getScripts($group = null) {
			$array = array();
			foreach ($this->blocks as $block) {
				$array = array_merge($array, $block->getScripts($group));
			}
			usort($array, array($this, "cmpByPriority"));

			return $array;
		}

		private function cmpByPriority($a, $b) {
			if ($a->getPriority() == $b->getPriority()) {
				return 0;
			}

			return ($a->getPriority() > $b->getPriority()) ? -1 : 1;
		}

		public function addBlock($id, BlockInterface $block, $priority = 0, $group = null) {
			if (!$group) {
				$group = "__undefined";
			}
			if (!isset($this->blocks[$group])) {
				$this->blocks[$group] = new BlockChain();
			}
			$this->blocks[$group]->addBlock($id, $block, $priority);
		}

		public function getBlocks($group) {
			return (isset($this->blocks[$group])) ? $this->blocks[$group]->getBlocks() : null;
		}

		public function getBlock($id, $group = null) {
			if (!$group) {
				$group = "__undefined";
			}

			return (isset($this->blocks[$group])) ? $this->blocks[$group]->getBlock($id) : null;
		}

		public function hasBlock($id, $group = null) {
			if (!$group) {
				$group = "__undefined";
			}

			return (isset($this->blocks[$group])) ? $this->blocks[$group]->hasBlock($id) : null;
		}

		public function removeBlock($id, $group = null) {
			if (!$group) {
				$group = "__undefined";
			}

			return (isset($this->blocks[$group])) ? $this->blocks[$group]->removeBlock($id) : null;
		}

		public function clearBlocks($group) {
			if (isset($this->blocks[$group])) {
				$this->blocks[$group]->clearBlocks();
			}

			return $this;
		}

	}
