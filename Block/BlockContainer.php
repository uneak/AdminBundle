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
				$array = array_merge($array, $block->getExternalFiles($group));
			}
			return $array;
		}

		public function getScripts($group = null) {
			$array = parent::getScripts($group);
			foreach ($this->blocks as $block) {
				$array = array_merge($array, $block->getScripts($group));
			}
			return $array;
		}

		public function addBlock(BlockInterface $block) {
			array_push($this->blocks, $block);

			return $this;
		}

		public function removeBlock(BlockInterface $block) {
			$key = array_search($block, $this->blocks);
			if ($key !== false) {
				array_splice($this->blocks, $key, 1);
			}

			return $this;
		}

		public function getBlocks() {
			return $this->blocks;
		}

		public function setBlocks($blocks) {
			$this->blocks = $blocks;

			return $this;
		}

	}
