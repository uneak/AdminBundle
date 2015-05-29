<?php

	namespace Uneak\AdminBundle\Block;

	class BlockContainer extends Block {

		protected $blocks = array();

		public function __construct() {
			parent::__construct();
		}

		public function getExternalFiles($group = null) {
			$array = parent::getExternalFiles($group);
			foreach ($this->blocks as $block) {
				$scripts = $block->getExternalFiles($group);
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
			$array = parent::getScripts($group);
			foreach ($this->blocks as $block) {

				$scripts = $block->getScripts($group);
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


		public function addBlock(BlockInterface $block, $id = null, $priority = 0, $group = null) {
			if (!$group) {
				$group = "__undefined";
			}
			if (!isset($this->blocks[$group])) {
				$this->blocks[$group] = new BlockChain();
			}
			$this->blocks[$group]->addBlock($block, $id, $priority);
			return $this;
		}

		public function getBlocks($group = null) {
			if (!$group) {
				$group = "__undefined";
			}
			return (isset($this->blocks[$group])) ? $this->blocks[$group]->getBlocks($group) : null;
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
