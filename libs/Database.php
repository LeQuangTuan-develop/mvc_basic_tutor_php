<?php 

class Database extends PDO{

	public function __construct($conn, $user, $pass) {
		
		parent::__construct($conn, $user, $pass);
	}

	public function select($sql, $data = array(), $fetchStyle = PDO::FETCH_ASSOC) {

		$stmt = $this->prepare($sql);

		foreach ($data as $key => $value) {
			$stmt->bindParam($key, $value);
		}

		$stmt->execute();
		return $stmt->fetchAll($fetchStyle);
	}

	public function insert($table, $data = array()) {

		$keys = implode(",", array_keys($data));
		$values = ":".implode(", :", array_keys($data));
		$sql = "INSERT INTO $table($keys) VALUES ($values)";
		$stmt = $this->prepare($sql);

		foreach ($data as $key => $value) {
			$stmt->bindValue(":$key", $value);
		}

		return $stmt->execute();
	}

	public function update($table, $data, $cond) {
		$updateKeys = '';
		foreach ($data as $key => $value) {
			$updateKeys .= "$key =:$key,";	
		}
		$updateKeys = rtrim($updateKeys, ',');

		$sql = "UPDATE $table SET $updateKeys WHERE $cond";
		$stmt = $this->prepare($sql);

		foreach ($data as $key => $value) {
			$stmt->bindValue(":$key", $value);
		}

		return $stmt->execute();
	}

	public function updateBySQL($sql) {
		$stmt = $this->prepare($sql);
		return $stmt->execute();
	}

	public function delete($table, $cond, $limit = 1) {
		$sql = "DELETE FROM $table WHERE $cond LIMIT $limit";
		return $this->exec($sql);
	}

	public function deleteAll($table) {
		$sql = "DELETE FROM $table";
		return $this->exec($sql);
	}

	public function countRows($sql, $email) {
		$stmt = $this->prepare($sql);
		$stmt->execute(array($email));
		return $stmt->rowCount();
	}

	public function affectedRows($sql, $email, $password) {
		$stmt = $this->prepare($sql);
		$stmt->execute(array($email, $password));
		return $stmt->rowCount();
	}

	public function selectUser($sql, $email, $password) {
		$stmt = $this->prepare($sql);
		$stmt->execute(array($email, $password));
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}

?>