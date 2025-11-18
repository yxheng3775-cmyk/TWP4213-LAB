
   const btnCheckPrice = document.querySelector("#check-price");
   btnCheckPrice.addEventListener("click", checkPrice);

   function checkPrice() {
      let input = prompt("Enter Product ID (1-5):");
      let out = document.querySelector("#result");
      if (input == null || input=="") {
        out.textContent = "No Product ID entered.";
        return;
     }

     var idNum = Number(input);
     if (isNaN(idNum)) {
        alert("Invalid input. Please enter a numeric ID between 1 and 5.");
        return;
     }

     if(idNum < 1 || idNum > 5){
       alert("Product with ID is not found.");
       return;
    }

     let price;
     let productName;

     switch(idNum){
        case 1:
          productName = "Ayam Proses(1kg)";
          price = 12.90;
          break;
        case 2:
          productName = "Beras(5kg)";
          price = 24.50;
          break;
        case 3:
          productName = "Cooking Oil(1kg)";
          price = 8.20;
          break; 
         case 4:
          productName = "UHT Milk 1L";
          price = 6.50;
          break;
         case 5:
          productName = "Minced Beef (500g)";
          price = 16.90;
          break;
     }
   
     out.textContent= "RM " + price; 
   }
