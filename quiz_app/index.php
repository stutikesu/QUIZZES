<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
      /* Your existing CSS code */
        .nav-link{
            color: gray;
            font-weight: bold;
        }
        .hero-image{
            width: 100%;
            background-size: cover;
            background-position: center;
            height: 85vh;
            background-image: url(https://img.freepik.com/free-photo/why-question-reason-curious-confuse-concept_53876-123803.jpg?w=996&t=st=1720282031~exp=1720282631~hmac=58fcb83c4089548f65c1e86fbb75e6179433c2c993c05e7a5bfe878a7d32a401);
            position: relative;
            transition: background-color 0.5s;
        }
        .hero-image.blue-reflect::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color:darkorchid; /* Semi-transparent pink */
            z-index: 1; /* Ensure it covers the image */
        }
        .hero2-image.blue-reflect::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color:darkorchid; /* Semi-transparent pink */
            z-index: 1; /* Ensure it covers the image */
        }
        @media only screen and (max-width: 800px){
            .hero-image{
                background-image: url(https://media.istockphoto.com/vectors/quiz-time-neon-sign-style-text-vector-id1290210769?k=20&m=1290210769&s=612x612&w=0&h=M8Y2QEzA_KrYmTxsOwvfNTOegawrjC0UGmj86zJJBF0=);
            }
            .card-items {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
            }
            .card {
                width: calc(50% - 40px); /* 50% width with some margin for spacing */
                margin: 20px;
            }
            .flex h1{
                font-size: 50px;
            }
            .lobtn {
                display: flex;
                justify-content: center;
                align-items: center;
                margin-right: 100vh;
                margin-left: -120px;
            }
            .hero1-image {
                margin-left: 650px; /* Custom margin for larger screens */
            }
        }
        .flex{
            align-items: center;
            justify-content: center;
            display: flex;
        }
        .flex p{
            text-align: center;
            font-size: 2.6rem;
            font-weight: 700;
        }
        .flex h1{
            color: blue;
            font-style: italic;
            font-size: 3rem;
        }
        .hero1-image{
            background-image: url("thnnn-removebg-preview.png");
            background-size: contain; /* Ensure the background image is fully contained */
            background-repeat: no-repeat; /* Avoid repeating the background image */
            width: 260px;
            height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto; /* Center horizontally */
        }
        .card-items{
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-evenly;
        }
        .card{
            background-image: url(https://tse1.mm.bing.net/th?id=OIP.0_GJPQlQzfOCDmh8uT3LawHaEo&pid=Api&P=0&h=180);
            width: 360px;
            height: 150px;
        }
        .card h5{
            color: white;
            font-weight: bold;
        }
        .card p{
            color: whitesmoke;
        }
        .btn1-wrapper {
            position: absolute; /* Position absolutely relative to parent */
            top: 20px; /* Adjust top position as needed */
            left: 50%; /* Center horizontally */
            transform: translateX(-50%); /* Center horizontally */
            z-index: 1; /* Ensure button is above the image */
        }
        .btn1 {
            width: 200px;
            text-align: center;
            margin-top: 332px;
            font-size: 1.7rem;
            font-weight: 500;
            margin-left: 710px;
            color: pink;
            width: 400px;
            background-color: #fef9f2;
        }
        /* Media query for smaller screens */
        @media (max-width: 800px) {
            .btn1-wrapper {
                top: 10px; /* Adjust top position for smaller screens */
            }
            .btn1{
                margin-right: 510px;
                width: 200px;
                font-size: 1.5rem;
                margin-top: 332px;
                height: 60px;
            }
        }
        .hero2-image {
            position: relative; /* Ensure relative positioning for absolute child */
            width: 100%;
            max-width: 100%;
            height: auto; /* Ensure image responsiveness */
            overflow: hidden; /* Hide overflow content if needed */

            transition:  background-color 0.5s;

        }
        .hero2-image img {
            width: 100%;
            height: auto;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            color: #343a40;
        }
        .footer .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .footer .logo {
            flex: 1 1 100%;
            text-align: center;
        }
        .footer .logo img {
            max-width: 150px;
        }
        .footer .links {
            flex: 1 1 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
        }
        .footer .links ul {
            list-style: none;
            padding: 0;
            margin: 10px 20px;
            text-align: left;
        }
        .footer .links ul li {
            margin: 5px 0;
        }
        .footer .links ul li a {
            color: #343a40;
            text-decoration: none;
        }
        .footer .links ul li a:hover {
            text-decoration: underline;
        }
        .footer .apps {
            flex: 1 1 100%;
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .footer .apps img {
            max-width: 150px;
            margin: 0 10px;
        }
        @media (min-width: 768px) {
            .footer .logo {
                flex: 1;
                text-align: left;
            }
            .footer .links {
                flex: 2;
                justify-content: space-between;
            }
            .footer .apps {
                flex: 1;
                justify-content: flex-end;
            }
        }



    </style>

</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary ">
  
            <div class="container-fluid">
              <a class="navbar-brand" href="#">

             <h1 style="font-size: 1.8rem; font-weight:bold">QUIZZES</h1>
              </a>
              &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
  </button>
          <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="help.html">Help</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="aboutus.html">About Us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact.html">Contact Us</a>
              </li>
            </ul>
            </div>
        
            <button type="button" class="btn btn-outline-success"><a href="login.php" style="text-decoration: none; color:black; font-weight:bold">Login</a></button>
            &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
           
            <button type="button" class="btn btn-outline-success"><a href="register.php" style="text-decoration: none; color:black; font-weight:bold">Register</a></button>
            &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
            &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;
          </div>
        
      </nav>
      <br>
      <div class="hero-image">
       
      </div>
      <br>
      <br>
      <div class="card-items">
      <div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Quiz is fun</h5>
    <p class="card-text">A quiz is a fun and engaging way to challenge your knowledge and understanding of various topics, providing a playful yet educational. experience.

</p>

  </div>
</div>
<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Quiz is Learning</h5>
    <p class="card-text">A quiz is a powerful learning tool that helps reinforce knowledge and concepts, making it an essential part of the educational process.

</p>

  </div>
</div>
<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Quiz is instant</h5>
    <p class="card-text">A quiz provides instant feedback, allowing participants to quickly assess their understanding and identify areas for improvement.</p>
 
  </div>
</div>
</div>
<br>
<br>
<br>
<br>
<div class="flex flex-col md:flex-row">
<p class=" text-[36px] font-semibold leading-[44px] -tracking-[0.72px] text-[#272727] md:text-[60px] md:font-medium md:leading-[72px] md:-tracking-[3px]">Supercharge&nbsp;</p>
<p class=" text-[36px] font-semibold leading-[44px] -tracking-[0.72px] text-[#272727]  md:text-[60px] md:font-medium  md:leading-[72px] md:-tracking-[3px]"> your knowledge with</p>
      </div>
      <br>
<div class="flex flex-col gap-6 md:gap-5"><h1 class="font-instrumentSerif text-[40px] leading-[48px]   -tracking-[0.8px] text-[#007AFF] md:text-[68px] md:leading-[72px] md:-tracking-[1.36px]">Fun Quizzes.</h1>

</div>
<br>
<br>
<div class="lobtn">
<button type="button" class="btn btn-outline-success" style="margin-left:660px; width:200px"><a href="register.php" style="text-decoration: none; color:black; font-weight:bold">Register</a></button>
</div>
<br>
<br>
<br>
<div class="hero1-image">
       
      </div>
      <br>
      

      <div class="hero2-image">
        <div class="btn1-wrapper">
            <button type="button" class="btn1 btn-outline-success">
                <a href="register.php" style="text-decoration: none; color:black; font-weight:bold;">TRY&nbsp; FOR&nbsp; FREE</a>
            </button>
        </div>
        <img src="https://images.squarespace-cdn.com/content/v1/5c999e464aa2ae0001d2cc3c/bcf7f8d3-a289-4455-a5d8-c51bbc98d76c/Why+should+you+use+interactive+quizzes+in+your+business%3F.png" class="rounded1 float-start" alt="Image" style="width: 100%; height: 570px;">
    </div>


    <br>
    <br>
    <br>

    <!-- Footer Section -->
    <footer class="footer">
        <div class="container">
            <div class="logo">
                <img src="https://img.freepik.com/free-vector/watercolor-background-with-question_23-2147595468.jpg?w=740&t=st=1720285901~exp=1720286501~hmac=8723df6646a5e9390ecca5ab8fda7511ec5e5a1e59571c1f173e1c1aa9fe79bc" alt="Logo">
            </div>
            <div class="links">
                <ul>
                    <li><a href="#">The Quizizz Blog</a></li>
                    
                    <li><a href="#">State Test Prep</a></li>
                    <li><a href="#">Quizizz for Work</a></li>
                    <li><a href="#">Help Center</a></li>
                 
                    <li><a href="#">IQAPS</a></li>
                    <li><a href="#">Accessibility and Inclusion</a></li>
                    <li><a href="#">Sitemap</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
                <ul>
                    <li><a href="#">Worksheets</a></li>
                    <li><a href="#">Reseller Program</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Privacy Center</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">About Us</a></li>
                </ul>
            </div>
            <div class="apps">
                <a href="#"><img src="https://www.pngkey.com/png/full/9-94519_google-play-png.png" alt="Google Play"></a>
            
            </div>
        </div>
    </footer>
    <script>
         // Smooth Scrolling for Navigation Links
         document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Form Validation Example
        document.addEventListener('DOMContentLoaded', function() {
            const registrationForm = document.querySelector('form'); // Assuming the form has a tag
            registrationForm.addEventListener('submit', function(event) {
                const username = document.getElementById('username').value;
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;

                if (!username || !email || !password) {
                    event.preventDefault();
                    alert('All fields are required!');
                }
            });
        });

        // Display Message on Button Click
        document.addEventListener('DOMContentLoaded', function() {
            const startQuizButton = document.querySelector('.btn-primary.mt-4');
            startQuizButton.addEventListener('click', function() {
                alert('Good luck on your quiz!');
            });
        });

        // Change Image Background Color on Click
        document.addEventListener('DOMContentLoaded', function() {
            const heroImage = document.querySelector('.hero-image');

            heroImage.addEventListener('click', function() {
                heroImage.classList.add('blue-reflect');

                setTimeout(function() {
                    heroImage.classList.remove('blue-reflect');
                }, 500); // Remove the pink reflection after 0.5 seconds
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const heroImage = document.querySelector('.hero2-image');

            heroImage.addEventListener('click', function() {
                heroImage.classList.add('blue-reflect');

                setTimeout(function() {
                    heroImage.classList.remove('blue-reflect');
                }, 500); // Remove the pink reflection after 0.5 seconds
            });
        });
    </script>

      <body>
</html>
