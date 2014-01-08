<?php

// $Id: bhLDAP.php 29561 2010-05-20 20:06:36Z Nathan.Vonnahme $
// $URL: http://svn.symfony-project.com/plugins/bhLDAPAuthPlugin/branches/1.4/lib/bhLDAP.php $
require_once 'adLDAP.php';


class bhLDAP
{
  protected static $ldap = null;
  protected static $config = null;

  public static function getLDAP()
  {
    if (self::$ldap === null) {  // memoization
      $c = self::getConfig();
      self::$ldap = new adLDAP($c['adLDAP']);
      self::debugDump(self::$ldap, 'configured adLDAP object');

    }
    return self::$ldap;
  }


  public static function getConfig()
  {
    if (self::$config === null) {  // memoization
      $config = sfYaml::load(sfConfig::get('sf_config_dir').'/LDAPAuth.yml');
      self::debugDump($config, 'original parsed yaml');

      self::$config = $config;
    }
    return self::$config;
  }


  public static function checkPassword($username, $password)
  {
    self::debug("########  hello bhLDAP::checkPassword()!");

    $return = self::getLDAP()->authenticate($username,$password);
    self::debug( "$username password OK? [$return]");

    # authz takes place in apps/frontend/lib/myUser.class.php,
    # which points to this plugin's lib/user/bhLDAPAuthSecurityUser.class.php

    return $return;

  }


  # this works around a PHP_NOTICE error in adLDAP's user_groups function
  public static function getUserGroups ($username, $recursive=NULL) {
    $ldap = self::getLDAP();

   $groups=array();

   self::debugDump($ldap->_recursive_groups, "_recursive_groups setting");
   self::debugDump($recursive, "passed in \$recursive var");


    if ( $recursive === NULL ) {
      //use the default option if they haven't set it
      self::debug("using recursive option (".$ldap->_recursive_groups.") from config file or default config");
      $recursive=$ldap->_recursive_groups;
    }

    self::debug("getting group memberships for $username");
    $filter="samaccountname=".$username;
    $fields=array("memberof", "primarygroupid");

    $sr=@ldap_search($ldap->_conn,$ldap->_base_dn,$filter,$fields);
    if ($sr)
    {

        $entries = @ldap_get_entries($ldap->_conn, $sr);
        if (array_key_exists(0, $entries))
        {
            self::debugDump($entries, "group entries for $username");

            if (array_key_exists('memberof', $entries[0]))
                $groups = $entries[0]['memberof'];
            else
                $groups = array();

            if (array_key_exists('primarygroupid', $entries[0]))
            {
                $primaryGroup = $ldap->group_cn($entries[0]['primarygroupid'][0]);
                array_push($groups, $primaryGroup);
                $groups["count"]++;
            }

            $groups = $ldap->nice_names($groups);
            if ($recursive){
              self::debug("checking recursive group memberships");
              foreach ($groups as $id => $group_name){
	        self::debug("recursing down into $group_name");
	        $extra_groups=@$ldap->recursive_groups($group_name);
	        $groups=array_unique(array_merge($groups,$extra_groups));
              }
              self::debugDump($groups, "fully recursive list of groups for $username");
            }
        }
    }

    # LDAP
    $filter="(objectClass=posixGroup)";
    $fields=array("cn","memberUid");

    $sr=@ldap_search($ldap->_conn,$ldap->_base_dn,$filter,$fields);
    if ($sr)
    {
        $entries = @ldap_get_entries($ldap->_conn, $sr);
        if ((array_key_exists(0, $entries)))
        {
            $extra_groups=array();
            foreach ($entries as $entry)
            {
                if (($entry['count']!=0))
	        {
	            foreach ($entry['memberuid'] as $kidea)
	            {
                        if (strtolower($username)==strtolower($kidea))
			{
			    foreach ($entry['cn'] as $cn)
			        array_push($extra_groups,$cn);

			    break;
			}
                    }
                }
            }
            $groups=array_unique(array_merge($groups,$extra_groups));
        }
    }

    return $groups;
  }

  # all lowercase, for case-insensitive matching
  public static function getUserGroupsLC ($username, $recursive=NULL) {
    $g = self::getUserGroups($username, $recursive);
    return array_map("strtolower", $g);
  }

  public static function getUserCredentials($user)
  {
    $credentials = array();
    //    self::debugDump($user, "user");
    $username = $user->getUsername();

    $ldap = self::getLDAP();
    self::debug("looking up user groups for $username");

    // look up credentials using AD groups
    $memberships = self::getUserGroupsLC($username);

    $c = self::getConfig();
    foreach ($c['groupMappings'] as $credential => $ad_groups) {
      foreach ($ad_groups as $group) {
#	if (@$ldap->user_ingroup($username, $group, false)) {
	if ( in_array(strtolower($group), $memberships) ) {
	  $credentials[] = $credential;
	  continue 2;
	}
      }
    }

    self::debugDump($credentials, "credentials for $username");

    return $credentials;
  }

  /*
   * Cargar nombre de usuario y e-mail desde LDAP
   */
  public static function fillUserInfo($user)
  {
	$ldap = self::getLDAP();

	$filter = "(|(samaccountname=" . $user->getUsername() . ")(uid=" . $user->getUsername() . "))";
	$fields = array("mail", "givenName", "sn");

	$sr = @ldap_search($ldap->_conn, $ldap->_base_dn, $filter, $fields);
	if (!$sr)
		return;

	$entries = @ldap_get_entries($ldap->_conn, $sr);
	if ($entries['count'] == 0)
		return;

	self::debug("Dump user info: " . var_export($entries, true));

	foreach ($entries[0] as $key => $entry)
	{
		if (is_array($entry))
			$valor = $entry[0];
		else
			$valor = $entry;

		// convertirlo en string para evitar problemas con las comparaciones con numericos
		switch ((string)$key)
		{
			// deben estar en minusculas, ya que PHP devuelve todos los atributos
			// de LDAP esta forma
			case "givenname":
				self::debug("First Name: " . $valor);
				$user->setFirstName($valor);
				break;
			case "sn":
				self::debug("Last Name: " . $valor);
				$user->setLastName($valor);
				break;
			case "mail":
				self::debug("Email Address: " . $valor);
				$user->setEmailAddress($valor);
				break;
		}
	}
  }

  /**
   * Print a string to the log using 'debug' level.  For printf-style
   * debugging.
   *
   * @param      string $m      The string to log
   * @return     nothing
   */
  public static function debug ($m) {
    if (sfConfig::has('sf_logging_enabled') && sfConfig::get('sf_logging_enabled'))
      {
	if ($logger = sfContext::getInstance()->getLogger()) {
	  $logger->debug($m);
	}
      }
    elseif (sfConfig::has('bhLDAP_echo_debugging') && sfConfig::get('bhLDAP_echo_debugging'))
      {
	echo "# $m\n";
      }
    else
      {
// 	echo $m;
      }
  }

  /**
   * Dump a data structure to the log at the 'debug' level.
   * Recursively dumps $levels_to_recurse nested levels of arrays.
   * Dumps only the first level of objects.
   *
   * @param      mixed $v         The variable/data structure to dump
   * @param      string $label    An optional label to print in front of the dump
   * @param      int $levels_to_recurse       Maximum levels to recurse.  Default = 3.
   * @return     nothing
   */
  public static function debugDump ($v, $label = "var dump", $levels_to_recurse = 3) {
    // 2010-05-20 - disabled print_r because it causes horrible problems with symfony objects under sf1.4/php5.3 .

    self::debug("$label: dumping variable of type '" . gettype($v) . "'" .
		(is_object($v)?" (".get_class($v).")":"") );

    if (is_array($v) || is_object($v)) {
       foreach ($v as $key => $value) {
	 if (is_array($value) && $levels_to_recurse > 0) {
	   self::debugDump($value, "$label>$key", $levels_to_recurse - 1);
	 }
	 else {
	   self::debug("$label:    $key => $value\n");
	 }
       }
    }
    else {
      self::debug("$label:  variable => $v");
    }

  }



}

//sfeof
