<!DOCTYPE html>
<html lang="en">
<head>
  <script>
    function authChange() {
        window.opener.twitterAuthChange();
        //simple browers won't do this so...
        location.href = '/home';
    }
    authChange();
    window.close();  
  </script>
</head>
<body>
</body>
</html>
