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
        showLoading(this);
    });
});

function showLoading(_this) {
    const btnSubmit = _this.querySelector('button[type="submit"]');
    document.getElementById("progress-bar-app").classList.remove("d-none");
    btnSubmit.textContent = btnSubmit.textContent + "...";
    btnSubmit.disabled = true;
}
