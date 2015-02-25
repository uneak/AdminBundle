<?php

	namespace Uneak\AdminBundle\Block;

	interface BlockManagerInterface {
		public function addBlock($id, BlockInterface $block, $priority, $group = null);
		public function getBlocks($group);
		public function getBlock($id, $group = null);
		public function removeBlock($id, $group = null);
		public function clearBlocks($group);
	}
