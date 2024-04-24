var email = document.getElementById("email");
var uname = document.getElementById("username");
var pwd = document.getElementById("password");
var cpwd = document.getElementById("cpassword");
var avatar = document.getElementById("profilephoto");

email.addEventListener("blur", emailHandler);
uname.addEventListener("blur", usernameHandler);
pwd.addEventListener("blur", pwdHandler);
cpwd.addEventListener("blur", cpwdHandler);
avatar.addEventListener("blur", avatarHandler);

// Signup Form Validation Event Listeners
// var signupform = document.getElementById("signup-form");
// signupform.addEventListener("submit", validateSignup);