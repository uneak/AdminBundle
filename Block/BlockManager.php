<?php

	namespace Uneak\AdminBundle\Block;

	class BlockManager extends BlockContainer {

		public function getExternalFiles($group = null) {
			$array = parent::getExternalFiles($group);
			usort($array, array($this, "cmpByPriority"));
			return $array;
		}

		public function getScripts($group = null) {
			$array = parent::getScripts($group);
			usort($array, array($this, "cmpByPriority"));
			return $array;
		}

		private function cmpByPriority($a, $b) {
			if ($a->getPriority() == $b->getPriority()) {
				return 0;
			}
			return ($a->getPriority() > $b->getPriority()) ? -1 : 1;
		}

	}
