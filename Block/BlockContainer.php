<?php

namespace Uneak\AdminBundle\Block;

use Uneak\AdminBundle\Block\Block;
use Uneak\AdminBundle\Block\BlockInterface;

class BlockContainer extends Block {

    protected $blocks;

    public function __construct() {
        $this->blocks = array();
    }

    public function addBlock(BlockInterface $block) {
        array_push($this->blocks, $block);
        return $this;
    }

    public function removeBlock(BlockInterface $block) {
        $key = array_search($block, $this->blocks);
        if ($key !== false) {
            array_splice($this->blocks, $key, 1);
        }
        return $this;
    }

    public function setBlocks($blocks) {
        $this->blocks = $blocks;
        return $this;
    }

    public function getBlocks() {
        return $this->blocks;
    }

}
