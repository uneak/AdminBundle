<?php

namespace Uneak\AdminBundle\Twig\Extension;

use Twig_Extension;
use Twig_Function_Method;
use Uneak\AdminBundle\Block\BlockInterface;
use Uneak\AdminBundle\Block\BlockManager;

class BlockExtension extends Twig_Extension {

	private $environment;
	private $blockManager;

	public function __construct(BlockManager $blockManager) {
		$this->blockManager = $blockManager;
	}

	public function initRuntime(\Twig_Environment $environment) {
		$this->environment = $environment;
	}

	public function getFunctions() {
		$options = array('pre_escape' => 'html', 'is_safe' => array('html'));

		return array(
			'render_block' => new Twig_Function_Method($this, 'blockFunction', $options),
			'render_blockManager' => new Twig_Function_Method($this, 'blockManagerFunction', $options)
		);
	}

	public function blockFunction(BlockInterface $block) {
		return $this->environment->render($block->getTemplate(), array('item' => $block));
	}

	public function blockManagerFunction($group) {
		$htmls = array();
		$blocks = $this->blockManager->getBlocks($group);
		foreach ($blocks as $block) {
			$htmls[] = $this->blockFunction($block);
		}
		$html = implode("<hr class='separator' />", $htmls);

		return $html;
	}

	public function getName() {
		return 'admin_block';
	}

}
