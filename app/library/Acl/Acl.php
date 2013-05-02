<?php

namespace Vokuro\Acl;

use Phalcon\Mvc\User\Component,
	Phalcon\Acl\Adapter\Memory as AclMemory,
	Phalcon\Acl\Role as AclRole,
	Phalcon\Acl\Resource as AclResource,
	Vokuro\Models\Users,
	Vokuro\Models\Profiles;

/**
 * Vokuro\Acl\Acl
 *
 *
 */
class Acl extends Component
{

	private $_acl;

	private $_privateResources = array(
		'users' => array('index', 'search', 'edit', 'create', 'delete'),
		'profiles' => array('index', 'search', 'edit', 'create', 'delete'),
		'permissions' => array('index')
	);

	private $_actionDescriptions = array(
		'index' => 'Access',
		'search' => 'Search',
		'create' => 'Create',
		'edit' => 'Edit',
		'delete' => 'Delete'
	);

	/**
	 * Checks if a controller is private or not
	 *
	 * @param string $controllerName
	 * @return boolean
	 */
	public function isPrivate($controllerName)
	{
		return isset($this->_privateResources[$controllerName]);
	}

	/**
	 * Checks if the current profile is allowed to access a resource
	 *
	 * @param string $profile
	 * @param string $controller
	 * @param string $action
	 * @return boolean
	 */
	public function isAllowed($profile, $controller, $action)
	{
		return $this->getAcl()->isAllowed($profile, $controller, $action);
	}

	/**
	 * Returns the ACL list
	 *
	 * @return Phalcon\Acl\Adapter\Memory
	 */
	public function getAcl()
	{
		if (is_object($this->_acl)) {
			return $this->_acl;
		}

		if (!file_exists(__DIR__ . '/../../cache/acl/data')) {
			$this->_acl = $this->rebuild();
			return $this->_acl;
		}

		$data = file_get_contents(__DIR__ . '/../../cache/acl/data');
		$this->_acl = unserialize($data);
		return $this->_acl;
	}

	/**
	 *
	 */
	public function getPermissions(Profiles $profile)
	{
		$permissions = array();
		foreach ($profile->getPermissions() as $permission) {
			$permissions[$permission->resource . '.' . $permission->action] = true;
		}
		return $permissions;
 	}

 	/**
 	 * Returns all the resoruces and their actions available in the application
 	 *
 	 * @return array
 	 */
	public function getResources()
	{
		return $this->_privateResources;
	}

	/**
	 * Returns the action description according to its simplified name
	 *
	 * @param string $action
	 * @return $action
	 */
	public function getActionDescription($action)
	{
		if (isset($this->_actionDescriptions[$action])) {
			return $this->_actionDescriptions[$action];
		} else {
			return $action;
		}
	}

	/**
	 * Rebuils the access list into a file
	 *
	 */
	public function rebuild()
	{
		$acl = new AclMemory();

		$acl->setDefaultAction(\Phalcon\Acl::DENY);

		//Register roles
		$profiles = Profiles::find('active = "Y"');

		foreach ($profiles as $profile) {
			$acl->addRole(new AclRole($profile->name));
		}

		foreach ($this->_privateResources as $resource => $actions) {
			$acl->addResource(new AclResource($resource), $actions);
		}

		//Grant acess to private area to role Users
		foreach ($profiles as $profile) {
			foreach ($profile->getPermissions() as $permission) {
				$acl->allow($profile->name, $permission->resource, $permission->action);
			}
		}

		file_put_contents(__DIR__ . '/../../cache/acl/data', serialize($acl));

		return $acl;
	}

}