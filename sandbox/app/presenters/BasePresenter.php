<?php

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
		/** @var Todo\ListRepository */
		private $listRepository;
		
		protected function startup()
		{
		    parent::startup();
		    $this->listRepository = $this->context->listRepository;
		}
		
		public function beforeRender()
		{
		    $this->template->lists = $this->listRepository->findAll()->order('title ASC');
		}
}
