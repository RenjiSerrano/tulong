<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nike - Just Do It</title>
    <link rel="stylesheet" href="style.css">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <header class="header">

        <div class="flex">
        
           <a href="#" class="logo">Once</a>
        
           <nav class="navbar">
              <a href="#">Home</a>
              <a href="products.php">Products</a>
              <a href="cart.php">Cart</a>
              <a href="logout.php" class="logout">logout</a>
           </nav>
        
        </div>
        
        </header>

    <section>
    

        <div class="main" id="Home">
            <div class="main_content">
                <div class="main_text">
                    <h1>ONCE<br><span>Collection</span></h1>
                </div>
                <div class="main_image">
                    <img src="image/smc.png">
                </div>
            </div>
          
            <div class="button">
                <a href="products.php">SHOP NOW</a>
                <i class="fa-solid fa-chevron-right"></i>
            </div>
        </div>

    </section>



    <!--About-->

    <div class="about" id="About">
        
        <h1>Latest Product</h1>

        <div class="about_main">
            <div class="about_image">
                <div class="about_small_image">
                    <img src="image/erick/3MIX/No bg (3).png" onclick="functio(this)">
                    <img src="image/erick/3MIX/No bg (2).png" onclick="functio(this)">
                    <img src="image/erick/3MIX/No bg (1).png" onclick="functio(this)">
                    <img src="image/erick/3MIX/No bg (4).png" onclick="functio(this)">
                </div>

                <div class="image_contaner">
                    <img src="image/erick/3MIX/No bg (3).png" id="imagebox">
                </div>

            </div>


        </div>

        <a href="products.php" class="about_btn">Shop Now</a>

        <script>
            function functio(small){
                var full = document.getElementById("imagebox")
                full.src = small.src
            }
        </script>
        
    </div>


    
</body>
</html>