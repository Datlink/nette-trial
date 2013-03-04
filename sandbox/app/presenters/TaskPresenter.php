<?php
use Nette\Application\UI\Form;
/**
 * Presenter, který zajišťuje výpis seznamů úkolů.
 */
class TaskPresenter extends BasePresenter
{
    /** @var @var Todo\ListRepository */
    private $listRepository;
    private $userRepository;
    private $taskRepository;

    protected function startup()
    {
        parent::startup();
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }
        
        $this->listRepository = $this->context->listRepository;
        $this->userRepository = $this->context->userRepository; // získáme model pro práci s uživateli
        $this->taskRepository = $this->context->taskRepository;
    }
    
    protected function createComponentTaskForm($name)
    {
        $userPairs = $this->userRepository->findAll()->fetchPairs('id','name');
        
        $form = new Form($this, $name);
        $form->addText('text', 'Úkol:', 40, 100)
                ->addRule(Form::FILLED, 'Je nutné zadat text úkolu.');
        $form->addSelect('userId', 'Pro:', $userPairs)
                ->setPrompt('- Vyberte -')
                ->addRule(Form::FILLED, 'Je nutné vybrat, komu je úkol přiřazen.')
                ->setDefaultValue($this->getUser()->getId());
        $form->addSubmit('create', 'Vytvořit');
        $form->onSuccess[] = $this->taskFormSubmitted;
        return $form;
    }
    
    public function taskFormSubmitted(Form $form)
    {
        $this->taskRepository->createTask($this->list->id, $form->values->text, $form->values->userId);
        $this->flashMessage('Úkol přidán.', 'success');
        if (!$this->isAjax()) { // pokud to není ajaxový request
            $this->redirect('this'); // přesměrovat
        } else { // pokud je tak nastavit formuláři výchozí hodnoty a zneplatnění snippetu form
            $form->setValues(array('userId' => $form->values->userId), TRUE);
            $this->invalidateControl('form');
            $this['taskList']->invalidateControl();
        }
    }


    /** @var \Nette\Database\Table\ActiveRow */
    private $list;

    public function actionDefault($id)
    {
        $this->list = $this->listRepository->find($id);
        if ($this->list === FALSE) {
            $this->setView('notFound');
        }
    }
    
    public function renderDefault($id)
    {
        $this->template->list = $this->list;
    }
    
    protected function createComponentTaskList()
    {
        if($this->list === NULL) {
            $this->error('Wrong action');
        }
        return new Todo\TaskListControl($this->listRepository->tasksOf($this->list), $this->taskRepository);
    }
}