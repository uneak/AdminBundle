<?php

namespace Uneak\AdminBundle\Twig\Extension;

use Twig_Extension;
use Twig_Function_Method;
use Uneak\AdminBundle\Assets\AssetsManager;
use Uneak\AdminBundle\Block\BlockInterface;
use Uneak\AdminBundle\Block\BlockManager;
use Uneak\AdminBundle\Block\ScriptJs;
use Uneak\AdminBundle\Form\FormFactory;

class AssetExtension extends Twig_Extension {

	private $twig;
	private $environment;
	private $assetsManager;

	public function __construct(AssetsManager $assetsManager, $twig) {
		$this->assetsManager = $assetsManager;
		$this->twig = $twig;
	}

	public function initRuntime(\Twig_Environment $environment) {
		$this->environment = $environment;
	}

	public function getFunctions() {
		$options = array('pre_escape' => 'html', 'is_safe' => array('html'));

		return array(
			'externalAssets' => new Twig_Function_Method($this, 'externalAssetsFunction', $options),
			'scriptAssets' => new Twig_Function_Method($this, 'scriptAssetsFunction', $options)
		);
	}

	public function externalAssetsFunction($group = null) {
		$string = "";
		$extAssets = $this->assetsManager->getExternalFiles($group);
		foreach ($extAssets as $extAsset) {
			if (is_array($extAsset)) {
				foreach ($extAsset as $extAssetItem) {
					$string .= $extAssetItem;
				}
			} else {
				$string .= $extAsset;
			}
		}
		return $string;
	}

	public function scriptAssetsFunction($group = null) {
		$string = "";
		$scriptAssets = $this->assetsManager->getScripts($group);

		foreach ($scriptAssets as $scriptAsset) {
			if (is_array($scriptAsset)) {
				foreach ($scriptAsset as $scriptAssetItem) {
					$string .= $this->_renderScript($scriptAssetItem);
				}
			} else {
				$string .= $this->_renderScript($scriptAsset);
			}
		}
		return $string;
	}

	private function _renderScript($scriptAsset) {
		if ($scriptAsset instanceof ScriptJs) {
			$render = array();
			array_push($render, '<' . $scriptAsset->getTag());
			array_push($render, ($scriptAsset->getType()) ? ' type="' . $scriptAsset->getType() . '"' : '');
			array_push($render, '>');
			array_push($render, $scriptAsset->getContent());
			array_push($render, '</' . $scriptAsset->getTag() . '>');
			return $this->twig->render(implode(' ', $render), $scriptAsset->getParameters());
		} else {
			return $this->twig->render($scriptAsset->getContent(), $scriptAsset->getParameters());
		}
	}


	public function getName() {
		return 'admin_assets';
	}

}
