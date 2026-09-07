<?php
    include("header1.php"); // header1.php now calls session_start()
    if (!isset($_SESSION['email'])) {
        header("location:admin_login.php");
        exit;
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agiculutre</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f8ff; /* Light Blue Background */
        }

        .bg-container {
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .bg {
            height: 100%;
            width: 400%; /* for smooth transition */
            display: flex;
            transition: transform 2s ease-in-out;
        }

        .bg div {
            height: 100%;
            width: 100vw; /* Each image takes full viewport width */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fcba03;
            font-style:Poppins;
            z-index: 1; /* Add a lower z-index value */
        }

        .search-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
            text-align: center;
            opacity: 0.8;
        }

        .search-container h1 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 20px;
            opacity: 1;
        }

        .search-container input[type="text"] {
            padding: 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .container-section {
            padding: 60px 0;
            text-align: center;
        }

        .container-section h2 {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .featured-properties .card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .featured-properties .card:hover {
            transform: scale(1.05);
        }

        .testimonial {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .testimonial .author {
            font-weight: bold;
            margin-top: 20px;
        }

        .footer {
            background-color: #333;
            color: #fff;
            padding: 40px 0;
            text-align: center;
        }

        .footer a {
            color: #fff;
            margin: 0 10px;
            font-size: 20px;
        }

        .social-icons a {
            color: #fff;
            font-size: 24px;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            transform: scale(1.2);
        }
    </style>
</head>
<body>
   
    <div class="bg-container">
        <div class="bg" id="bg">
            <div style="background-image: url('images/bg4.jfif');"></div> 
            <div style="background-image: url('images/bg1.webp');"></div>
            <div style="background-image: url('images/bg2.jpg');"></div>
            <div style="background-image: url('images/bg3.jfif');"></div>
        </div>
      <!-- <div class="overlay">
            <div class="search-container">
                <h1>Find Your Instruments</h1>
               <form method="POST" action="search-property.php">
                    <input class="form-control" type="text" placeholder="Enter Instrument Name" name="search_property" aria-label="Search">
                </form>
            </div>
        </div> -->
    </div>

    <div class="container-section featured-properties">
        <div class="container">
            <h2>Find Your Equipments</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <img src="images/inst1.webp" height="300" class="card-img-top" alt="Property 1">
                        <div class="card-body">
                            <h5 class="card-title"> 5 Tine duck foot Agricultre</h5>
                            <p class="card-text">A 5 tine  duck foot cutivator is a tractor- operated agriculutre implement used for primary till-age operations like ploughing fields.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="images/inst3.png" class="card-img-top" alt="Property 2">
                        <div class="card-body">
                            <h5 class="card-title">A mounted offset disc harrow</h5>
                            <p class="card-text"> An agriculute tool used to prepare soil and control weeds.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="images/inst2.jfif" height="320" width="220"class="card-img-top" alt="Property 3">
                        <div class="card-body">
                            <h5 class="card-title">Agiculutre Rake</h5>
                            <p class="card-text">A rake is an garden and Farm tool. People use rake to gather loose things like leaves</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-section testimonials">
        <div class="container">
            <h2>What Our Clients Say</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="testimonial">
                        <p>"This service helped me find the perfect home for my family. Highly recommend!"</p>
                        <p class="author">- Jane Doe</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial">
                        <p>"A seamless experience from start to finish. Great support from the team."</p>
                        <p class="author">- John Smith</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial">
                        <p>"Found an amazing apartment in the city center. Couldn't be happier!"</p>
                        <p class="author">- Emily Davis</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <p>&copy; 2024 Gateway Paradise. All rights reserved.</p>
            <div class="social-icons">
                <a href="#" class="fab fa-facebook"></a>
                <a href="#" class="fab fa-twitter"></a>
                <a href="#" class="fab fa-instagram"></a>
                <a href="#" class="fab fa-linkedin"></a>
            </div>
        </div>
    </div>

    <!-- <?php
    include("property-list.php");
    ?> -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        const backgroundImages = [
            'images/1.jpg',
            'images/2.jpg',
            'images/3.jpg',
            'images/4.jpg',
        ];

        let currentIndex = 0;

        function changeBackgroundImage() {
            const bgElement = document.getElementById('bg');
            bgElement.style.transform = `translateX(-${currentIndex * 100 / backgroundImages.length}%)`;
            currentIndex = (currentIndex + 1) % backgroundImages.length;
        }

        setInterval(changeBackgroundImage, 4000);
    </script>
</body>
</html>