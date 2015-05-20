<?php

	namespace Uneak\AdminBundle\Block;

	interface BlockManagerInterface {
		public function addBlock(BlockInterface $block, $id = null, $priority, $group = null);
		public function getBlocks($group);
		public function getBlock($id, $group = null);
		public function removeBlock($id, $group = null);
		public function clearBlocks($group);
	}
