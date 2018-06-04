<?php  
	
	namespace AppBundle\Controller;

	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use AppBundle\Entity\User;
	use AppBundle\Entity\Role;



class UsersController extends DefaultController implements MaintenanceController{

	private function getUsers($busqueda, $activo,$pagactual=1){
		$repository = $this->getDoctrine()->getRepository(User::class);
		
		$users=$repository->getUsers(
			$this->site_config()->getElementosPagina(),
			$busqueda,
			$activo,
			$pagactual,
			$this->getUser()->getUsername()
		);

		if (!$users)
				return "no hay usuarios";
		else return $users;
	}

	public function indexAction(Request $request){
		$busqueda=$request->get('busqueda')? $request->get('busqueda') : '';
		if ($request->get('activo')!=''){$activo=$request->get('activo');}
		else{$activo='';} 
		$page=$request->get('page')? $request->get('page') : 1;
		$repository = $this->getDoctrine()->getRepository(User::class);
		$pags=ceil(($repository->activeUsersNumber($busqueda,$activo)[1]-1)/($this->site_config()->getElementosPagina()));
		$users=$this->getUsers($busqueda,$activo,$page);

		return $this->render('users/usermodule.html',array('users'=>$users,'pags'=>$pags,'busqueda'=>$busqueda,'activo'=>$activo));
	}

	public function destroyAction(Request $request){
		$username=$request->get('username');
		$manager = $this->getDoctrine()->getManager();
		$repository = $this->getDoctrine()->getRepository(User::class);
		$user = $repository->findOneByUsername($username);
		$user->setDeleted(1);
		$manager->flush();
		$resultado='El usuario fue eliminado';
		$pags=ceil(($repository->activeUsersNumber()[1])/($this->site_config()->getElementosPagina()));
		$users=$this->getUsers('','',1);
		return $this->render('users/usermodule.html',array("resultado"=>$resultado,"pags"=>$pags,"patients"=>$users));

	}

	public function addAction(Request $request){
		$repository = $this->getDoctrine()->getRepository(User::class);
		$roles_repository=$this->getDoctrine()->getRepository(Role::class);
		$roles=$roles_repository->findAll();
		$user = $repository->findOneByUsername($request->get('username'));
		return $this->render('users/useradd.html',array('roles'=>$roles));
	}

	public function insertAction(Request $request){
		$manager = $this->getDoctrine()->getManager();
		$repository = $this->getDoctrine()->getRepository(User::class);
		$roles_repository = $this->getDoctrine()->getRepository(Role::class);
		$username=$request->get('username');
		$exists_user = $repository->findOneByUsername($username);
		if (!$exists_user){
			$user=new User();
			$user->setUsername($username);
			$user->setName($request->get('name'));
			$user->setSurname($request->get('lastname'));
			$user->setEmail($request->get('email'));
			$user->setPassword(md5($request->get('password')));
			$user->setActive(1);
			$user->setDeleted(0);
			//agrego los roles
			$roles =array();
			foreach ($roles_repository->findAll() as $role){ 
				if ($request->get($role->getName()))
					array_push($roles,$role);
			}
			$user->setRoles($roles);

			// Chequea si los campos son validos
			$validator = $this->get('validator');
			$errors = $validator->validate($user);
			if (count($errors) > 0) {
				return $this->render('users/useradd.html',array('roles'=>$roles_repository->findAll(),'errors'=>$errors));
			}

			$manager->persist($user);
			$manager->flush();
			$resultado="El usuario $username fue agregado";
			$pags=ceil(($repository->activeUsersNumber()[1]-1)/($this->site_config()->getElementosPagina()));
			$users=$this->getUsers('','');
			return $this->render('users/usermodule.html',array('users'=>$users,'resultado'=>$resultado,'pags'=>$pags));
		}
		else{
			return $this->render('users/useradd.html',array('usuario'=>$user,'exists'=>true));

		}
	}

	public function updateAction(Request $request){
		$repository = $this->getDoctrine()->getRepository(User::class);
		$user = $repository->findOneByUsername($request->get('username'));
		return $this->render('users/userupdate.html',array('usuario'=>$user));

	}

	public function update_queryAction(Request $request){
		$manager = $this->getDoctrine()->getManager();
		$repository = $this->getDoctrine()->getRepository(User::class);
		$username=$request->get('actual_user');
		//chequeo si el nuevo username ya existe
		$new_username=$request->get('username');
		$exists_new_username = $repository->findOneByUsername($new_username);
		$user = $repository->findOneByUsername($username);
		if (!$exists_new_username || $new_username==$username) {
			$user->setUsername($new_username);
			$user->setName($request->get('name'));
			$user->setSurname($request->get('lastname'));
			$user->setEmail($request->get('email'));

			// Chequea si los campos son validos
			$validator = $this->get('validator');
			$errors = $validator->validate($user);
			if (count($errors) > 0) {
				return $this->render('users/userupdate.html',array('usuario'=>$user,'errors'=>$errors));
			}

			$manager->flush();
			$resultado='El usuario fue actualizado';
			$pags=ceil(($repository->activeUsersNumber()[1]-1)/($this->site_config()->getElementosPagina()));
			$users=$this->getUsers('','',1);
			return $this->render('users/usermodule.html',array('users'=>$users,'resultado'=>$resultado,'pags'=>$pags));
		}
		else{
			return $this->render('users/userupdate.html',array('usuario'=>$user,'exists'=>true));

		}
	}

	public function toggleAction (Request $request){
		$username=$request->get('username');
		$manager = $this->getDoctrine()->getManager();
		$repository = $this->getDoctrine()->getRepository(User::class);
		$user = $repository->findOneByUsername($username);
		if ($user->GetActive()=='0'){
			$user->setActive(true);
		}
		else{
			$user->setActive(false);
		}
		$manager->flush();
		if ($user->getActive()) $resultado='El usuario fue activado';
		else  $resultado='El usuario fue bloqueado'; 
		$pags=ceil(($repository->activeUsersNumber()[1])/($this->site_config()->getElementosPagina()));
		$users=$this->getUsers('','');
		return $this->render('users/usermodule.html',array("resultado"=>$resultado,"pags"=>$pags,"users"=>$users));
	}

	public function change_rolAction (Request $request){
		$repository = $this->getDoctrine()->getRepository(User::class);
		$roles_repository = $this->getDoctrine()->getRepository(Role::class);
		$username=$request->get('username');
		$user=$repository->findOneByUsername($username);
		$user_roles=$user->getRoles();
		$roles = array_udiff($roles_repository->findAll(),$user->getRawRoles(),
  				function ($role, $user_role) { return $role->getId() - $user_role->getId();} );
		return $this->render('users/usersrolupdate.html',array('username'=>$username,'roles'=>$roles,'user_roles'=>$user_roles));
	}

	public function  delete_rolAction (Request $request){
		$manager = $this->getDoctrine()->getManager();
		$repository = $this->getDoctrine()->getRepository(User::class);
		$roles_repository = $this->getDoctrine()->getRepository(Role::class);
		$role_to_delete=$request->get('role');
		$username=$request->get('username');
		$user=$repository->findOneByUsername($username);
		$role_to_delete=$roles_repository->findOneByName($role_to_delete);
		$user->removeRole($role_to_delete);
		$manager->persist($user);
		$manager->flush();
		$roles = array_udiff($roles_repository->findAll(),$user->getRawRoles(),
  				function ($role, $user_role) { return $role->getId() - $user_role->getId();} );
		return $this->render('users/usersrolupdate.html',array('username'=>$username,'roles'=>$roles,'user_roles'=>$user->getRoles()));
	}


	public function  add_rolAction (Request $request){
		$manager = $this->getDoctrine()->getManager();
		$repository = $this->getDoctrine()->getRepository(User::class);
		$roles_repository = $this->getDoctrine()->getRepository(Role::class);
		$role_to_add=$request->get('role');
		$username=$request->get('username');
		$user=$repository->findOneByUsername($username);
		$user_roles=$user->getRawRoles();
		array_push($user_roles,$roles_repository->findOneByName($role_to_add));
		$user->setRoles($user_roles);
		$manager->flush();
		$roles = array_udiff($roles_repository->findAll(),$user->getRawRoles(),
  				function ($role, $user_role) { return $role->getId() - $user_role->getId();} );
		return $this->render('users/usersrolupdate.html',array('username'=>$username,'roles'=>$roles,'user_roles'=>$user->getRoles()));
	}

	public function change_passAction(Request $request){
		$username=$request->get('username');
		return $this->render('users/userchangepass.html',array('username'=>$username));
	}

	public function change_pass_queryAction(Request $request){
		$manager = $this->getDoctrine()->getManager();
		$repository = $this->getDoctrine()->getRepository(User::class);
		$username=$request->get('username');
		$new_pass=$request->get('newpass');
		if ($new_pass && $request->get('newpassconfirm')){
			if ($request->get('newpassconfirm')==$new_pass){
				$user=$repository->findOneByUsername($username);
				$user->setPassword(md5($new_pass));
				$manager->flush();
				$respuesta="La contraseña del usuario $username fue actualizada";
				return $this->render('users/userchangepass.html',array('username'=>$username,'respuesta'=>$respuesta));
			}
			else{
				$error='Las contraseñas no coinciden';
				return $this->render('users/userchangepass.html',array('username'=>$username,'error'=>$error));

			}
		}
		else{
			$error='Los campos no pueden estar vacios';
			return $this->render('users/userchangepass.html',array('username'=>$username,'error'=>$error));
		}
	}


}
