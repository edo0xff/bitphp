<?php namespace Helpers;
	  use BitPHP;
	
	/**
  	*	Provides methods for show modals messages.
  	*
  	*	@author Eduardo B <ms7rbeta@gmail.com>
  	*	@version beta 1.6.0
  	* 	@package Core
  	*	@copyright 2014 Root404 Co.
  	*	@website http://bitphp.root404.com <contacto@root404.com>
  	*	@license GNU/GPLv3
  	*/
	class FlashMessages {
		protected $help_file;

		public function __construct() {
			$this->help_file = 'core/helpers/FlashMessages.help';
			$this->name      = 'FlashMessages';
		}

		/**
		* Modal message style danger
		*
		*	@param string $title title of the modal
		*	@param string $content content of the modal
		*	@return void
		*/
		public function danger($title, $content) {

			BitPHP\Load::view(
				[
					'core/FlashMessages/header',
					'core/FlashMessages/danger',
					'core/FlashMessages/footer'
				],
				[
					'title'   => $title,
					'content' => $content,
					'name'    => $title.'-flashDanger'
				]
			);
		}

		/**
		* Modal message style warning
		*
		*	@param string $title title of the modal
		*	@param string $content content of the modal
		*	@return void
		*/
		public function warning($title, $content) {

			BitPHP\Load::view(
				[
					'core/FlashMessages/header',
					'core/FlashMessages/warning',
					'core/FlashMessages/footer'
				],
				[
					'title'   => $title,
					'content' => $content,
					'name'    => $title.'-flashWarning'
				]
			);
		}		

		/**
		* Modal message style success
		*
		*	@param string $title title of the modal
		*	@param string $content content of the modal
		*	@return void
		*/
		public function success($title, $content) {

			BitPHP\Load::view(
				[
					'core/FlashMessages/header',
					'core/FlashMessages/success',
					'core/FlashMessages/footer'
				],
				[
					'title'   => $title,
					'content' => $content,
					'name'    => $title.'-flashSuccess'
				]
			);
		}

		/**
		* Modal message style info
		*
		*	@param string $title title of the modal
		*	@param string $content content of the modal
		*	@return void
		*/
		public function info($title, $content) {

			BitPHP\Load::view(
				[
					'core/FlashMessages/header',
					'core/FlashMessages/info',
					'core/FlashMessages/footer'
				],
				[
					'title'   => $title,
					'content' => $content,
					'name'    => $title.'-flashInfo'
				]
			);
		}

		/**
		* Modal message without style
		*
		*	@param string $title title of the modal
		*	@param string $content content of the modal
		*	@return void
		*/
		public function normal($title, $content) {

			BitPHP\Load::view(
				[
					'core/FlashMessages/header',
					'core/FlashMessages/panel',
					'core/FlashMessages/footer'
				],
				[
					'title'   => $title,
					'content' => $content,
					'name'    => $title.'-flashNormal'
				]
			);
		}

		/**
		* Print the helper's help file
		*
		*	@param string $title title of the modal
		*	@param string $content content of the modal
		*	@return void
		*/
		public function help() {
			$content = @file_get_contents($this->help_file);
			if($content === FALSE){ return 0; }

			$this->normal($this->name, $content);
		}
	}
?>