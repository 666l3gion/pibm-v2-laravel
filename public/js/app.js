const showPasswordButtons = document.querySelectorAll(".btn-show-password");

showPasswordButtons.forEach((btn) => {
    btn.addEventListener("click", function (e) {
        e.preventDefault(); // if tag is link
        const inputPasswordTarget = this.dataset.inputPasswordTarget;
        const inputPassword = document.querySelector(inputPasswordTarget);
        if (inputPassword.getAttribute("type").toLowerCase() === "text") {
            inputPassword.setAttribute("type", "password");
        } else {
            inputPassword.setAttribute("type", "text");
        }
    });
});

// handle disable form when submiting
const forms = document.querySelectorAll(".form-disable");

forms?.forEach((form) => {
    form.addEventListener("submit", function (e) {
        document.getElementById("progress-bar-app").classList.remove("d-none");
        // this.classList.add("position-relative");
        // const element = document.createElement("div");
        // element.className =
        //     "position-absolute start-0 end-0 top-0 bottom-0 d-flex align-items-center justify-content-center";
        // element.innerHTML = `<small>Tunggu...</small>`;
        // element.style.backgroundColor = "rgba(255,255,255,.6)";
        // element.style.zIndex = 100;
        // this.appendChild(element);
        const btnSubmit = this.querySelector('button[type="submit"]');
        btnSubmit.textContent = btnSubmit.textContent + "...";
        btnSubmit.disabled = true;
    });
});
