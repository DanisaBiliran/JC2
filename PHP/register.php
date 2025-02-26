<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/forms.css">
    
    <script>
        // ASYNCHRONOUS FUNCTION TO HANDLE USER REGISTRATION
        async function registerUser(event) {
            event.preventDefault();
            let form = document.forms["registerForm"];

            // GET THE REGISTRATION FORM AND EXTRACT INPUT VALUES
            let userData = {
                first_name : form ["first_name"].value.trim(),
                last_name : form ["last_name"].value.trim(),
                email: form ["email"].value.trim(),
                mobile: form["mobile"].value.trim(),
                role: "user",  // Default role
                status: "Unverified", // Default status
                password: form["password"].value.trim(),
                confirm_password: form["confirm_password"].value.trim()
            };

            // empty fields
            if (!userData.first_name || 
                !userData.last_name || 
                !userData.email || 
                !userData.mobile ||
                !userData.role ||
                !userData.status ||
                !userData.password ||
                !userData.confirm_password
            ) {
                alert ("All fields are required!");
                return;
            }

            // email
            if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(userData.email)){
                alert("Enter a valid email address.");
                return;
            }

            // mobile
            if (!/^\d{11,}$/.test(userData.mobile)){
                alert("Enter a valid 11-digit mobile number.")
                return;
            }

           // password
            if (userData.password.length < 6) {
                alert("Password must be at least 6 characters long.");
                return;
            }

            if (!/[A-Z]/.test(userData.password)) {
                alert("Password must contain at least one uppercase letter.");
                return;
            }

            if (!/[a-z]/.test(userData.password)) {
                alert("Password must contain at least one lowercase letter.");
                return;
            }

            if (!/[0-9]/.test(userData.password)) {
                alert("Password must contain at least one number.");
                return;
            }

            if (!/[\W_]/.test(userData.password)) {
                alert("Password must contain at least one special character.");
                return;
            }


            // confirm password
            if (userData.password !== userData.confirm_password){
                alert("Passwords do not match.");
                return;
            }

            // SEND A POST REQUEST TO THE API ENDPOINT WITH JSON DATA
            let response = await fetch ("register_api.php", {
                method: "POST", //HTTP method to send data
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify(userData) //convert user data to JSON format
            });

            // WAIT FOR THE RESPONSE AND PARSE IT AS JSON
            let result = await response.json();
            alert(result.message);
            if (result.success) window.location.href = "login.php";
        }
    </script>
    <title>Register</title>
</head>
<body>
    <form action="" id="registerForm" method="" onsubmit="registerUser(event)" style="width: 40%; margin: auto;">
        <input type="text" name="first_name" id="first_name" placeholder="first_name">
        <br>

        <input type="text" name="last_name" id="last_name" placeholder="last_name">
        <br>

        <input type="email" name="email" id="email" placeholder="email">
        <br>

        <input type="tel" name="mobile" id="mobile" placeholder="mobile">
        <br>

        <input type="text" name="role" id="role" placeholder="role">
        <br>

        <input type="text" name="status" id="status" placeholder="status">
        <br>

        <input type="password" name="password" id="password" placeholder="password">
        <br>

        <input type="password" name="confirm_password" id="confirm_password" placeholder="confirm_password">
        <br>

        <input class="login-btn" type="submit" name="submit" id="submit">
        <br><br>

        <p>Already have an account? <a href="login.php">Login here</a></p>
    </form>
</body>
</html>
