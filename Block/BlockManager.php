<?php

	namespace Uneak\AdminBundle\Block;

	use Uneak\AdminBundle\Assets\AssetsManager;

	class BlockManager extends BlockContainer {

		public function __construct(AssetsManager $assetsManager) {
			parent::__construct();
			$assetsManager->addAssetsDependency($this);
		}

	}
