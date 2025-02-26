<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form id="loginForm" onsubmit="loginUser(event)" style="width: 40%; margin: auto;">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="Email">
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Password">
        <br>
        <input type="submit" value="Login">
    </form>
    <script>
        async function loginUser(event) {
            event.preventDefault();
            const form = document.getElementById('loginForm');
            const email = form.email.value;
            const password = form.password.value;

            const userData = {
                email: email,
                password: password
            };

            const response = await fetch('login_api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(userData)
            });

            const result = await response.json();
            alert(result.message);

            if (result.success) {
                // Role-Based Redirection (PoLP)
                if (result.role === 'admin') {
                    window.location.href = 'admin_dashboard.php';
                } else {
                    window.location.href = 'profile.php'; 
                }
            }
        }
    </script>
</body>
</html>
