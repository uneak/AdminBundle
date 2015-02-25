<?php

namespace Uneak\AdminBundle\Block;

interface BlockInterface {
    public function getMetas();
    public function getTemplate();
    public function setTemplate($template);
    public function getTitle();
    public function setTitle($title);
}
