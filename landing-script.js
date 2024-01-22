const navId = document.getElementById("nav_menu"),
ToggleBtnId = document.getElementById("toggle_btn"),
CloseBtnId = document.getElementById("close_btn");

ToggleBtnId.addEventListener("click", () => {
navId.classList.add("show");
});


CloseBtnId.addEventListener("click", () => {
navId.classList.remove("show");
});


AOS.init();


gsap.from(".logo", {
opacity: 0,
y: -10,
delay: 1,
duration: 0.5,
});
gsap.from(".toggle_btn", {
opacity: 0,
y: -10,
delay: 1.4,
duration: 0.5,
});

gsap.from(".main-heading", {
opacity: 0,
y: 20,
delay: 1.8,
duration: 1,
});

gsap.from(".info-text", {
opacity: 0,
y: 20,
delay: 2.2,
duration: 1,
});

gsap.from(".btn_wrapper", {
opacity: 0,
y: 20,
delay: 2.2,
duration: 1,
});

const theme = document.querySelector('#signin');
const theme2 = document.querySelector('#signup');

const themeModal = document.querySelector('.login-register');
// Opens Modal
const openThemeModal = () => {
    themeModal.style.display = 'grid';
    container.classList.remove("active");
}

// Closes Modal
const closeThemeModal = (e) => {
    if(e.target.classList.contains('login-register')) {
        themeModal.style.display = 'none';
    }
}


const container = document.querySelector(".container3"),
      pwShowHide = document.querySelectorAll("#eye1"),
      pwFields = document.querySelectorAll(".password"),
      signUp = document.querySelector(".signup-link"),
      login = document.querySelector(".login-link");


const openThemeModal2 = () => {
    themeModal.style.display = 'grid';
    container.classList.add("active");
}


themeModal.addEventListener('click', closeThemeModal);
theme.addEventListener('click', openThemeModal);

theme2.addEventListener('click', openThemeModal2);



// js code to show/hide password and change icon
pwShowHide.forEach(eyeIcon => {
    eyeIcon.addEventListener("click", () => {
        pwFields.forEach(pwField => {
            if (pwField.type === "password") {
                pwField.type = "text";
                eyeIcon.classList.replace("ri-eye-off-fill", "ri-eye-fill");
            } else {
                pwField.type = "password";
                eyeIcon.classList.replace("ri-eye-fill", "ri-eye-off-fill");
            }
        });
    });
});


    // js code to appear signup and login form
    signUp.addEventListener("click", ( )=>{
        container.classList.add("active");
    });
    login.addEventListener("click", ( )=>{
        container.classList.remove("active");
    });