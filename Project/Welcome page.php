<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome page</title>
</head>
   <style>

    :root{
        --main-orange: #ff8c00;
        --container-bg: rgba(30, 30, 30, 0.75);
    }
 
    body {
        margin: 0;
        padding: 0;
        background-image: linear-gradient(rgba(255, 165, 0, 0.2), rgba(255, 165, 0, 0.2)), url("img/background.png");
        background-size: cover; 
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed; /* fixed background  */
        height: 800px;
        display: flex; /* use Flexbox to let the container be centered */
        align-items: center;
        justify-content: center;
    }
    
    /* Container styles */
    .login-container {
        max-width: 400px;
        width: 85%;
        padding: 40px;
        background-color: var(--container-bg);
        border-radius: 12px;
        box-shadow: 15px 15px 0px -2px #1E1E1EBF, 15px 15px 0px 0px rgba(0,0,0,0.7); /* add shadow effect */
        background-clip: padding-box;
        text-align: center;
    }
    /* Welcome message styles */
    .login-welcome h3 {
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: bold;
        font-family: 'Georgia', 'Times New Roman', serif;
        color: white; 
    }

    .login-welcome p {
        margin-bottom: 30px;
        font-size: 18px;
        font-family: 'Georgia', 'Times New Roman', serif;
        color: #ddd; 
    }
    /* Logo image */
    .login-welcome img {
        display: block;
        margin: 0 auto 20px;
        width: 220px;
        height: auto;
    }

    button {
        width: 70%;
        padding: 12px;
        margin: 5px;
        cursor: pointer;
        border: none;
        border-radius: 6px;
        background-color: var(--main-orange); 
        color: white;
        font-family: 'Arial', sans-serif;
        font-weight: bold;
    }
    /* Button hover effect */
    button:hover {
        background-color: #ffa100; 
    }

    @media screen and (max-width: 768px) {
        body {
            height: auto;
            padding: 150px 0; /* leave some space on top and bottom */
        }

        /* Adjust container for smaller screens */
        .login-container {
            width: 90%;      
            padding: 20px;   
            /* reduce the offset on the bottom right corner to make it look more refined on small screens */
            box-shadow: 8px 8px 0px var(--container-bg), 8px 8px 0px 0px rgba(0,0,0,0.7); 
        }

        .login-welcome h3 {
            font-size: 20px; 
        }

        .login-welcome p {
            font-size: 16px; 
            margin-bottom: 20px;
        }

        .login-welcome img {
            width: 200px;    
        }

        button {
            width: 90%;     
            padding: 15px;   /* increase height, for easier touch */
            margin: 10px 0;  /* increase vertical spacing between buttons */
            font-size: 16px;  /* increase font size for better readability */
        }
    }
   </style>
<body>
    <div class="login-container">
          <div class="login-welcome">
          <img src="img/logo.png" alt="Book Time Logo" width="150" height="150">
          <h3>Welcome to Book Time! Let's explore the world of books together.</h3>
          <p>Please select your role:</p>
          <button onclick="location.href='Admin Login.php'">Administrator</button>
          <button onclick="location.href='Homepage.php'">Customer</button>
        </div>
    </div>
</body>
</html>