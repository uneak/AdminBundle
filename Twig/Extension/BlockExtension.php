<?php

namespace Uneak\AdminBundle\Twig\Extension;

use Twig_Extension;
use Twig_Function_Method;
use Uneak\AdminBundle\Block\BlockInterface;
use Uneak\AdminBundle\Block\BlockManager;
use Uneak\AdminBundle\Block\ScriptJs;

class BlockExtension extends Twig_Extension {

	private $twig;
	private $environment;
	private $blockManager;

	public function __construct(BlockManager $blockManager, $twig) {
		$this->blockManager = $blockManager;
		$this->twig = $twig;
	}

	public function initRuntime(\Twig_Environment $environment) {
		$this->environment = $environment;
	}

	public function getFunctions() {
		$options = array('pre_escape' => 'html', 'is_safe' => array('html'));

		return array(
			'render_block' => new Twig_Function_Method($this, 'blockFunction', $options),
			'render_blockManager' => new Twig_Function_Method($this, 'blockManagerFunction', $options),
			'externalAssets' => new Twig_Function_Method($this, 'externalAssetsFunction', $options),
			'scriptAssets' => new Twig_Function_Method($this, 'scriptAssetsFunction', $options)
		);
	}


	public function blockFunction($block, $group = null) {
		if (is_string($block)) {
			$block = $this->blockManager->getBlock($block, $group);
		}

		if ($block instanceof BlockInterface) {

			$block->preRender();
			return $this->environment->render($block->getTemplate(), array('item' => $block));

		} else {
			return '#ERROR : block not found';
		}

	}

	public function externalAssetsFunction($group = null) {
		$string = "";
		$extAssets = $this->blockManager->getExternalFiles($group);
		foreach ($extAssets as $extAsset) {
			$string .= $extAsset;
		}
		return $string;
	}

	public function scriptAssetsFunction($group = null) {
		$string = "";
		$scriptAssets = $this->blockManager->getScripts($group);
		foreach ($scriptAssets as $scriptAsset) {

			if ($scriptAsset instanceof ScriptJs) {
				$render = array();
				array_push($render, '<' . $scriptAsset->getTag());
				array_push($render, ($scriptAsset->getType()) ? ' type="' . $scriptAsset->getType() . '"' : '');
				array_push($render, '>');
				array_push($render, $scriptAsset->getContent());
				array_push($render, '</' . $scriptAsset->getTag() . '>');

				$string .= $this->twig->render(implode(' ', $render), $scriptAsset->getParameters());
			} else {
				$string .= $this->twig->render($scriptAsset->getContent(), $scriptAsset->getParameters());
			}
		}
		return $string;
	}

	public function blockManagerFunction($group, $separator = "") {
		$htmls = array();
		$blocks = $this->blockManager->getBlocks($group);
		foreach ($blocks as $block) {

			$htmls[] = $this->blockFunction($block);
		}

		$html = implode($separator, $htmls);

		return $html;
	}

	public function getName() {
		return 'admin_block';
	}

}
