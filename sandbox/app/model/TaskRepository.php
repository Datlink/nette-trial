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

}