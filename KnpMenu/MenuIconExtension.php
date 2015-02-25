<?php

namespace Uneak\AdminBundle\KnpMenu;

use Knp\Menu\ItemInterface;
use Knp\Menu\Factory\ExtensionInterface;

/**
 * core factory extension with the main logic
 */
class MenuIconExtension implements ExtensionInterface {

    public function buildOptions(array $options) {
        return array_merge(
                array(
            'icon' => null,
            'badge' => null,
                ), $options
        );
    }

    public function buildItem(ItemInterface $item, array $options) {
        $item->setIcon($options['icon']);
        $item->setBadge($options['badge']);
    }

}
