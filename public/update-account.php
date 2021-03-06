<?php
require('../src/config.php');
include(LAYOUT_PATH . 'header-public.php');


// Lösenordsskyddad, om SESSION inte är satt från login kan användaren inte komma åt sidan
checkLoginSession();

// Om inte userID är satt eller är ett nummer, skicka användaren till my-account med querystring invalidUser
if(!isset($_GET['userID']) || !is_numeric($_GET['userID'])){
  redirect("my-account", "invalidUser");
};


// Felmeddelande sätts till tomt
$message = "";
// Uppdatera användaruppgift
if(isset($_POST['updateAccountBtn'])) {

    // skapar och fyller array med user info
    $userInfo = [
      //Tar bort mellanslag före och efter textsträng
      $firstname  = trim($_POST['first_name']),
      $lastname   = trim($_POST['last_name']),
      $email      = trim($_POST['email']),
      $password   = trim($_POST['password']),
      $phone      = trim($_POST['phone']),
      $street     = trim($_POST['street']),
      $postalcode = trim($_POST['postal_code']),
      $city       = trim($_POST['city']),
      $country    = trim($_POST['country']),
    ];
    $userId = $userDbHandler->fetchOneUser($_GET['userID']);
  if(password_verify($userInfo[3], $userId['password'])){
    $userDbHandler->updateUser($_GET['userID'], $userInfo);
    redirect("my-account", "updateSucces");
} else { 
  $message = noMatchPassword($message);
}

}
// Hämtar en user
$user = $userDbHandler->fetchOneUser($_GET['userID']);

?>

<div class="wrapper-register">
  <h1>Update Account</h1>
  </div>
  <?=$message ?>

  	<!-- Updatering formulär -->
  <form method="POST" action="#" class="form mx-auto" >
		<!-- First Name -->
		<div class="mb-3">
    <label for="first-name" class="form-label">First Name</label>
    <input type="text" class="form-control" id="first-name" name="first_name" value="<?= htmlentities($user['first_name']) ?> ">
  </div>
		<!-- Last Name -->
		<div class="mb-3">
    <label for="last-name" class="form-label">Last Name</label>
    <input type="text" class="form-control" id="last-name" name="last_name" value="<?= htmlentities($user['last_name']) ?>">
  </div>
	<!-- Email -->
  <div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="email" class="form-control" name="email" value="<?= htmlentities($user['email']) ?>">
  </div>
	<!-- Password -->
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
		<!-- Phone -->
		<div class="mb-3">
    <label for="phone" class="form-label">Phone</label>
    <input type="tel" class="form-control" id="phone" name="phone" value="<?= htmlentities($user['phone']) ?>">
  </div>
		<!-- Street -->
		<div class="mb-3">
    <label for="street" class="form-label">Street</label>
    <input type="text" class="form-control" id="street" name="street" value="<?= htmlentities($user['street']) ?>">
  </div>
		<!-- Postal Code -->
		<div class="mb-3">
    <label for="postal_code" class="form-label">Postal Code</label>
    <input type="number" class="form-control" id="postal-code" name="postal_code" value="<?= htmlentities($user['postal_code']) ?>">
  </div>
		<!-- City -->
		<div class="mb-3">
    <label for="city" class="form-label">City</label>
    <input type="text" class="form-control" id="city" name="city" value="<?= htmlentities($user['city']) ?>">
  </div>
		<!-- Country -->
		<div class="mb-3">
    <label for="country" class="form-label">Country</label>
    <input type="text" class="form-control" id="counrty" name="country" value="<?= htmlentities($user['country']) ?>">
  </div>
  <!-- Update Btn -->
  <input type="submit" class="btn btn-primary btn-form" name="updateAccountBtn" value="Update">

</form>
<?php 
include(LAYOUT_PATH . 'footer.php');
?>
