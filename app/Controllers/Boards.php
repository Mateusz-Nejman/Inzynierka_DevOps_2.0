<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use stdClass;

class Boards extends BaseController
{
	private $db;

	public function __construct()
	{
		$this->db = \Config\Database::connect();
		$this->loggedAccess();
	}

	public function index($link = "")
	{
		return showPage("board_index", ["logged" => true], [
			createModal("Nowe zadanie", "newTask", "board_new_task"),
			createModal("Edytuj zadanie", "editTask", "board_edit_task"),
			createModal("Użytkownicy", "boardUsers", "board_users")
		], ["boards.js"]);
	}

	public function getData()
	{
		if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

		$userData = getLoggedUserData();

		$boardId = intval($this->request->getVar("boardId"));

		if ($boardId == 0) {
			return $this->response->setJSON(["state" => 0, "message" => "Błąd serwera. Kod #BS001"]);
		}
		$columns = [];

		$board = $this->db->table("boards")->where("archive", 0)->where("id", $boardId)->get()->getRow();

		if ($board == null) {
			return $this->response->setJSON(["state" => 0, "message" => "Błąd serwera. Kod #BS002"]);
		}

		if (!$this->hasUserAccessToBoard($userData->id, $boardId, false)) {
			return $this->response->setJSON(["state" => 0, "message" => "Brak dostępu"]);
		}

		$userBoard = $this->db->table("userBoards")->where("userId", $userData->id)->where("boardId", $boardId)->get()->getRow();

		$columnsQuery = $this->db->table("boardColumns")->where("boardId", $boardId)->where("archive", 0)->orderBy("showOrder", "asc")->get()->getResult();

		$userIds = [];
		$usersData = [];

		foreach ($columnsQuery as $column) {
			$object = new stdClass();
			$object->id = $column->id;
			$object->name = $column->name;
			$object->tasks = [];

			$tasksQuery = $this->db->table("boardItems")->where("columnId", $column->id)->where("archive", 0)->orderBy("showOrder", "asc")->get()->getResult();

			foreach ($tasksQuery as $task) {
				$taskObject = new stdClass();
				$taskObject->id = $task->id;
				$taskObject->name = $task->name;
				$taskObject->assignedTo = $task->assignedTo;
				$taskObject->priority = $task->priority;

				if (in_array($task->assignedTo, $userIds)) {
					$index = array_search($task->assignedTo, $userIds);

					$taskObject->email = $usersData[$index]->email;
				} else {
					$user = $this->db->table("users")->where("id", $task->assignedTo)->get()->getRow();
					$userIds[] = $task->assignedTo;
					$usersData[] = $user;
					$taskObject->email = $user->email;
				}

				$object->tasks[] = $taskObject;
			}
			$columns[] = $object;
		}

		return $this->response->setJSON(["columns" => $columns, "name" => $board->name, "role" => $userBoard->role]);
	}

	public function changeTasksOrder()
	{
		if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

		$ids = $this->request->getVar("ids");

		if (!is_array($ids)) {
			return $this->response->setJSON(["state" => 0, "message" => "Błąd serwera. Kod #BS004"]);
		}

		$this->changeTasksOrderIds($ids);

		return $this->response->setJSON(["state" => 0, "message" => "Pomyślnie przeniesiono"]);
	}

	public function moveTaskTo()
	{
		if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

		$userData = getLoggedUserData();
		$columnId = intval($this->request->getVar("columnId"));
		$ids = $this->request->getVar("ids");
		$taskId = intval($this->request->getVar("taskId"));

		if ($columnId == 0 || !is_array($ids) || $taskId == 0) {
			return $this->response->setJSON(["state" => 0, "message" => "Błąd serwera. Kod #BS005"]);
		}

		if (!$this->hasUserAccessToTask($userData->id, $taskId, true)) {
			return $this->response->setJSON(["state" => 0, "message" => "Brak dostępu"]);
		}

		$this->db->table("boardItems")->where("id", $taskId)->update(["columnId" => $columnId]);

		$this->changeTasksOrderIds($ids);

		return $this->response->setJSON(["state" => 0, "message" => "Pomyślnie przeniesiono"]);
	}

	public function changeColumnsOrder()
	{
		if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

		$ids = $this->request->getVar("ids");

		if (!is_array($ids)) {
			return $this->response->setJSON(["state" => 0, "message" => "Błąd serwera. Kod #BS006"]);
		}

		$this->changeColumnsOrderIds($ids);

		return $this->response->setJSON(["state" => 0, "message" => "Pomyślnie zmieniono"]);
	}

	public function createColumn()
	{
		if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

		$userData = getLoggedUserData();
		$boardId = intval($this->request->getVar("boardId"));
		$name = $this->request->getVar("name");

		if ($boardId == 0 || strlen(trim($name)) == 0) {
			return $this->response->setJSON(["state" => 0, "message" => "Błąd serwera. Kod #BS007"]);
		}

		if (!$this->hasUserAccessToBoard($userData->id, $boardId, true)) {
			return $this->response->setJSON(["state" => 0, "message" => "Brak dostępu"]);
		}

		$lastColumn = $this->db->table("boardColumns")->where("boardId", $boardId)->orderBy("showOrder", "desc")->get()->getRow();

		$this->db->table("boardColumns")->insert([
			"boardId" => $boardId,
			"name" => $name,
			"showOrder" => $lastColumn == null ? 0 : $lastColumn->showOrder + 1,
			"archive" => 0
		]);

		$column = $this->db->table("boardColumns")->where("boardId", $boardId)->where("name", $name)->orderBy('id', 'desc')->get()->getRow();

		$object = new stdClass();
		$object->id = $column->id;
		$object->name = $column->name;
		$object->tasks = [];

		return $this->response->setJSON(["state" => 0, "message" => "Pomyślnie stworzono", "data" => $object]);
	}

	public function createTask()
	{
		if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

		$userData = getLoggedUserData();
		$columnId = intval($this->request->getVar("columnId"));
		$name = $this->request->getVar("name");
		$description = $this->request->getVar("description");
		$assignedTo = intval($this->request->getVar("assignedTo"));
		$priority = intval($this->request->getVar("priority"));

		if ($columnId == 0 || strlen(trim($name)) == 0 || $assignedTo == 0 || $priority < 0 || $priority > 4) {
			return $this->response->setJSON(["state" => 0, "message" => "Błąd serwera. Kod #BS008"]);
		}

		if (!$this->hasUserAccessToColumn($userData->id, $columnId, true)) {
			return $this->response->setJSON(["state" => 0, "message" => "Brak dostępu"]);
		}

		$lastTask = $this->db->table("boardItems")->where("columnId", $columnId)->orderBy("showOrder", "desc")->get()->getRow();

		$this->db->table("boardItems")->insert([
			"columnId" => $columnId,
			"name" => $name,
			"description" => $description,
			"createdBy" => $userData->id,
			"assignedTo" => $assignedTo,
			"showOrder" => $lastTask == null ? 0 : $lastTask->showOrder + 1,
			"priority" => $priority
		]);

		$task = $this->db->table("boardItems")->where("columnId", $columnId)->where("name", $name)->orderBy('id', 'desc')->get()->getRow();

		$object = new stdClass();
		$object->id = $task->id;
		$object->name = $task->name;
		$object->userId = $userData->id;
		$object->email = $userData->email;
		$object->priority = $task->priority;

		return $this->response->setJSON(["state" => 0, "message" => "Pomyślnie stworzono", "data" => $object]);
	}

	public function editTask()
	{
		if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

		$userData = getLoggedUserData();
		$id = intval($this->request->getVar("id"));
		$name = $this->request->getVar("name");
		$description = $this->request->getVar("description");
		$assignedTo = intval($this->request->getVar("assignedTo"));
		$priority = intval($this->request->getVar("priority"));

		if ($id == 0 || strlen(trim($name)) == 0 || $assignedTo == 0 || $priority < 0 || $priority > 4) {
			return $this->response->setJSON(["state" => 0, "message" => "Błąd serwera. Kod #BS009"]);
		}

		if (!$this->hasUserAccessToTask($userData->id, $id, true)) {
			return $this->response->setJSON(["state" => 0, "message" => "Brak dostępu"]);
		}

		$this->db->table("boardItems")->where("id", $id)->update([
			"name" => $name,
			"description" => $description,
			"assignedTo" => $assignedTo,
			"priority" => $priority
		]);

		$object = new stdClass();
		$object->id = $id;
		$object->name = $name;

		return $this->response->setJSON(["state" => 0, "message" => "Pomyślnie edytowano", "data" => $object]);
	}

	public function getTask()
	{
		if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

		$userData = getLoggedUserData();
		$id = intval($this->request->getVar("id"));

		if ($id == 0) {
			return $this->response->setJSON(["state" => 0, "message" => "Błąd serwera. Kod #BS010"]);
		}

		if (!$this->hasUserAccessToTask($userData->id, $id, false)) {
			return $this->response->setJSON(["state" => 0, "message" => "Brak dostępu"]);
		}

		$taskRaw = $this->db->table("boardItems")->where("id", $id)->get()->getRow();

		if ($taskRaw == null) {
			return $this->response->setJSON(["state" => 0, "message" => "Błąd serwera. Kod #BS011"]);
		}

		$object = new stdClass();
		$object->id = $id;
		$object->name = $taskRaw->name;
		$object->description = $taskRaw->description;
		$object->assignedTo = $taskRaw->assignedTo;
		$object->priority = $taskRaw->priority;

		$comments = [];

		$commentsRaw = $this->db->table("boardItemComments")->where("itemId", $id)->get()->getResult();

		foreach ($commentsRaw as $comment) {
			$user =  $this->db->table("users")->where("id", $comment->createdBy)->get()->getRow();
			$comment->email = $user == null ? "Unknown" : $user->email;
			$comments[] = $comment;
		}

		return $this->response->setJSON(["data" => $object, "comments" => $comments]);
	}

	public function archiveColumn()
	{
		if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

		$userData = getLoggedUserData();
		$id = intval($this->request->getVar("id"));

		if ($id == 0) {
			return $this->response->setJSON(["state" => 0, "message" => "Błąd serwera. Kod #BS012"]);
		}

		if (!$this->hasUserAccessToColumn($userData->id, $id, true)) {
			return $this->response->setJSON(["state" => 0, "message" => "Brak dostępu"]);
		}

		$this->db->table("boardColumns")->where("id", $id)->update([
			"archive" => 1
		]);

		return $this->response->setJSON(["state" => 0, "message" => "Pomyślnie zarchiwizowano"]);
	}

	public function archiveTask()
	{
		if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

		$userData = getLoggedUserData();
		$id = intval($this->request->getVar("id"));

		if ($id == 0) {
			return $this->response->setJSON(["state" => 0, "message" => "Błąd serwera. Kod #BS013"]);
		}

		if (!$this->hasUserAccessToTask($userData->id, $id, true)) {
			return $this->response->setJSON(["state" => 0, "message" => "Brak dostępu"]);
		}

		$this->db->table("boardItems")->where("id", $id)->update([
			"archive" => 1
		]);

		return $this->response->setJSON(["state" => 0, "message" => "Pomyślnie zarchiwizowano"]);
	}

	public function changeColumnName()
	{
		if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

		$userData = getLoggedUserData();
		$id = intval($this->request->getVar("id"));
		$name = $this->request->getVar("name");

		if ($id == 0 || strlen(trim($name)) == 0) {
			return $this->response->setJSON(["state" => 0, "message" => "Błąd serwera. Kod #BS014"]);
		}

		if (!$this->hasUserAccessToColumn($userData->id, $id, true)) {
			return $this->response->setJSON(["state" => 0, "message" => "Brak dostępu"]);
		}

		$this->db->table("boardColumns")->where("id", $id)->update(["name" => $name]);

		return $this->response->setJSON(["state" => 0, "message" => "Successfully changed"]);
	}

	public function changeBoardName()
	{
		if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

		$userData = getLoggedUserData();
		$id = intval($this->request->getVar("id"));
		$name = $this->request->getVar("name");

		if ($id == 0 || strlen(trim($name)) == 0) {
			return $this->response->setJSON(["state" => 0, "message" => "Błąd serwera. Kod #BS015"]);
		}

		if (!$this->hasUserAccessToBoard($userData->id, $id, true, 1)) {
			return $this->response->setJSON(["state" => 0, "message" => "Brak dostępu"]);
		}

		$this->db->table("boards")->where("id", $id)->update(["name" => $name]);

		return $this->response->setJSON(["state" => 0, "message" => "Pomyślnie edytowano"]);
	}

	public function getUserBoards()
	{
		if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}
		$userData = getLoggedUserData();
		$userBoards = $this->db->table("userBoards")->where("userId", $userData->id)->get()->getResult();
		$boardIds = [];

		foreach ($userBoards as $userBoard) {
			$boardIds[] = $userBoard->boardId;
		}

		$boards = $this->db->table("boards")->where("archive", 0)->whereIn("id", $boardIds)->get()->getResult();

		foreach($boards as $board)
		{
			$columns = $this->db->table("boardColumns")->where("boardId", $board->id)->where("archive", 0)->get()->getResult();
			$columnIds = [];

			foreach($columns as $column)
			{
				$columnIds[] = $column->id;
			}

			$boardItems = $this->db->table("boardItems")->whereIn("columnId", $columnIds)->where("archive", 0)->get()->getResult();

			$board->taskCount = count($boardItems);
		}

		return $this->response->setJSON(["data" => $boards]);
	}

	public function createBoard()
	{
		if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

		$name = $this->request->getVar("name");

		if (strlen(trim($name)) == 0) {
			return $this->response->setJSON(["state" => 0, "message" => "Błąd serwera. Kod #BS016"]);
		}

		$this->db->table("boards")->insert(["name" => $name]);

		$lastBoard = $this->db->table("boards")->orderBy("id", "desc")->limit(1)->get()->getRow();

		$userData = getLoggedUserData();

		$this->db->table("userBoards")->insert([
			"userId" => $userData->id,
			"boardId" => $lastBoard->id,
			"role" => 1
		]);

		return $this->response->setJSON(["data" => $lastBoard]);
	}

	public function assignTask()
	{
		if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

		$userData = getLoggedUserData();
		$taskId = intval($this->request->getVar("taskId"));
		$assignedTo = intval($this->request->getVar("assignedTo"));

		if ($taskId == 0 || $assignedTo == 0) {
			return $this->response->setJSON(["state" => 0, "message" => "Błąd serwera. Kod #BS017"]);
		}

		if (!$this->hasUserAccessToTask($userData->id, $taskId, true)) {
			return $this->response->setJSON(["state" => 0, "message" => "Brak dostępu"]);
		}

		$this->db->table("boardItems")->where("id", $taskId)->update(["assignedTo" => $assignedTo]);

		return $this->response->setJSON(["state" => 0, "message" => "Successfully assigned"]);
	}

	public function getBoardUsers()
	{
		if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

		$userData = getLoggedUserData();
		$boardId = intval($this->request->getVar("id"));

		if ($boardId == 0) {
			return $this->response->setJSON(["state" => 0, "message" => "Błąd serwera. Kod #BS018"]);
		}

		if (!$this->hasUserAccessToBoard($userData->id, $boardId, true, 1)) {
			return $this->response->setJSON(["state" => 0, "message" => "Brak dostępu"]);
		}

		$boardUsers = $this->db->table("userBoards")->where("boardId", $boardId)->get()->getResult();
		$userIds = [];
		$userRoles = [];

		foreach ($boardUsers as $boardUser) {
			$userIds[] = $boardUser->userId;
			$userRoles[$boardUser->userId] = $boardUser->role;
		}

		$users = $this->db->table("users")->whereIn("id", $userIds)->select("id, email")->get()->getResult();

		foreach ($users as $user) {
			$user->role = $userRoles[$user->id];
		}

		return $this->response->setJSON(["data" => $users]);
	}

	public function getUsers()
	{
		if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

		$users = $this->db->table("users")->select("id, email")->get()->getResult();

		return $this->response->setJSON(["data" => $users]);
	}

	public function addUserToBoard()
	{
		if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

		$userData = getLoggedUserData();
		$boardId = intval($this->request->getVar("id"));
		$userId = intval($this->request->getVar("userId"));
		$role = intval($this->request->getVar("role"));

		if ($boardId == 0 || $userId == 0) {
			return $this->response->setJSON(["state" => 0, "message" => "Błąd serwera. Kod #BS019"]);
		}

		if (!$this->hasUserAccessToBoard($userData->id, $boardId, true, 1)) {
			return $this->response->setJSON(["state" => 0, "message" => "Brak dostępu"]);
		}

		$checkExists = $this->db->table("userBoards")->where("userId", $userId)->where("boardId", $boardId)->get()->getRow() != null;

		if ($checkExists) {
			return $this->response->setJSON(["state" => 2, "message" => "Użytkownik jest już przypisany do tablicy"]);
		}

		$this->db->table("userBoards")->insert([
			"userId" => $userId,
			"boardId" => $boardId,
			"role" => $role
		]);

		return $this->response->setJSON(["state" => 0, "message" => "Pomyślnie przypisano"]);
	}

	public function changeUserBoard()
	{
		if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

		$userData = getLoggedUserData();
		$boardId = intval($this->request->getVar("id"));
		$userId = intval($this->request->getVar("userId"));
		$role = intval($this->request->getVar("role"));

		if ($boardId == 0 || $userId == 0) {
			return $this->response->setJSON(["state" => 0, "message" => "Błąd serwera. Kod #BS020"]);
		}

		if (!$this->hasUserAccessToBoard($userData->id, $boardId, true, 1)) {
			return $this->response->setJSON(["state" => 0, "message" => "Brak dostępu"]);
		}

		$this->db->table("userBoards")->where("userId", $userId)->where("boardId", $boardId)->update([
			"role" => $role
		]);

		return $this->response->setJSON(["state" => 0, "message" => "Pomyślnie zmieniono"]);
	}

	public function removeUserFromBoard()
	{
		if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

		$userData = getLoggedUserData();
		$boardId = intval($this->request->getVar("id"));
		$userId = intval($this->request->getVar("userId"));

		if ($boardId == 0 || $userId == 0) {
			return $this->response->setJSON(["state" => 0, "message" => "Błąd serwera. Kod #BS021"]);
		}

		if (!$this->hasUserAccessToBoard($userData->id, $boardId, true, 1)) {
			return $this->response->setJSON(["state" => 0, "message" => "Brak dostępu"]);
		}

		$this->db->table("userBoards")->where("userId", $userId)->where("boardId", $boardId)->delete();

		return $this->response->setJSON(["state" => 0, "message" => "Pomyślnie usunięto", "selfRemove" => $userData->id == $userId]);
	}

	public function createComment()
	{
		if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

		$id = intval($this->request->getVar("id"));
		$content = $this->request->getVar("content");
		$date = $this->request->getVar("date");
		$userData = getLoggedUserData();

		if ($id == 0 || strlen(trim($content)) == 0 || strlen(trim($date)) == 0) {
			return $this->response->setJSON(["state" => 0, "message" => "Błąd serwera. Kod #BS022"]);
		}

		if (!$this->hasUserAccessToTask($userData->id, $id, true)) {
			return $this->response->setJSON(["state" => 0, "message" => "Brak dostępu"]);
		}

		$this->db->table("boardItemComments")->insert(["itemId" => $id, "createdBy" => $userData->id, "date" => $date, "content" => $content]);

		$data = new stdClass();
		$data->email = $userData->email;
		$data->date = $date;
		$data->content = $content;

		return $this->response->setJSON(["state" => 0, "message" => "Dodano komentarz", "data" => $data]);
	}

	public function archiveBoard()
	{
		if (!$this->checkValidRequest($this->request)) {
			return $this->getInvalidResponse($this->response);
		}

		$userData = getLoggedUserData();
		$id = intval($this->request->getVar("id"));

		if (!$this->hasUserAccessToBoard($userData->id, $id, true)) {
			return $this->response->setJSON(["state" => 0, "message" => "Brak dostępu"]);
		}

		$this->db->table("boards")->where("id", $id)->update([
			"archive" => 1
		]);

		return $this->response->setJSON(["state" => 0, "message" => "Pomyślnie zarchiwizowano"]);
	}

	private function changeColumnsOrderIds(array $ids)
	{
		foreach ($ids as $index => $columnId) {
			$this->db->table("boardColumns")->where("id", $columnId)->update([
				"showOrder" => $index
			]);
		}
	}

	private function changeTasksOrderIds(array $ids)
	{
		foreach ($ids as $index => $taskId) {
			$this->db->table("boardItems")->where("id", $taskId)->update([
				"showOrder" => $index
			]);
		}
	}

	private function hasUserAccessToBoard(int $userId, int $boardId, bool $checkRole, int $role = 0)
	{
		$userBoard = $this->db->table("userBoards")->where("userId", $userId)->where("boardId", $boardId)->get()->getRow();

		if ($userBoard == null) {
			return false;
		}

		if ($checkRole) {
			if ($role > 0) {
				return $userBoard->role == $role;
			}

			return $userBoard->role == 1 || $userBoard->role == 2;
		}

		return true;
	}

	private function hasUserAccessToColumn(int $userId, int $columnId, bool $checkRole, int $role = 0)
	{
		$column = $this->db->table("boardColumns")->where("id", $columnId)->get()->getRow();

		if ($column == null) {
			return false;
		}

		return $this->hasUserAccessToBoard($userId, $column->boardId, $checkRole, $role);
	}

	private function hasUserAccessToTask(int $userId, int $taskId, bool $checkRole, int $role = 0)
	{
		$task = $this->db->table("boardItems")->where("id", $taskId)->get()->getRow();

		if ($task == null) {
			return false;
		}

		return $this->hasUserAccessToColumn($userId, $task->columnId, $checkRole, $role);
	}
}
