<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header>
  <div class="ln-navbar">

    <a class="navbar-brand" href="index.php">
      <img src="Images/logo.jpg" width="75" height="75" alt="Lucky Nest Logo">
    </a>

    <div class="dropdown">
      <button class="dropbtn nav-btn">Payments</button>
      <div class="dropdown-content">
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="makePayment.php">Make Payment</a>
          <a href="paymentHistory.php">View Payment History</a>
        <?php else: ?>
          <a href="login.php">Login to Make Payment</a>
        <?php endif; ?>
      </div>
    </div>

    <div class="dropdown">
      <button class="dropbtn nav-btn">Rooms</button>
      <div class="dropdown-content">
        <a href="room.php">About Rooms</a>
        <a href="roomGallery.php">View Rooms</a>

        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="myBookings.php">My Booking</a>
          <a href="updateRoom.php">Update Room</a>
        <?php endif; ?>
      </div>
    </div>

    <div class="dropdown">
      <button class="dropbtn nav-btn">Services</button>
      <div class="dropdown-content">
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="mealPlan.php">Meal Plan</a>
          <a href="Laundry.php">Laundry</a>
          <a href="Housekeeping.php">Housekeeping</a>
        <?php else: ?>
          <a href="login.php">Login to View Services</a>
        <?php endif; ?>
      </div>
    </div>

    <div class="dropdown">
      <button class="dropbtn nav-btn">Profile</button>
      <div class="dropdown-content">
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="profile.php">View Profile</a>
          <a href="updateProfile.php">Update Profile</a>
          <a href="logout.php">Logout</a>
        <?php else: ?>
          <a href="login.php">Login</a>
          <a href="register.php">Register</a>
        <?php endif; ?>
      </div>
    </div>

    <a href="contactUs.php">Contact Us</a>

    <?php if (isset($_SESSION['user_id'])): ?>
      <span class="nav-user">Welcome, <?php echo ($_SESSION['username']); ?></span>
    <?php endif; ?>

  </div>
</header>