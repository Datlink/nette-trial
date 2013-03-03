<?php
use Nette\Application\UI\Form;
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
    
    /** Formulář pro přidání seznamu úkolů **/
    protected function createComponentNewListForm($name)
    {
        $form = new Form($this, $name);
        $form->addText('title', 'Název:', 15, 50)
            ->addRule(Form::FILLED, 'Musíte zadat název seznamu úkolů.');
        $form->addSubmit('create', 'Vytvořit');
        $form->onSuccess[] = $this->newListFormSubmitted;
        return $form;
    }

    public function newListFormSubmitted(Form $form)
    {
        $list = $this->listRepository->createList($form->values->title);
        $this->flashMessage('Seznam úkolů založen.', 'success');
        $this->redirect('Task:default', $list->id);
    }
}
