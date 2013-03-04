<?php
namespace Todo;
use Nette;

/**
 * Tabulka user
 */
class UserRepository extends Repository
{
    public function findByName($username)
    {
        return $this->findAll()->where('username', $username)->fetch();
    }
    
    // nastavení hesla
    public function setPassword($id, $password)
    {
        $this->getTable()->where(array('id' => $id))->update(array(
            'password' => \Authenticator::calculateHash($password)
        ));
    }
}