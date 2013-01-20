<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Board extends Templating {

	public function action_index(){
		
		/*$boardmembers = ORM::factory('role')
			->where('id', '>', 2)
			->and_where('name', '!=', 'admin')
			->users
			->find_all();*/
		
		$boardmembers = DB::select(array('roles.name', 'title'),array('roles.email', 'titlemail'), 'users.*')
			->from('roles')
			->where('roles.id', '>', 2)
			->and_where('roles.name', '!=', 'admin')
			->join('roles_users', 'INNER')
			->on('roles_users.role_id', '=', 'roles.id')
			->join('users', 'INNER')
			->on('users.id', '=', 'roles_users.user_id')
			->order_by('roles.id', 'DESC')
			->as_object()
			->execute();
		
		$this->template->content = View::factory('board/board_index')
			->bind('boardmembers', $boardmembers)
			->bind('errors', $errors)
			->bind('values', $values);
		
		$this->assets(array(
			'css' => array('board/board_index'),
			'js' => array('documents/documents_index')
		));
	}

}