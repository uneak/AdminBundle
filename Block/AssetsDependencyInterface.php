<?php

	namespace Uneak\AdminBundle\Block;

	interface AssetsDependencyInterface {

		public function addExternalFile(ExternalFile $externalFile);
		public function removeExternalFile(ExternalFile $externalFile);
		public function getExternalFiles($group = null);
		public function setExternalFiles($externalFiles);
		public function addScript(Script $scripts);
		public function removeScript(Script $scripts);
		public function getScripts($group = null);
		public function setScripts($scripts);

	}
