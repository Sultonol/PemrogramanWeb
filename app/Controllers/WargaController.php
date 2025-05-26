<?php
require_once __DIR__ . '/../Models/User.php';

class WargaController
{
	private $model;

	public function __construct()
	{
		$this->model = new User();
	}

	public function index()
	{
		$data = $this->model->getAllWarga();
		include __DIR__ . '/../Views/data_warga.php';
	}

	public function update()
	{
		$warga_id = $_POST['warga_id'];
		$roles = $_POST['role'] ?? [];
		if (!is_array($roles)) {
			$roles = [$roles];
		}
		$role_string = implode(',', $roles);
		$this->model->updateRole($warga_id, $role_string);
		header('Location: index.php?page=dashboard&subpage=warga&msg=success');
		exit;
	}



	public function delete()
	{
		$warga_id = $_POST['warga_id'];
		$this->model->deleteWarga($warga_id);

		header('Location: index.php?page=data_warga&msg=success');
		exit;
	}
}
