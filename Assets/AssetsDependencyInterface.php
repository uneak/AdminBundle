<?php

	namespace Uneak\AdminBundle\Assets;

	interface AssetsDependencyInterface {

		public function getExternalFiles($group = null);
		public function getScripts($group = null);

	}
