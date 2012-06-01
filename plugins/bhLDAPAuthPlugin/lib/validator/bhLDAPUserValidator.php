<?php

/* $Id: bhLDAPUserValidator.php 29730 2010-06-03 23:51:31Z Nathan.Vonnahme $ */
/* $URL: http://svn.symfony-project.com/plugins/bhLDAPAuthPlugin/branches/1.4/lib/validator/bhLDAPUserValidator.php $ */

class bhLDAPUserValidator extends sfValidatorBase
{
  public function configure($options = array(), $messages = array())
  {
    $this->addOption('username_field', 'username');
    $this->addOption('password_field', 'password');
    $this->addOption('throw_global_error', false);

    $this->setMessage('invalid', 'The username and/or password is invalid.');
  }

  protected function doClean($values)
  {
    $username = isset($values[$this->getOption('username_field')]) ? $values[$this->getOption('username_field')] : '';
    bhLDAP::debug ('######## Username: ' . $username);
    $password = isset($values[$this->getOption('password_field')]) ? $values[$this->getOption('password_field')] : '';

    bhLDAP::debug ('######## User exists?');

    $user = Doctrine::getTable('sfGuardUser')->findOneByUsername($username);
    
    bhLDAP::debugDump($user, "user:");


    if (! $user) 
    { 
      // pretend the user exists, then check AD password
      bhLDAP::debug ('######## User does not exist. Creating dummy user.');
      $user = new sfGuardUser;
      $user->setUsername($username);
      $user->setSalt('unused');
      $user->setPassword('unused');
    }
    // password is ok?
    bhLDAP::debug ('######## Checking Password...');
//    echo "<br>if-a baino lehen...";
//    if ($user->checkPassword($password))      {
    if (bhLDAP::checkPassword('uid='.$username,$password))      {
      bhLDAP::debug ('######## Check Password successful...');
      if ($user->isNew()) {
	$user->save();
	$user = Doctrine::getTable('sfGuardUser')->retrieveByUsername($username);
      }
      return array_merge($values, array('user' => $user));
    } 
    else {
      bhLDAP::debug ('######## Check Password failed...');
    }

    if ($this->getOption('throw_global_error'))
    {
      throw new sfValidatorError($this, 'invalid');
    }

    throw new sfValidatorErrorSchema($this, array($this->getOption('username_field') => new sfValidatorError($this, 'invalid')));
  }


  protected function getTable()
  {
    return Doctrine::getTable('sfGuardUser');
  }
}

//sfeof
