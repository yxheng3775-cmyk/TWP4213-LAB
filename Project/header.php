 <!-- header -->
  <header class="top-header">
    <div class="container-fluid px-4">
      <div class = "row align-items-center">
            <div class="logo-area">
              <img src="product image/logo/Book time logo.png"class="logo" alt="Book_Time_Logo">
            </div>
        
          <!-- //search -->
          <div class="search-area">
            <div class="input-group-custom">
              <i class="fas fa-search search-icon-inside"></i>
              <input type="text" class="form-control search-box" placeholder="What are you looking for">
              <button type="submit" class="btn btn-search">Search</button>
            </div>
          </div>

            <div class="user-actions">
              <i class="fas fa-shopping-cart cart-icon"></i>
              <a href="#" class="sign-up"><i class="far fa-user"></i>Sign Up/Sign In</a>
              <i class ="fas fa-bars menu-icon" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu"></i>
            </div>

            <!-- menu collapsible bar -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
              <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="mobileMenuLabel" style="color: var(--main-color); font-weight: bold;">Menu</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item border-0"><a href="homepage.php" class="text-decoration-none text-dark"><i class="fas fa-home me-2"></i> Homepage</a></li>
                  <li class="list-group-item border-0"><a href="" class="text-decoration-none text-dark"><i class="fas fa-shopping-cart me-2"></i> Shopping Cart</a></li>
                  <li class="list-group-item border-0"><a href="" class="text-decoration-none text-dark"><i class="fas fa-user-circle me-2"></i> Account</a></li>
                  <li class="list-group-item border-0"><a href="" class="text-decoration-none text-dark"><i class="fas fa-info-circle me-2"></i> About Us</a></li>
                </ul>
              </div>
          </div>
        
      </div>
    </div>
  </header>

  <!-- nav bar -->
  <nav class="navbar category-nav">
      <div class="container-fluid px-4">
        <div class="nav-links d-flex">
          <a class="nav-link" href="About Us.php">About Us</a>
          <a class="nav-link" href="catelog.php?id=1">Fiction</a>
          <a class="nav-link" href="catelog.php?id=2">Non-Fiction</a>
          <a class="nav-link" href="catelog.php?id=3">Education</a>
          <a class="nav-link" href="catelog.php?id=4">Technology</a>
          <a class="nav-link" href="catelog.php?id=5">Children</a>
        </div>

         <div class="nav-actions d-flex align-items-center gap-4">
          <a href="javascript:void(0);" class="share" onclick="copyPageLink()">
            <i class="fas fa-share-alt nav-icon"></i> 
            Share</a>
        </div>
        <!-- link copy -->
        <div id="copy-toast" style="display:none; position: fixed; top: 150px; right: 20px; background:rgba(0,0,0,0.3); color: white; padding: 10px 20px; border-radius: 5px; z-index: 9999;">
        link copied!
      </div>
      </div>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  // <!-- menu collapsible bar -->
    window.onload = function() {
    var myOffcanvas = document.getElementById('mobileMenu');
    if(myOffcanvas) {
        console.log("Offcanvas element found!");
    } else {
        console.error("Offcanvas element NOT found! Check your ID.");
    }
  };

     // link copy
  function copyPageLink() {
    // get current URL
    const currentUrl = window.location.href;

    // Using clipboard API copy it
    navigator.clipboard.writeText(currentUrl).then(function() {
       
        //display notifier
        const toast = document.getElementById('copy-toast');
        toast.style.display = 'block';
        
        setTimeout(() => {
            toast.style.display = 'none';
        }, 2000);
        
        //copy failed
    }).catch(function(err) {
        console.error('Link copy failed: ', err);
        alert("Copying failed, please copy the link manually.");
    });
}
  </script>
