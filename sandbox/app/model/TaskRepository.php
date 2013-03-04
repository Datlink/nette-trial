<?php
namespace Todo;
use Nette;

/**
 * Tabulka task
 */
class TaskRepository extends Repository
{

    public function findIncomplete()
    {
        return $this->findBy(array('done' => false))->order('created ASC');
    }
    
    public function createTask($listId, $task, $assignedUser)
    {
        return $this->getTable()->insert(array(
            'text' => $task,
            'user_id' => $assignedUser,
            'created' => new \DateTime(),
            'list_id' => $listId
        ));
    }
    
    // označení úkolu jako hotový
    public function markDone($id)
    {
        $this->findBy(array('id' => $id))->update(array('done' => 1));
    }
    
    // najít nekompletní úkoly podle uživatele
    public function findIncompleteByUser($userId)
    {
        return $this->findIncomplete()->where(array('user_id' => $userId));
    }

}