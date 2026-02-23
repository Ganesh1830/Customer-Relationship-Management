<?php
session_start();
include "db.php";

$message = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $username;
            header("Location: home.php");
            exit();
        } else {
            $message = "Incorrect password!";
        }
    } else {
        $message = "User not found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Futuristic Login</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: linear-gradient(135deg, #111827, #1e293b, #0f172a);
            height: 100vh;
        }

        .ring-animate {
            animation: pulse-ring 4s infinite linear;
        }

        @keyframes pulse-ring {
            0% { transform: scale(1); opacity: .6; }
            50% { transform: scale(1.1); opacity: .3; }
            100% { transform: scale(1); opacity: .6; }
        }
    </style>
</head>
<body class="flex items-center justify-center">

<div class="relative w-[400px]">
    <!-- Outer Rings -->
    <div class="absolute inset-0 rounded-full border-2 border-cyan-400/30 ring-animate"></div>
    <div class="absolute inset-4 rounded-full border border-cyan-300/20"></div>

    <!-- Login Box -->
    <div class="relative bg-white/10 backdrop-blur-xl p-10 rounded-2xl border border-white/10 shadow-xl text-white">

        <h2 class="text-3xl font-bold mb-6 text-center tracking-widest">LOGIN</h2>

        <form method="POST" class="space-y-4">
            <input 
                type="text" 
                name="username" 
                placeholder="Username"
                class="w-full bg-white/10 border border-white/20 rounded-lg p-3 outline-none text-white placeholder-gray-300"
                required
            >

            <input 
                type="password" 
                name="password" 
                placeholder="Password"
                class="w-full bg-white/10 border border-white/20 rounded-lg p-3 outline-none text-white placeholder-gray-300"
                required
            >

            <button 
                name="login"
                class="w-full bg-cyan-400 text-gray-900 font-bold py-3 rounded-lg hover:bg-cyan-300 transition"
            >
                Login
            </button>
        </form>

        <?php if ($message != ""): ?>
            <p class="mt-4 text-red-400 text-center"><?php echo $message; ?></p>
        <?php endif; ?>

        <div class="mt-6 text-center text-sm">
            <a href="register.php" class="text-cyan-300">Create Account</a> |
            <a href="forgot.php" class="text-cyan-300">Forgot Password?</a>
        </div>
    </div>
</div>

</body>
</html>
