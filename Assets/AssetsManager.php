<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AdminBundle\Assets;


	use Symfony\Component\Translation\Exception\NotFoundResourceException;

	class AssetsManager implements AssetsDependencyInterface {

		protected $assetsDependencies = array();


		public function addAssetsDependency(AssetsDependencyInterface $assetsDependency) {
			array_push($this->assetsDependencies, $assetsDependency);
		}


		public function getExternalFiles($group = null) {
			$array = array();
			foreach ($this->assetsDependencies as $assetsDependency) {
				$externalFiles = $assetsDependency->getExternalFiles($group);
				foreach ($externalFiles as $key => $asset) {
					if (!isset($array[$key])) {
						$array[$key] = $asset;
					} elseif (is_array($array[$key])){
						array_push($array[$key], $asset);
					} else {
						$array[$key] = array($array[$key], $asset);
					}
				}
			}

			$resolved = array();
			foreach ($array as $key => $asset) {
				$this->_resolveDependency($key, $array, $resolved);
			}

			return $resolved;
		}


		public function getScripts($group = null) {
			$array = array();
			foreach ($this->assetsDependencies as $assetsDependency) {
				$scripts = $assetsDependency->getScripts($group);
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


			$resolved = array();
			foreach ($array as $key => $asset) {
				$this->_resolveDependency($key, $array, $resolved);
			}

			return $resolved;
		}


		private function _resolveDependency($key, &$array, &$resolved = array()) {
//			if (!isset($array[$key])) {
//				throw new NotFoundResourceException("L'asset ".$key." est manquante !");
//			}

			if (isset($array[$key])) {
				if (is_array($array[$key])) {
					$dependencies = array();
					foreach ($array[$key] as $asset) {
						$assetDependency = $asset->getDependencies();
						if ($assetDependency && count($assetDependency)) {
							$dependencies = array_merge($dependencies, $assetDependency);
						}
					}
				} else {
					$dependencies = $array[$key]->getDependencies();
				}

				if ($dependencies) {
					foreach ($dependencies as $dependency) {
						$this->_resolveDependency($dependency, $array, $resolved);
					}
				}

				$resolved[$key] = $array[$key];
				unset($array[$key]);
			}
		}


	}