const questionInput = document.getElementById("question");
const answer1Input = document.getElementById("ans1");
const answer2Input = document.getElementById("ans2");
const answer3Input = document.getElementById("ans3");
const answer4Input = document.getElementById("ans4");
const answer5Input = document.getElementById("ans5");

questionInput.addEventListener("input", charcountHandler);
answer1Input.addEventListener("input", charcountHandler);
answer2Input.addEventListener("input", charcountHandler);
answer3Input.addEventListener("input", charcountHandler);
answer4Input.addEventListener("input", charcountHandler);
answer5Input.addEventListener("input", charcountHandler);

// Poll Creation Form Validation Event Listeners
// var creationform = document.getElementById("pollcreation-form");
// creationform.addEventListener("submit", validateCreation);



