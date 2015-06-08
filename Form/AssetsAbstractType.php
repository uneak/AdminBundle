<?php

	namespace Uneak\AdminBundle\Form;

	use Symfony\Component\Form\AbstractType;
	use Symfony\Component\Form\FormView;
	use Uneak\AdminBundle\Assets\AssetsDependencyInterface;

	abstract class AssetsAbstractType extends AbstractType implements AssetsDependencyInterface {

		protected $formView;
		protected $theme;

		public function __construct(){
		}

		protected function _registerExternalFile(FormView $formView) {
			return array();
		}

		protected function _registerScript(FormView $formView) {
			return array();
		}

		public function getFormView() {
			return $this->formView;
		}

		public function setFormView($formView) {
			$this->formView = $formView;
			return $this;
		}

		public function setTheme($theme) {
			$this->theme = $theme;
			return $this;
		}

		public function getTheme() {
			return $this->theme;
		}

		public function getExternalFiles($group = null) {
			$externalFiles = $this->_registerExternalFile($this->formView);
			$array = array();
			foreach ($externalFiles as $key => $externalFile) {
				if ($group) {
					if ($externalFile->getGroup() == $group) {
						$array[$key] = $externalFile;
					}
				} else {
					$array[$key] = $externalFile;
				}
			}
			return $array;
		}

		public function getScripts($group = null) {
			$scripts = $this->_registerScript($this->formView);
			$array = array();
			foreach ($scripts as $key => $script) {
				if ($group) {
					if ($script->getGroup() == $group) {
						$array[$key] = $script;
//						array_push($array, $script);
					}
				} else {
//					array_push($array, $script);
					$array[$key] = $script;
				}
			}

			return $array;
		}

	}
