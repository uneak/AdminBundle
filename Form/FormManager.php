<?php

	namespace Uneak\AdminBundle\Form;


	use Symfony\Bridge\Twig\Form\TwigRendererEngine;
	use Symfony\Component\Form\FormInterface;
	use Symfony\Component\Form\FormView;
	use Uneak\AdminBundle\Assets\AssetsDependencyInterface;
	use Uneak\AdminBundle\Assets\AssetsManager;

	class FormManager implements AssetsDependencyInterface {


		protected $assetsFormType = array();
		protected $twigRendererEngine;

		public function __construct(AssetsManager $assetsManager, TwigRendererEngine $twigRendererEngine) {
			$assetsManager->addAssetsDependency($this);
			$this->twigRendererEngine = $twigRendererEngine;
		}


		public function createView(FormInterface $form, FormView $view = null) {

			if ($view === null) {
				$view = $form->createView();
			}

			foreach ($view->children as $key => $child) {
				if ($form->has($key)) {
					$this->createView($form->get($key), $child);
				}
			}

			$innerType = $form->getConfig()->getType()->getInnerType();

			if ($innerType instanceOf AssetsAbstractType) {
				$innerType->setFormView($view);
				$this->twigRendererEngine->setTheme($view, $innerType->getTheme());
				array_push($this->assetsFormType, $innerType);
			}

			return $view;
		}


		public function getExternalFiles($group = null) {
			$array = array();
			foreach ($this->assetsFormType as $assetsDependency) {
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
			return $array;
		}

		public function getScripts($group = null) {
			$array = array();
			foreach ($this->assetsFormType as $assetsDependency) {
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
			return $array;
		}


	}
