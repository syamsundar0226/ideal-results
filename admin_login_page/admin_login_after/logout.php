<?php
  // Start the session
  session_start();

  // Unset all session variables
  session_unset();

  // Destroy the session
  session_destroy();

  // Set cache control headers
  header("Cache-Control: no-cache, no-store, must-revalidate");
  header("Pragma: no-cache");
  header("Expires: 0");

  // Redirect to the login page
  header("Location: ../../index.html");
  exit();
?>
