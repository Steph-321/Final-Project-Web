function showRegister() {
    document.getElementById("loginPage").style.display = "none";
    document.getElementById("registerPage").style.display = "block";
}

function showLogin() {
    document.getElementById("registerPage").style.display = "none";
    document.getElementById("loginPage").style.display = "block";
}

function nextStep(step) {
    document.getElementById("step" + step).style.display = "none";
    document.getElementById("step" + (step + 1)).style.display = "block";

    document.getElementById("s" + step).classList.remove("active");
    document.getElementById("s" + (step + 1)).classList.add("active");
}

function prevStep(step) {
    document.getElementById("step" + step).style.display = "none";
    document.getElementById("step" + (step - 1)).style.display = "block";

    document.getElementById("s" + step).classList.remove("active");
    document.getElementById("s" + (step - 1)).classList.add("active");
}

function login() {
    alert("Logging in...");
}

function register() {
    alert("Registration complete!");
}
