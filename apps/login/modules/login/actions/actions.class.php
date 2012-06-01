<?php

/**
 * login actions.
 *
 * @package    gerkud
 * @subpackage login
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class loginActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {

	$user = $this->getUser();
	$ldap = bhLDAP::getLDAP();
        $taldeak=bhLDAP::getUserGroups($user->getUsername(),'FALSE');
//	print_r($taldeak);
//	if (array_search('admins. del dominio',$taldeak))
	if (in_array('domain administrators,ou=groups,dc=gerkud,dc=example',$taldeak))
	{
//		echo "<br><br>Informatika taldekoa da<br>";
                $this->redirect(sfConfig::get('app_url_admin'));

//        }else if (array_search('gerkud',$taldeak))
	}else if (in_array('gerkud,ou=groups,dc=gerkud,dc=example',$taldeak))
        {
//                echo "<br><br>Aplikazioaren administrari taldekoa da<br>";
                $this->redirect(sfConfig::get('app_url_admin'));

//        }else if (array_search('zerbitzuak',$taldeak))
	}else if (in_array('zerbitzuak,ou=groups,dc=gerkud,dc=example',$taldeak))
        {
//		echo "<br><br>Zerbitzuetako langilea da!!<br>";
                $this->redirect(sfConfig::get('app_url_zerbitzu'));
	}
//	if (array_search('domain users',$taldeak))
//	else if ($taldeak[0]=='domain users')
//        else if ($taldeak[0]=='domain users,ou=grupos,dc=gerkud,dc=net')
	else if (in_array('domain users,ou=groups,dc=gerkud,dc=example',$taldeak))
	{
//		echo "Erabiltzaile arrunta da!!<br>";
		$this->redirect(sfConfig::get('app_url_orokorra'));
	}else 
	{
		echo "Ez dago inolako taldetan sartuta!!!<br>";
	}
  }
}
