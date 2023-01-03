<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../static/css/style.css">

    <title>Vulnerable App Login</title>
</head>
<body>

    <!-- Login Section -->
    <div class="container container-fluid" style="padding:4em 2em">
            <h2 class="center">Login to the App</h2>
            <h6 class="center">Hint: admin/1234</h6>
            <h6 class="center">
                SQL Attack String: <code class="alert-warning">' OR 1=1 --&nbsp; </code> &nbsp; 
                <button class="btn btn-sm btn-outline-secondary" onclick="copy()">  
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard" viewBox="0 0 16 16">
                        <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                        <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
                    </svg> Copy
                </button>
            </h6>
            <form action="loginProcess.php" method="post">
                <div class="form-group mt-5">
                    <label for="myemail">Username</label>
                    <input class="form-control" type="text" id="myuser" name="myuser" placeholder="Your username">
                </div>
                <div class="form-group mt-3">
                    <label for="mypass">Password</label>
                    <input class="form-control" type="password" id="mypass" name="mypass" placeholder="Your password">
                </div>
                <div class="d-flex justify-content-between mt-3" style="margin-bottom: 1em;">
                    <input class="btn btn-primary" type="submit" value="Click to Login">
                </div>
            </form>
        </div>
        <!-- Login Section End -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        navigator.clipboard.writeText("' OR 1=1 -- ")
    </script>
</body>
</html>