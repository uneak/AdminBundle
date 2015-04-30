<?php
	/**
	 * Created by PhpStorm.
	 * User: marc
	 * Date: 29/01/15
	 * Time: 16:13
	 */

	namespace Uneak\AdminBundle\Block;

	class ExternalCss extends ExternalFile {

		protected $rel;
		protected $media;

		public function __construct($href, $media="", $rel="", $type = "text/css", $tag = "link", $priority = 0, $group = "ExternalCss") {
			$this->priority = $priority;
			$this->group = $group;
			$this->tag = $tag;
			$this->type = $type;
			$this->src = $href;
			$this->media = $media;
			$this->rel = $rel;
		}

		public function getMedia() {
			return $this->media;
		}

		public function setMedia($media) {
			$this->media = $media;
			return $this;
		}

		public function getRel() {
			return $this->rel;
		}

		public function setRel($rel) {
			$this->rel = $rel;
			return $this;
		}

		public function getHref() {
			return $this->src;
		}

		public function setHref($href) {
			$this->src = $href;
			return $this;
		}


		public function __toString() {
			$render = array();
			array_push($render, '<' . $this->getTag());
			array_push($render, ($this->getHref()) ? 'href="' . $this->getHref() . '"' : '');
			array_push($render, ($this->getRel()) ? 'rel="' . $this->getRel() . '"' : '');
			array_push($render, ($this->getType()) ? 'type="' . $this->getType() . '"' : '');
			array_push($render, ($this->getMedia()) ? 'media="' . $this->getMedia() . '"' : '');
			array_push($render, '/>');

			return implode(' ', $render);

		}


	}