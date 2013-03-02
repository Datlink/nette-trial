<?php
namespace Todo;
use Nette;

/**
 * Tabulka list
 */
class ListRepository extends Repository
{
    public function find($id)
    {
        return $this->findBy(array('id' => $id))->fetch();
    }
    public function tasksOf(Nette\Database\Table\ActiveRow $list)
    {
        return $list->related('task')->order('created');
    }
}