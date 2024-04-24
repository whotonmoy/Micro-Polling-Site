function validateEmail(email) {

	let emailRegEx = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

	if (emailRegEx.test(email))
		return true;
	else
		return false;
}

function validateUsername(uname) {

	let unameRegEx = /^[a-zA-Z0-9_]+$/;

	if (unameRegEx.test(uname))
		return true;
	else
		return false;
}

function validatePWD(pwd) {

	let pwdRegEx = /^(?=.*[^a-zA-Z])(?!.*\s).{8,}$/;
	if (pwdRegEx.test(pwd))
		return true;
	else
		return false;
}

function validateAvatar(avatar) {

	let avatarRegEx = /^[^\n]+.[a-zA-Z]{3,4}$/;

	if (avatarRegEx.test(avatar))
		return true;
	else
		return false;
}

function validateQuestion(question) {

	let questionRegEx = /^.{1,99}$/;

	if (questionRegEx.test(question))
		return true;
	else
		return false;
}

function validateAnswer(answer) {

	let answerRegEx = /^(|\s*.{1,49})$/;

	if (answerRegEx.test(answer))
		return true;
	else
		return false;
}

// Validation for Date and Times
function validateDateTime(dt) {
	
	let dtRegEx = /^(000[1-9]|00[1-9]\d|0[1-9]\d\d|100\d|10[1-9]\d|1[1-9]\d{2}|[2-9]\d{3}|[1-9]\d{4}|1\d{5}|2[0-6]\d{4}|27[0-4]\d{3}|275[0-6]\d{2}|2757[0-5]\d|275760)-(0[1-9]|1[012])-(0[1-9]|[12]\d|3[01])T(0\d|1\d|2[0-4]):(0\d|[1-5]\d)(?::(0\d|[1-5]\d))?(?:.(00\d|0[1-9]\d|[1-9]\d{2}))?$/;

	if (dtRegEx.test(dt))
		return true;
	else
		return false;
}

//	Function for Login Form Validation
function validateLogin(event) {

	let uname = document.getElementById("username");
	let pwd = document.getElementById("password");

	let erroruser = document.getElementById("error-text-username");
	let errorpass = document.getElementById("error-text-password");


	let formIsValid = true;

	if (!validateUsername(uname.value)) {

		uname.classList.add("input-error");
		erroruser.classList.remove("error-text-hidden");
		erroruser.classList.add("error-msg");

		if (uname.value == "") {
			erroruser.textContent = "Username can not be blank"
		}
		else {
			erroruser.textContent = "Username is invalid!"
		}

		formIsValid = false;
	}
	else {

		uname.classList.remove("input-error");
		erroruser.classList.remove("error-msg");
		erroruser.classList.add("error-text-hidden");
	}

	if (!validatePWD(pwd.value)) {

		pwd.classList.add("input-error");
		errorpass.classList.remove("error-text-hidden");
		errorpass.classList.add("error-msg");

		if (pwd.value == "") {
			errorpass.textContent = "Password can not be blank";
		}
		else {
			errorpass.textContent = "Password is Incorrect!";
		}

		formIsValid = false;
	}
	else {

		pwd.classList.remove("input-error");
		errorpass.classList.remove("error-msg");
		errorpass.classList.add("error-text-hidden");
	}

	if (!formIsValid) {
		event.preventDefault();
	} else {
		console.log("Validation successful, sending data to the server");
	}
}

// Function for Signup Form Validation
// function validateSignup(event) {

// 	let email = document.getElementById("email");
// 	let uname = document.getElementById("username");
// 	let pwd = document.getElementById("password");
// 	let cpwd = document.getElementById("cpassword");
// 	let avatar = document.getElementById("profilephoto");

// 	let erroremail = document.getElementById("error-text-email");
// 	let erroruser = document.getElementById("error-text-username");
// 	let errorpass = document.getElementById("error-text-password");
// 	let errorcpass = document.getElementById("error-text-cpassword");
// 	let erroravatar = document.getElementById("error-text-profilephoto");


// 	let formIsValid = true;

// 	if (!validateEmail(email.value)) {

// 		email.classList.add("input-error");
// 		erroremail.classList.remove("error-text-hidden");
// 		erroremail.classList.add("error-msg");
// 		formIsValid = false;
// 	}
// 	else {

// 		email.classList.remove("input-error");
// 		erroremail.classList.remove("error-msg");
// 		erroremail.classList.add("error-text-hidden");
// 	}

// 	if (!validateUsername(uname.value)) {

// 		uname.classList.add("input-error");
// 		erroruser.classList.remove("error-text-hidden");
// 		erroruser.classList.add("error-msg");
// 		formIsValid = false;
// 	}
// 	else {

// 		uname.classList.remove("input-error");
// 		erroruser.classList.remove("error-msg");
// 		erroruser.classList.add("error-text-hidden");
// 	}

// 	if (!validatePWD(pwd.value)) {

// 		pwd.classList.add("input-error");
// 		errorpass.classList.remove("error-text-hidden");
// 		errorpass.classList.add("error-msg");
// 		formIsValid = false;
// 	}
// 	else {

// 		pwd.classList.remove("input-error");
// 		errorpass.classList.remove("error-msg");
// 		errorpass.classList.add("error-text-hidden");
// 	}

// 	if (pwd.value != cpwd.value) {

// 		formIsValid = false;
// 	}

// 	if (!validateAvatar(avatar.value)) {

// 		avatar.classList.add("input-error");
// 		erroravatar.classList.remove("error-text-hidden");
// 		erroravatar.classList.add("error-msg");
// 		formIsValid = false;
// 	}
// 	else {

// 		avatar.classList.remove("input-error");
// 		erroravatar.classList.remove("error-msg");
// 		erroravatar.classList.add("error-text-hidden");
// 	}

// 	if (!formIsValid) {
// 		event.preventDefault();
// 	} else {
// 		console.log("Validation successful, sending data to the server");
// 	}

// }

// Function for Poll Creation form validation
// function validateCreation(event) {

// 	let question = document.getElementById("question");
// 	let ans1 = document.getElementById("ans1");
// 	let ans2 = document.getElementById("ans2");
// 	let ans3 = document.getElementById("ans3");
// 	let ans4 = document.getElementById("ans4");
// 	let ans5 = document.getElementById("ans5");

// 	let opentime = document.getElementById("opentime");
// 	let closetime = document.getElementById("closetime");

// 	let erroropentime = document.getElementById("error-text-opentime")
// 	let errorclosetime = document.getElementById("error-text-closetime")

// 	let formIsValid = true;

// 	if (!validateQuestion(question.value)) {

// 		question.classList.add("input-error");
// 		formIsValid = false;

// 	}

// 	if (ans1.value == "" && ans2.value == "" && ans3.value == "" && ans4.value == "" && ans5.value == "") {
// 		ans1.classList.add("input-error");
// 		ans2.classList.add("input-error");
// 		ans3.classList.add("input-error");
// 		ans4.classList.add("input-error");
// 		ans5.classList.add("input-error");
// 		formIsValid = false;
// 	}
// 	else {
// 		if (!validateAnswer(ans1.value)) {
// 			formIsValid = false;
// 		}

// 		if (!validateAnswer(ans2.value)) {
// 			formIsValid = false;
// 		}

// 		if (!validateAnswer(ans3.value)) {
// 			formIsValid = false;
// 		}

// 		if (!validateAnswer(ans4.value)) {
// 			formIsValid = false;
// 		}

// 		if (!validateAnswer(ans5.value)) {
// 			formIsValid = false;
// 		}
// 	}

// 	if (!validateDateTime(opentime.value)) {

// 		opentime.classList.add("input-error");
// 		erroropentime.classList.remove("error-text-hidden");
// 		erroropentime.classList.add("error-msg");
// 		formIsValid = false;
// 	}
// 	else {
// 		opentime.classList.remove("input-error");
// 		erroropentime.classList.remove("error-msg");
// 		erroropentime.classList.add("error-text-hidden");
// 	}

// 	if (!validateDateTime(closetime.value)) {

// 		closetime.classList.add("input-error");
// 		errorclosetime.classList.remove("error-text-hidden");
// 		errorclosetime.classList.add("error-msg");
// 		formIsValid = false;
// 	}
// 	else {
// 		closetime.classList.remove("input-error");
// 		errorclosetime.classList.remove("error-msg");
// 		errorclosetime.classList.add("error-text-hidden");
// 	}

// 	if (!formIsValid) {
// 		event.preventDefault();
// 	}
// 	else {
// 		console.log("Validation successful, sending data to the server");
// 	}
// }


// Event Handler Functions
function usernameHandler(event) {
	let uname = event.target;

	let erroruser = document.getElementById("error-text-username");
	let erroruserinput = document.getElementById("username");


	if (!validateUsername(uname.value)) {

		erroruserinput.classList.add("input-error");
		erroruser.classList.remove("error-text-hidden");
		erroruser.classList.add("error-msg");
	}
	else {

		erroruserinput.classList.remove("input-error");
		erroruser.classList.remove("error-msg");
		erroruser.classList.add("error-text-hidden");
	}
}

function emailHandler(event) {
	let email = event.target;

	let erroremail = document.getElementById("error-text-email");
	let erroremailinput = document.getElementById("email");


	if (!validateEmail(email.value)) {

		erroremailinput.classList.add("input-error");
		erroremail.classList.remove("error-text-hidden");
		erroremail.classList.add("error-msg");
	}
	else {

		erroremailinput.classList.remove("input-error");
		erroremail.classList.remove("error-msg");
		erroremail.classList.add("error-text-hidden");
	}
}

function pwdHandler(event) {
	let pwd = event.target;

	let errorpass = document.getElementById("error-text-password");
	let errorpassinput = document.getElementById("password");

	if (!validatePWD(pwd.value)) {

		errorpassinput.classList.add("input-error");
		errorpass.classList.remove("error-text-hidden");
		errorpass.classList.add("error-msg");
	}
	else {

		errorpassinput.classList.remove("input-error");
		errorpass.classList.remove("error-msg");
		errorpass.classList.add("error-text-hidden");
	}
}

function cpwdHandler(event) {
	let pwd = document.getElementById("password");
	let cpwd = event.target;

	let errorcpass = document.getElementById("error-text-cpassword");
	let errorcpassinput = document.getElementById("cpassword");

	if (pwd.value !== cpwd.value) {
		errorcpassinput.classList.add("input-error");
		errorcpass.classList.remove("error-text-hidden");
		errorcpass.classList.add("error-msg");
	}
	else {

		errorcpassinput.classList.remove("input-error");
		errorcpass.classList.remove("error-msg");
		errorcpass.classList.add("error-text-hidden");
	}
}

function avatarHandler(event) {
	let avatar = event.target;

	let erroravatar = document.getElementById("error-text-profilephoto");

	if (!validateAvatar(avatar.value)) {

		erroravatar.classList.remove("error-text-hidden");
		erroravatar.classList.add("error-msg");
	}
	else {

		erroravatar.classList.remove("error-msg");
		erroravatar.classList.add("error-text-hidden");
	}

}


// Function to count characters in an input field and display the count to the user
function countCharacters(inputField, countElement, maxlength) {

	var strLength = inputField.value.length;
	var charRemain = (maxlength - strLength);
	var excess = (strLength - maxlength);

	if (charRemain < 0) {
		countElement.textContent = "Character Limit of " + maxlength + " is exceeded by " + excess + " characters";
		countElement.style.color = "red";
	}
	else {
		countElement.textContent = strLength + " characters entered. " + charRemain + " characters left";
		countElement.style.color = "grey";
	}
}

// character count event handler for Poll Creation Form
function charcountHandler(event) {

	const questionlength = 99;
	const answerlength = 49;

	let questionInput = document.getElementById("question");
	let answer1Input = document.getElementById("ans1");
	let answer2Input = document.getElementById("ans2");
	let answer3Input = document.getElementById("ans3");
	let answer4Input = document.getElementById("ans4");
	let answer5Input = document.getElementById("ans5");

	var questionerror = document.getElementById("error-text-question");
	var ans1error = document.getElementById("error-text-ans1");
	var ans2error = document.getElementById("error-text-ans2");
	var ans3error = document.getElementById("error-text-ans3");
	var ans4error = document.getElementById("error-text-ans4");
	var ans5error = document.getElementById("error-text-ans5");

	countCharacters(questionInput, questionerror, questionlength);
	countCharacters(answer1Input, ans1error, answerlength);
	countCharacters(answer2Input, ans2error, answerlength);
	countCharacters(answer3Input, ans3error, answerlength);
	countCharacters(answer4Input, ans4error, answerlength);
	countCharacters(answer5Input, ans5error, answerlength);
}

// Code for Assignment 6
let lastPollId = -1;

// Function to update the poll list
function updatePollList() {
    // Create an XMLHttpRequest object
    const xhr = new XMLHttpRequest();
    // Configure the request
    xhr.open("GET", `get_new_polls.php?lastPollId=${lastPollId}`, true);
    // Set up a handler for when the request is complete
    xhr.onload = function () {
        if (xhr.status === 200) {
            const newPolls = JSON.parse(xhr.responseText);
            // Update the lastPollId with the ID of the latest poll
            if (newPolls.length > 0) {
                lastPollId = newPolls[0].id;
            }
            // Get the poll list element
            const pollList = document.getElementById("pollList");
            // Remove old poll items if needed
            while (pollList.children.length >= 5) {
                pollList.removeChild(pollList.lastChild);
            }
            // Add new poll items to the top of the list
            for (const poll of newPolls) {
                const li = document.createElement("li");
                const link = document.createElement("a");
                link.href = poll.link;
                link.textContent = poll.question;
                li.appendChild(link);
                pollList.insertBefore(li, pollList.firstChild);
            }
        }
    };
    // Send the request
    xhr.send();
}
// Update the poll list initially and then every 90 seconds
updatePollList();
setInterval(updatePollList, 90000); // 90 seconds