<?php

namespace Uneak\AdminBundle\KnpMenu;

use Knp\Menu\MenuItem as KnpMenuItem;

class MenuItem extends KnpMenuItem {

    protected $icon;
    protected $badge;
    
    public function getBadge() {
        return $this->badge;
    }

    public function setBadge($badge) {
        $this->badge = $badge;
        return $this;
    }
    
    public function getIcon() {
        return $this->icon;
    }

    public function setIcon($icon) {
        $this->icon = $icon;
        return $this;
    }

}
