<?php
/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

    public function renderDefault()
    {
        $this->template->tasks = $this->taskRepository->findIncomplete();
    }
    
    /** @var Todo\TaskRepository */
    private $taskRepository;

    protected function startup()
    {
        parent::startup();
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }
        
        $this->taskRepository = $this->context->taskRepository;
    }
    
    public function createComponentIncompleteTasks()
    {
        return new Todo\TaskListControl($this->taskRepository->findIncomplete(), $this->taskRepository);
    }
    
    public function createComponentUserTasks()
    {
        $incomplete = $this->taskRepository->findIncompleteByUser($this->getUser()->getId());
        $control = new Todo\TaskListControl($incomplete, $this->taskRepository);
        $control->displayList = TRUE;
        $control->displayUser = FALSE;
        return $control;
    }

}