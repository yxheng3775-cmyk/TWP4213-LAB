<?php include 'config.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Time Home Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="header.css">
  <link rel="stylesheet" href="footer.css">
  <style>
    :root{
      --main-color:#ffa100;
    }

    body{
      font-family:'Segoue UI',Arial,sans-serif;
      background-color:#fafafa ;
      color:black;
    }

    /* hero section */
    .hero-section{
      background:url("product image/hero\ section.png");
      height:500px;
      background-size: cover;
      background-position: center;
      margin:50px 0;
      color:white;
      display:flex;
      align-items:center;
    }

    .hero-section .container{
      text-align: left;
    }

    .hero-section h1{
      font-family: 'Times New Roman', Times, serif;
      font-size:70px;
      margin-left:0;
    }

    .hero-section p{
      font-family: sans-serif;
      font-size:30px;
      margin-bottom:0;
    }

    .btn-learn-more{
      margin-top:30px;
      background-color: white;
      color:var(--main-color);
      border-radius: 30px;
      height:50px;
      width:150px;
      transition:0.3s;
    }

    .btn-learn-more:hover{
      transform:translateY(-2px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.02) !important;
    }

    /* prodcut area */
    .main-container{
      max-width: 95%;
      padding:0 20px
    }

    .row-custom {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between; 
    gap: 30px; 
}

    .section-header{
      color:var(--main-color);
      font-weight: bold;
      margin:30px 0 40px;
      font-size:32px;
      display:flex;
      align-items:center;
      gap: 10px;
    }


    .book-item {
    flex: 0 0 18%; 
    min-width: 200px; 
    margin-bottom: 40px;
    }

    .book-card{
      border:none;
      text-align:center;
      margin-bottom:40px;
      transition:0.3s;
      width:100%;
      display:flex;
      flex-direction: column;
      height:450px;
      align-items:center;
      padding:0;
    }

    .book-img{
      width:100%;
      aspect-ratio: 2/3; /*Force all images to be the same size*/
      height:auto;
      object-fit:cover;
      background-color:#f9f9f9;
      border-radius: 6px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .book-title{
      font-weight:600;
      font-size:16px;
      height:40px;
      line-height: 1.2;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient:vertical;
      overflow:hidden;
      color:#333;
      margin: 15px 0 0 0;
      text-align: center;
      text-decoration: none;
      transition:0.03s;
    }

    .book-title:hover{
      text-decoration: underline;
      color:var(--main-color);
    }

    .book-price{
      color:var(--main-color);
      font-weight: bold;
      font-size:18px;
    }

  </style>


</head>
<body>
  <?php include 'header.php';?>

  <!-- banner -->
   <section class="hero-section">
    <div class="container">
      <h1> Welcome to Book Time <br> Online Book Store</h1>
      <p>Book Time Make Time for Books</p>
      <button class="btn btn-learn-more">Learn More</button>
    </div>
   </section>

   <!-- main content -->
  <main class="container">
    <?php 
      // 1.Get all unique category names
    $cat_sql = "SELECT category_id, category_name From categories";
    $cat_result = $conn->query($cat_sql);

    if($cat_result->num_rows>0){
      //Loop through each category
      //这里的 SQL 改为根据 category_id 查询
      while ($cat_row = $cat_result->fetch_assoc()){
        $current_cat_id = $cat_row['category_id'];
        $current_cat_name = $cat_row['category_name'];
        ?>
        <h2 class = "section-header"><?php echo htmlspecialchars($current_cat_name);?></h2>
        <div class="row-custom">
          <?php
          //catgory of books
          $sql = "SELECT*FROM books WHERE category_id = '$current_cat_id'";
          $result = $conn->query($sql);

          if ($result && $result->num_rows > 0) {
            while ($row=$result->fetch_assoc()){
              ?>
              <div class="book-item">
                <div class="book-card">
                  <img src="<?php echo $row['image'];?>" class="book-img" alt="<?php echo$row['title'];?>">
                  <a class="book-title"><?php echo $row['title'];?></a>
                  <p class="book-price">RM <?php echo number_format($row['price'],2);?> </p>
                </div>
              </div>
              <?php 
          }
          } else{
            echo "<p>No books available</p>";
          }
          ?>
        </div> <?php
          } 
      
      }else{
      echo "<p>No books available</p>";
    }
    ?>
  </main>

  <!-- footer -->
  <?php include 'footer.php';?>
  
  <script></script>
</body>
</html>