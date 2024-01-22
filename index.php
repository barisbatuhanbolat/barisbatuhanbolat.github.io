<!DOCTYPE html>
 <html lang="en">
   <head>
     <meta charset="UTF-8" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0" />
     <title>OPIUM</title>
     <link rel="stylesheet" type="text/css" href="landing-style.css?<?php echo filemtime('landing-style.css'); ?>">
     <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet"/>
     <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
     <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>  
     <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.8.0/gsap.min.js"></script>   
     <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css' rel='stylesheet'>
   </head>
   <body>
     <!-- ==== HEADER ==== -->
     <header class="container header">
       <!-- ==== NAVBAR ==== -->
       <nav class="nav">
         <div class="logo">
           <h2>OPIUM</h2>
         </div>
 
         <div class="nav_menu" id="nav_menu">
           <button class="close_btn" id="close_btn">
             <i class="ri-close-fill"></i>
           </button>
 
         <button class="toggle_btn" id="toggle_btn">
           <i class="ri-menu-line"></i>
         </button>
       </nav>
     </header>
 
     <section class="wrapper">
       <div class="container">
         <div class="grid-cols-2">
           <div class="grid-item-1">
              <h1 class="main-heading">
               Welcome to <span>OPIUM</span>
               <br />
            
             </h1>
             <p class="info-text">
                Experience seamless event planning at your fingertips! Introducing OPIUM, where every detail meets perfection. Effortlessly create, organize, and elevate your events with our intuitive app.
             </p>
 
             <div class="btn_wrapper">
               <button class="btn signupbtn" id = "signup">
                 REGISTER <i class="ri-arrow-right-line"></i>
               </button>
 
               <button class="btn signinbtn" id = "signin">LOGIN</button>
             </div>
           </div>
         </div>
       </div>
     </section>
 
     <section class="wrapper">
       <div class="container" data-aos="fade-up" data-aos-duration="1000">
         <div class="grid-cols-3">
           <div class="grid-col-item">
             <div class="icon">
             <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm306.7 69.1L162.4 380.6c-19.4 7.5-38.5-11.6-31-31l55.5-144.3c3.3-8.5 9.9-15.1 18.4-18.4l144.3-55.5c19.4-7.5 38.5 11.6 31 31L325.1 306.7c-3.2 8.5-9.9 15.1-18.4 18.4zM288 256a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/></svg>
            </div>
             <div class="featured_info">
               <span>Explore Events</span>
               <p>
                 Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore
                 ratione facilis animi voluptas exercitationem molestiae.
               </p>
             </div>
           </div>
           <div class="grid-col-item">
             <div class="icon">
             <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#fd6003}</style><path d="M128 0c17.7 0 32 14.3 32 32V64H288V32c0-17.7 14.3-32 32-32s32 14.3 32 32V64h48c26.5 0 48 21.5 48 48v48H0V112C0 85.5 21.5 64 48 64H96V32c0-17.7 14.3-32 32-32zM0 192H448V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V192zM329 305c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-95 95-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L329 305z"/></svg>             </div>
             <div class="featured_info">
               <span>Create Event</span>
               <p>
                 Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut
                 ipsum esse corrupti. Quo, labore debitis!
               </p>
             </div>
           </div>
           <div class="grid-col-item">
             <div class="icon">
             <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#fd6003}</style><path d="M272.2 64.6l-51.1 51.1c-15.3 4.2-29.5 11.9-41.5 22.5L153 161.9C142.8 171 129.5 176 115.8 176H96V304c20.4 .6 39.8 8.9 54.3 23.4l35.6 35.6 7 7 0 0L219.9 397c6.2 6.2 16.4 6.2 22.6 0c1.7-1.7 3-3.7 3.7-5.8c2.8-7.7 9.3-13.5 17.3-15.3s16.4 .6 22.2 6.5L296.5 393c11.6 11.6 30.4 11.6 41.9 0c5.4-5.4 8.3-12.3 8.6-19.4c.4-8.8 5.6-16.6 13.6-20.4s17.3-3 24.4 2.1c9.4 6.7 22.5 5.8 30.9-2.6c9.4-9.4 9.4-24.6 0-33.9L340.1 243l-35.8 33c-27.3 25.2-69.2 25.6-97 .9c-31.7-28.2-32.4-77.4-1.6-106.5l70.1-66.2C303.2 78.4 339.4 64 377.1 64c36.1 0 71 13.3 97.9 37.2L505.1 128H544h40 40c8.8 0 16 7.2 16 16V352c0 17.7-14.3 32-32 32H576c-11.8 0-22.2-6.4-27.7-16H463.4c-3.4 6.7-7.9 13.1-13.5 18.7c-17.1 17.1-40.8 23.8-63 20.1c-3.6 7.3-8.5 14.1-14.6 20.2c-27.3 27.3-70 30-100.4 8.1c-25.1 20.8-62.5 19.5-86-4.1L159 404l-7-7-35.6-35.6c-5.5-5.5-12.7-8.7-20.4-9.3C96 369.7 81.6 384 64 384H32c-17.7 0-32-14.3-32-32V144c0-8.8 7.2-16 16-16H56 96h19.8c2 0 3.9-.7 5.3-2l26.5-23.6C175.5 77.7 211.4 64 248.7 64H259c4.4 0 8.9 .2 13.2 .6zM544 320V176H496c-5.9 0-11.6-2.2-15.9-6.1l-36.9-32.8c-18.2-16.2-41.7-25.1-66.1-25.1c-25.4 0-49.8 9.7-68.3 27.1l-70.1 66.2c-10.3 9.8-10.1 26.3 .5 35.7c9.3 8.3 23.4 8.1 32.5-.3l71.9-66.4c9.7-9 24.9-8.4 33.9 1.4s8.4 24.9-1.4 33.9l-.8 .8 74.4 74.4c10 10 16.5 22.3 19.4 35.1H544zM64 336a16 16 0 1 0 -32 0 16 16 0 1 0 32 0zm528 16a16 16 0 1 0 0-32 16 16 0 1 0 0 32z"/></svg>
             </div>
             <div class="featured_info">
               <span>Make Friends</span>
               <p>
                 Lorem ipsum dolor sit amet consectetur adipisicing elit. Non
                 nostrum voluptate totam ipsa corrupti vero!
               </p>
             </div>
           </div>
         </div>
       </div>
     </section>
     <div class = "bottomPart">
      <section class = "contact">
        <div class = "content">
          <h2>Contact Us</h2>
          <p>Wheter you are curious about features, we are ready to answer your all questions </p>
        </div>
        <div class = "container2">
          <div class = "contactInfo">
            <div class = "box">
              <div class = "icon2"><i class="ri-map-pin-fill"></i></div>
              <div class = "text">
                <h3>Address</h3>
                <p>4671  Sugar Camp Road, <br>Owatonna, Minnesota, <br>55060</p>
              </div>
            </div>
            <div class = "box">
              <div class = "icon2"><i class="ri-mail-fill"></i></div>
              <div class = "text">
                <h3>E - Mail</h3>
                <p>deneme@deneme.com</p>
              </div>
            </div>      
            <div class = "box">
              <div class = "icon2"><i class="ri-phone-fill"></i></div>
              <div class = "text">
                <h3>Phone</h3>
                <p>+000000000</p>
              </div>
            </div>               
          </div>
          <div class = "contactForm">
            <form action="">
              <h2>Send Message</h2>
              <div class = "inputBox">
                <input type="text" name="" required="required">
                <span>Full Name</span>
              </div>
              <div class = "inputBox">
                <input type="email" name="" required="required">
                <span>E-Mail</span>
              </div>
              <div class = "inputBox">
                <textarea required = "required"></textarea>
                <span>Type your Message...</span>
              </div>
              <div class = "inputBox">
                <input type="submit" value="Send">
              </div>            
            </form>
          </div>
        </div>
      </section>
     </div>

     <div class  = "login-register">
     <div class="container3">
          <div class="forms">
              <div class="form login">
                  <span class="title">Login</span>
                  <form action="loginFB.php" method="post">
                      <div class="input-field">
                          <input type="text" name = "emailLOG" placeholder="Enter your email" required>
                          <i class='bx bxs-envelope'></i>
                      </div>
                      <div class="input-field">
                          <input type="password" name="passwordLOG" class = "password" placeholder="Enter your password" required>
                          <i class="ri-lock-fill"></i>
                          <i class="ri-eye-off-fill" id = "eye1"></i>
                      </div>
                      <div class="checkbox-text">
                          <div class="checkbox-content">
                              <input type="checkbox" id="logCheck">
                              <label for="logCheck" class="text">Remember me</label>
                          </div>
                          
                          <a href="#" class="text">Forgot password?</a>
                      </div>
                      <div class="input-field button">
                          <input type="submit" value="Login">
                      </div>
                  </form>
                  <div class="login-signup">
                      <span class="text">Not a member?
                          <a href="#" class="text signup-link">Signup Now</a>
                      </span>
                  </div>
              </div>
              <!-- Registration Form -->
              <div class="form signup">
                  <span class="title">Registration</span>
                  <form action="registerFB.php" method="post">
                      <div class="input-field">
                          <input type="text" name = "fullnameREG" placeholder="Enter full name" required>
                          <i class="ri-user-fill"></i>
                      </div>                     
                      <div class="input-field">
                          <input type="text" name = "usernameREG" placeholder="Enter username" required>
                          <i class="ri-user-fill"></i>
                      </div>
                      <div class="input-field">
                          <input type="text" name = "emailREG" placeholder="Enter your email" required>
                          <i class='bx bxs-envelope'></i>
                      </div>
                      <div class="input-field">
                          <input type="password" name = "passwordREG" class = "password" placeholder="Create a password" required>
                          <i class="ri-lock-fill"></i>
                      </div>
                      <div class="input-field">
                          <input type="password" name = "passwordREG2" class = "password" placeholder="Confirm a password" required>
                          <i class="ri-lock-fill"></i>
                          <i class="ri-eye-off-fill" id = "eye1"></i>
                      </div>
                      <div class="checkbox-text">
                          <div class="checkbox-content">
                              <input type="checkbox" id="termCon">
                              <label for="termCon" class="text">I accepted all terms and conditions</label>
                          </div>
                      </div>
                      <div class="input-field button">
                          <input type="submit" value="Signup">
                      </div>
                  </form>
                  <div class="login-signup">
                      <span class="text">Already a member?
                          <a href="#" class="text login-link">Login Now</a>
                      </span>
                  </div>
              </div>
          </div>
      </div>
     </div>
     <script src="landing-script.js?rand=<?php echo rand(); ?>"></script>

    </body>
 </html>