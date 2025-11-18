<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="footer.css">
<style>
        .main-container {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1000px; /*limit the width of the content */
            margin: 0 auto;
            padding: 40px 20px;
        }

        /*full screen */
        body {
            margin: 0;
            background-color: #f9fbfd;
        } 
        /* Section headers */
        h2 {
            color: #2c3e50;
            border-left: 5px solid #ffa100; /* orange accent line */
            padding-left: 15px;
            padding-bottom: 5px;
            border-bottom: 2px solid #3498db; /* blue underline */
            margin-top: 40px;
        }

        p {
            margin-bottom: 20px;
            font-size: 1.1rem;
            color: #555;
        }

        /* Team Section Layout */
        .team-container {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            gap: 25px; /* space between cards */
            justify-content: center; /* center the cards */
            margin-top: 30px;
        }

        /* individual member card styles */
        .member-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); /* subtle shadow */
            padding: 20px;
            width: 280px;
            text-align: center;
            margin: 10px;
        }

        .member-card:hover {
            transform: translateY(-10px); /* lift the card on hover */
        }

        .member-card img {
            width: 120px;
            height: 120px;
            border-radius: 50%; /* circular image */
            object-fit: cover;
            margin-bottom: 15px;
            border: 3px solid #ffa100;
        }

        .member-card h3 {
            margin: 10px 0;
            color: #2c3e50;
        }

        .member-card p {
            font-size: 0.9rem;
            margin: 5px 0;
            color: #7f8c8d;
        }
    
        @media (max-width: 600px) {
            body { 
              padding: 20px; 
            }
            h2 { 
              text-align: center; 
              border-left: none; 
            }
        }

</style>
</head>
<body>
    <?php include_once 'header.php'; ?>
    
    <div class="main-container">
    <h2>About Us</h2>
      <p>Welcome to our Book Time! We are an online bookstore that provides a simple and convenient platform for users to browse, discover, and purchase a wide variety of books. The platform offers a secure and user-friendly online shopping experience, making reading more accessible anytime and anywhere.</p>

    <h2>Mission</h2>
      <p>Our mission is to provide a convenient and user-friendly online platform that allows customers to easily discover, purchase, and enjoy a wide range of books anytime and anywhere.</p>

    <h2>Vision</h2>
      <p>Our vision is to become a trusted online bookstore that promotes a strong reading culture and makes books accessible to everyone through digital technology.</p>

    <h2>Our Team</h2>
    <div class="team-container">
      <div class="member-card">
        <img src="img/member1.jpeg" alt="Member 1">
        <h3>Chung Shin Ru</h3>
        <p>Student ID: 243DT243RR</p>
        <p>Email: CHUNG.SHIN.RU@student.mmu.edu.my</p>
    </div>

    <div class="member-card">
        <img src="img/member2.jpeg" alt="Member 2">
        <h3>Wong Yung Sin</h3>
        <p>Student ID: 243DT2463D</p>
        <p>Email: WONG.YUNG.SIN@student.mmu.edu.my</p>
    </div>

    <div class="member-card">
        <img src="img/member3.jpg" alt="Member 3">
        <h3>Heng Yu Xuan</h3>
        <p>Student ID: 243DT245CM</p>
        <p>Email: HENG.YU.XUAN@student.mmu.edu.my</p>
    </div>
   </div>
</div>

   <?php include_once 'footer.php'; ?>

</body>
</html>