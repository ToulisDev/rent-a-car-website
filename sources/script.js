//Είναι το εικονίδιο του nav οταν μικραινει η οθονη σε πλατος 1350px και μικροτερο.
function changeBar(x) {
    x.classList.toggle("changeBar");
}

//Το navigation bar να παραμένει στη κορυφή της σελίδας
window.onscroll = function () { stickyNav() };
var header = document.getElementById("header");
function stickyNav() {
    if (window.pageYOffset > 0) {
        header.classList.add("sticky");
    } else {
        header.classList.remove("sticky");
    }
}


//newsletter form
const form = document.getElementById("newsletter"),
    statusTxt = document.getElementById("statusNewsletter");
form.onsubmit = (e) => {
    console.log(e);
    e.preventDefault();
    form.classList.add("disabled");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "newsletter.php", true);
    xhr.onload = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.response;
            if (response.indexOf("required") != -1 || response.indexOf("valid") != -1 || response.indexOf("failed") != -1 || response.includes("error")) {
                statusTxt.innerText = response;
                statusTxt.style.display = "block";
                statusTxt.style.color = "red";
            } else {
                form.reset();
                setTimeout(() => {
                    statusTxt.style.display = "none";
                    alert("Η Εγγραφή έγινε επιτυχώς!");
                }, 3000);
            }
            statusTxt.innerText = response;
            form.classList.remove("disabled");
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}
