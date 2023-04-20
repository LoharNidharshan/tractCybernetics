<?php
	session_start();
	require_once "db.php";
	if (isset($_SESSION['user_id']) != "") {
		header("Location: deshboard1.php");
	}

	if (isset($_POST['login'])) {
		$email    = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$email_error = "Please Enter Valid Email ID";
		}
		if (strlen($password) < 6) {
			$password_error = "Password must be minimum of 6 characters";
		}
		$result = mysqli_query($conn, "SELECT * FROM tcpl_data2 WHERE email = '" . $email . "' and password = '" . md5($password) . "'");
		if ($row = mysqli_fetch_array($result)) {
			$_SESSION['user_id']     = $row['uid'];
			$_SESSION['user_name']   = $row['name'];
			$_SESSION['user_email']  = $row['email'];
			header("Location: deshboard1.php");
		} else {
			$error_message = "Incorrect Email or Password!!!";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
   
   
	<!--Bootsrap 4 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
   
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  
	<!--Custom styles-->
	
<style>
    html {
  height: 100%;
}
a{
    text-decoration: none;
}
body {
  height: 100%;
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
  display: grid;
  justify-items: center;
  align-items: center;
  background-color: #ecf0f3;
}

#main-holder {
 
  display: grid;
  justify-items: center;
  align-items: center;
  padding: 30px;
  background-color: #ecf0f3;
  border-radius: 15px;
  box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;
}
#login-header{
  color:#004aad;
}
form{
    text-align: center;
    display: flex;
flex-direction: column;
}


.login-form-field::placeholder {
  color: #3a3a3a;
}

.login-form-field {
  border: none;
    align-items: center;
  width: 300px;
  border-bottom: 1px solid #3a3a3a;
  margin-bottom: 20px;
  border-radius: 3px;
  font-size: 15px;
  outline: none;
  padding: 20px 0px 5px 5px;
}

#login-form-submit {
  width: 100%;
  /* margin-left: 20px; */
  padding: 10px;
  border: none;
  border-radius: 5px;
  color: white;
  font-weight: bold;
  /* background-color: #1877f2; */
  background-color: #004aad;
  cursor: pointer;
  outline: none;
}
#register-form-submit {
  width: 100%;
  /* margin-left: 20px; */
  padding: 10px;
  border: none;
  border-radius: 5px;
  color: white;
  font-weight: bold;
  background-color: #42b72a;
  cursor: pointer;
  outline: none;
}

.logo {
  width: 80px;
  margin: auto;
}

.logo img {
  width: 100%;
  height: 80px;
  object-fit: cover;
  border-radius: 50%;
  box-shadow: 0px 0px 3px #5f5f5f,
      0px 0px 0px 5px #ecf0f3,
      8px 8px 15px #a7aaa7,
      -8px -8px 15px #fff;
}


/* mediaquery */

@media screen and (min-width: 480px) {
 
#main-holder {
 padding :30px;  }
}

@media screen and (min-width: 768px) {
 
  #main-holder {
     padding: 30px;  }
  }

  
@media screen and (min-width: 1024px) {
 
  #main-holder {
    padding: 30px; }
  }
    
@media screen and (min-width: 1386px) {
 
  #main-holder {
    padding: 30px;  }
  }
  
</style>
</head>
<body>


<main id="main-holder">
    <h3 id="login-header">TCPL GIS</h3>
    <div class="logo">
      <img src="images/logo1.png" alt="Image not found">
  </div>
    <span class="text-danger"><?php if (isset($error_message)) echo $error_message; ?></span>
    <form class="p-3 mt-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
         
	 <input type="email" name="email" id="username-field" class="login-form-field" placeholder="Email" required="">
         <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>

	 <input type="password" name="password" id="password-field" class="login-form-field" placeholder="Password">
	 <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
     	 
         <input type="submit" value="submit" id="login-form-submit" name="login">
         <p class="mt-2 fw-bold">or</p>
         
         <a href="register.php"  id="register-form-submit"> Create new account  </a>

    </form>
  
  </main>
</body>
</html>







