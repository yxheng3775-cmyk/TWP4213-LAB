    <header>
      <div class="header-container">
        <a href="index.html">
          <img
            class="logo"
            src="img/lakeshow-logo.png"
            alt="Lakeshow Grocer Logo"
          />
        </a>
        <div class="search-container">
          <form id="searchForm" action="Lab 11 Q1 Products.php" method="GET">
            <input
              type="text"
              name="search"
              placeholder="Search for fresh products..."
              class="search-input"
            />
            <button type="submit" class="search-button">
              Search
            </button>
          </form>
        </div>
        <div class="link-after-login">
          <?php if (empty($_SESSION['cus_id'])) { ?>
          <a href="Lab 11 Q1 login.php">Log In</a>
          <?php } else { ?>
          <a href="Lab 11 Q1 Cart.php">Shopping Cart</a>
          <a href="chistory.php">Order History</a>
          <a href="cprofile.php">Profile</a>
          <a href="Lab 11 Q1 Logout.php">Log Out</a>
          <?php } ?>
        </div>

      </div>

      <nav class="navbar">
        <ul class="nav-links">

<?php $categoryQuery = "SELECT * FROM category WHERE status = 'Active'"; 
$categorystmt = $conn->prepare($categoryQuery); 
$categorystmt->execute(); 
$result = $categorystmt->get_result(); 

while ($category = $result->fetch_assoc()): ?> 
     <li> 
      <a href="Lab 11 Q1 Products Solution.php?category=<?php echo 
      ($category['Category_Name']); ?>" 
      class="category-link"> 
      <?php echo htmlspecialchars($category['Category_Name']) ?> 
              </a> 
            </li> 
        <?php endwhile; ?>
          <li>

         </ul>
      </nav>
    </header>

