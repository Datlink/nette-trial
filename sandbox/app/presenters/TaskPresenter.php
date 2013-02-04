<?php
/**
 * Presenter, který zajišťuje výpis seznamů úkolů.
 */
class TaskPresenter extends BasePresenter
{
		/** @var @var Todo\ListRepository */
		private $listRepository;
		
		protected function startup()
		{
		    parent::startup();
		    $this->listRepository = $this->context->listRepository;
		}
		
		/** @var \Nette\Database\Table\ActiveRow */
		private $list;
		
		public function actionDefault($id)
		{
		    $this->list = $this->listRepository->find( $id);
		    if ($this->list === FALSE) {
		        $this->setView('notFound');
		    }
		}
		
		public function renderDefault()
		{
		    $this->template->list = $this->list;
		    $this->template->tasks = $this->listRepository->tasksOf($this->list);
		}
} 