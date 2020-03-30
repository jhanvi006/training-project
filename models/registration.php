<html>
    <head>
        <title> User Registration Form </title>
    </head>

    <body>
        <form method="post" action="includes/validation.php">    
            <div>
                <label>First Name</label>
                <div>
                    <input type="text" name="firstName">
                </div>
            </div>

            <div>
                <label>Last Name</label>
                <div>
                    <input type="text" name="lastName">
                </div>
            </div>
            
            <div>
                <label>Email</label>
                <div>
                    <input type="text" name="email">
                </div>
            </div>

            <div>
                <label>Phone No.</label>
                <div>
                    <input type="text" name="phone">
                </div>
            </div>

            <div>
                <label>Password</label>
                <div><input type="password" name="password" value=""></div>
            </div>

            <div>
                <input type="submit" name="register-user" value="Register">
            </div>
        </form>
    </body>
</html>