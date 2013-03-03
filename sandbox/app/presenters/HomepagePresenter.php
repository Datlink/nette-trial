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
        $this->taskRepository = $this->context->taskRepository;
    }
    
    public function createComponentIncompleteTasks()
    {
        return new Todo\TaskListControl($this->taskRepository->findIncomplete(), $this->taskRepository);
    }

}