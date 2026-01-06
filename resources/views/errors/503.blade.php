<?php
// maintenance.php

http_response_code(503); // Service Unavailable
header("Retry-After: 3600"); // Suggest retry in 1 hour
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Site Under Maintenance</title>
  <style>
    body {
      background: #b71c1c;
      color: #fff;
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      text-align: center;
    }
    .box {
      background: #d32f2f;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.5);
    }
    h1 {
      font-size: 2rem;
      margin-bottom: 10px;
    }
    p {
      font-size: 1.2rem;
    }
  </style>
</head>
<body>
  <div class="box">
    <h1>ðŸš§ Site Under Maintenance ðŸš§</h1>
    <p>Weâ€™ll be back shortly. Please check again later.</p>
  </div>
</body>
</html>
