<?php
session_start();
session_destroy(); // Destroy the session to log out the use
?>
<script type="text/javascript">
    // Redirect to the login page after logout
    location.href = 'loginUser.php';
</script>