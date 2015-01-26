<?php

namespace Uneak\AdminBundle\Block;

use Uneak\AdminBundle\Block\BlockInterface;

abstract class Block implements BlockInterface {

    protected $title;
    protected $collapsible = true;
    protected $class;
    protected $template;

    public function getTemplate() {
        return $this->template;
    }

    public function setTemplate($template) {
        $this->template = $template;
        return $this;
    }

    public function getClass() {
        return $this->class;
    }

    public function setClass($class) {
        $this->class = $class;
        return $this;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function getCollapsible() {
        return $this->collapsible;
    }

    public function setCollapsible($collapsible) {
        $this->collapsible = $collapsible;
        return $this;
    }

}
