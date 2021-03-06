<?php
$clsVote = new Vote();
class Vote{

	private $table = "vote";

	public function Vote(){}

	public function Add($mdl){

		$Database = new Database();
		$conn = $Database->GetConn();

		$sql = "INSERT INTO `".$this->table."`
				(
          `Election_Id`,
          `Candidate_Id`,
          `User_Id`
				) VALUES (
          '".$mdl->getsqlElection_Id()."',
          '".$mdl->getsqlCandidate_Id()."',
          '".$mdl->getsqlUser_Id()."'
				)";

		$result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$id = mysqli_insert_id($conn);

		mysqli_close($conn);

		return $id;
	}

	public function Update($mdl){

		$Database = new Database();
		$conn = $Database->GetConn();

		$sql="UPDATE `".$this->table."` SET
      `Election_Id`='".$mdl->getsqlElection_Id()."',
      `Candidate_Id`='".$mdl->getsqlCandidate_Id()."',
			`User_Id`='".$mdl->getsqlUser_Id()."'
			WHERE `Vote_Id`='".$mdl->getsqlId()."'";
		$result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

		mysqli_close($conn);
	}

	public function Delete($id){

		$Database = new Database();
		$conn = $Database->GetConn();

		$id = mysqli_real_escape_string($conn,$id);
		$sql="DELETE FROM `".$this->table."`
				WHERE `Vote_Id` = '".$id."'";
		$result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

		mysqli_close($conn);
	}

	public function IsExist($mdl){

		$Database = new Database();
		$conn = $Database->GetConn();

		$val = false;
		$msg = "";
}

	public function Get(){

		$Database = new Database();
		$conn = $Database->GetConn();

		$sql="SELECT * FROM `".$this->table."`";
		$result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

		mysqli_close($conn);

		return $this->ListTransfer($result);
	}

	public function GetById($id){

		$Database = new Database();
		$conn = $Database->GetConn();

		$id = mysqli_real_escape_string($conn,$id);

		$sql="SELECT * FROM `".$this->table."`
				WHERE `Vote_Id` = '".$id."'";

		$result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

		mysqli_close($conn);

		return $this->ModelTransfer($result);
	}

	public function GetByUser_Id($id){

		$Database = new Database();
		$conn = $Database->GetConn();

		$id = mysqli_real_escape_string($conn,$id);

		$sql="SELECT * FROM `".$this->table."`
				WHERE `User_Id` = '".$id."'";

		$result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

		mysqli_close($conn);

		return $this->ListTransfer($result);
	}

	public function getsqlUserById($id){

		$Database = new Database();
		$conn = $Database->GetConn();

		$id = mysqli_real_escape_string($conn,$id);

		$sql="SELECT * FROM `".$this->table."`
				WHERE `Vote_Id` = '".$id."'";

		$result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

		mysqli_close($conn);

		return $this->ModelTransfer($result);
	}

  public function GetByElection_Id($id){

		$Database = new Database();
		$conn = $Database->GetConn();

		$id = mysqli_real_escape_string($conn,$id);

		$sql="SELECT * FROM `".$this->table."`
				WHERE `Election_Id` = '".$id."'";

		$result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

		mysqli_close($conn);

		return $this->ListTransfer($result);
	}

	public function getsqlElectionById($id){

		$Database = new Database();
		$conn = $Database->GetConn();

		$id = mysqli_real_escape_string($conn,$id);

		$sql="SELECT * FROM `".$this->table."`
				WHERE `Vote_Id` = '".$id."'";

		$result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

		mysqli_close($conn);

		return $this->ModelTransfer($result);
	}

  public function GetByCandidate_Id($id){

    $Database = new Database();
    $conn = $Database->GetConn();

    $id = mysqli_real_escape_string($conn,$id);

    $sql="SELECT * FROM `".$this->table."`
        WHERE `Candidate_Id` = '".$id."'";

    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

    mysqli_close($conn);

    return $this->ListTransfer($result);
  }

  public function getsqlCandidateById($id){

    $Database = new Database();
    $conn = $Database->GetConn();

    $id = mysqli_real_escape_string($conn,$id);

    $sql="SELECT * FROM `".$this->table."`
        WHERE `Vote_Id` = '".$id."'";

    $result=mysqli_query($conn,$sql) or die(mysqli_error($conn));

    mysqli_close($conn);

    return $this->ModelTransfer($result);
  }

	public function CheckSession($page){

		$Database = new Database();
		$conn = $Database->GetConn();

		$userType = "";

		$id = (isset($_SESSION['uid']))?$_SESSION['uid']:'';
		$id = mysqli_real_escape_string($conn,$id);

		$sql = "SELECT `User_Id` FROM `".$this->table."`
				WHERE `Vote_Id` = '".$id."'";
		$result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		while($row = mysqli_fetch_array($result))
		{
			$userType = $row['User_Id'];
		}

    $sql = "SELECT `Election_Id` FROM `".$this->table."`
				WHERE `Vote_Id` = '".$id."'";
		$result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		while($row = mysqli_fetch_array($result))
		{
			$userType = $row['Election_Id'];
		}

    $sql = "SELECT `Candidate_Id` FROM `".$this->table."`
				WHERE `Vote_Id` = '".$id."'";
		$result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		while($row = mysqli_fetch_array($result))
		{
			$userType = $row['Candidate_Id'];
		}


		mysqli_close($conn);

		if($page == 'admin'){
			if($userType == 1){
			}else if($userType == 2 || $userType == 3 || $userType == 4){
				header('Location: ../member/index.php');
				die();
			}else{
				header('Location: ../login.php');
				exit;
			}
		}else if($page == 'member'){
			if($userType == 1){
				header('Location: ../admin/index.php');
				die();
			}else if($userType == 2 || $userType == 3 || $userType == 4){
			}else{
				header('Location: ../login.php');
				exit;
			}
		}else if($page == 'login'){
			if($userType == 1){
				header('Location: admin/index.php');
				die();
			}else if($userType == 2 || $userType == 3 || $userType == 4){
				header('Location: member/index.php');
				die();
			}
		}else{
			echo 'unknown page';
			die();
		}
	}

	public function CountAllRow(){

		$Database = new Database();
		$conn = $Database->GetConn();

		$sql = "SELECT `Vote_Id` FROM `".$this->table."`";
		$result=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$num_rows = mysqli_num_rows($result);

		mysqli_close($conn);
		return $num_rows;
	}

	public function ModelTransfer($result){

		$mdl = new VoteModel();
		while($row = mysqli_fetch_array($result))
		{
			$mdl = $this->ToModel($row);
		}
		return $mdl;
	}

	public function ListTransfer($result){

		$lst = array();
		while($row = mysqli_fetch_array($result))
		{
			$mdl = new VoteModel();
			$mdl = $this->ToModel($row);
			array_push($lst, $mdl);
		}
		return $lst;
	}

	public function ToModel($row){
		$mdl = new VoteModel();

		$mdl->setId((isset($row['Vote_Id'])) ? $row['Vote_Id'] : '');
		$mdl->setUser_Id((isset($row['User_Id'])) ? $row['User_Id'] : '');
		$mdl->setCandidate_Id((isset($row['Candidate_Id'])) ? $row['Candidate_Id'] : '');
		$mdl->setElection_Id((isset($row['Election_Id'])) ? $row['Election_Id'] : '');
		return $mdl;
	}
}
?>
