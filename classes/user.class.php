<?php 
	/**
	 * @author Rainan Miranda de Jesus <jesus.rainan@gmail.com> 
	 *
	 */
	class User
	{
		private $login;
		private $senha;
		function __construct($login, $senha)
		{
			$this->login = $login;
			$this->senha = $senha;
		}

		public function validateUser($connection)
		{
			if (strlen($this->login) < 5 || strlen($this->senha)<4) {
				return false;
			}
			else {
				$query = "SELECT user.usr_id, user.usr_login, user.usr_pass FROM user WHERE user.usr_login = '".$this->login."' AND user.usr_pass = MD5('".$this->senha."')";

				$queryFindUser = mysqli_query($connection, $query);

				if (mysqli_num_rows($queryFindUser)!=1) {
					return true;
				}
				else{
					return false;
				}
			}
		}
	}

 ?>