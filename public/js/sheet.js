const questionOptions = document.querySelectorAll(".question-options");

const getCsrfToken = () => {
    return document.head.querySelector('meta[name="csrf-token"]').content;
};

const saveOneQuestion = async (body = {}) => {
    return new Promise(async (resolve, reject) => {
        const endpoint = saveOneQuestionApiEndpoint;
        try {
            const res = await fetch(endpoint, {
                method: "POST",
                body: JSON.stringify(body),
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": getCsrfToken(),
                },
            });
            const data = await res.json();
            resolve({ res, data });
        } catch (error) {
            reject({ error });
        }
    });
};

questionOptions.forEach((option) => {
    option.addEventListener("change", async function () {
        const { idQuestion, option } = this.dataset;

        // tampalkan status loading
        const status = document.querySelector(
            ".saved_status_question_" + idQuestion
        );
        status.classList.remove("d-none");
        status.textContent = "Sedang menyimpan...";

        const { res, data } = await saveOneQuestion({
            idQuestion,
            option,
        });
        // if success
        if (res.ok && data.success) {
            status.textContent = "Tersimpan";
        }
    });
});

// handle collapse accordion
const toggleCollapseAccordionQuestion = document.getElementById(
    "toggle-collapse-accordion-question"
);

toggleCollapseAccordionQuestion.addEventListener("click", function () {
    const questionAccordions = document.querySelectorAll(".accordion");

    if (toggleCollapseAccordionQuestion.dataset.open == "1") {
        toggleCollapseAccordionQuestion.textContent = "Buka Semua Soal";
        toggleCollapseAccordionQuestion.dataset.open = "0";
    } else {
        toggleCollapseAccordionQuestion.textContent = "Tutup Semua Soal";
        toggleCollapseAccordionQuestion.dataset.open = "1";
    }

    questionAccordions.forEach((accordion) => {
        accordion.querySelector(".accordion-button").click();
        toggleCollapseAccordionQuestion.textContent;
    });
});

const backToTopButton = document.getElementById("back-to-top");

window.addEventListener("scroll", function () {
    if (this.scrollY > 10) {
        backToTopButton.classList.remove("d-none");
    } else {
        backToTopButton.classList.add("d-none");
    }
});

backToTopButton.addEventListener("click", () => {
    scrollTo({
        top: 0,
        behavior: "smooth",
    });
});

const timeLeftOfExam = document.getElementById("timeleft-of-exam");

timeLeftOfExam && timeleft(timeLeftOfExam.dataset.endTimeExam);

// handle countdown waktu ujian
function timeleft(endTime) {
    const endDatetime = new Date(endTime);
    const now = new Date();

    const examTimeleftInterval = setInterval(function () {
        const now = new Date().getTime();
        const timeleft = endDatetime.getTime() - now;

        let hours = Math.floor(
            (timeleft % (1000 * 60 * 60 * 60)) / (1000 * 60 * 60)
        );
        let minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((timeleft % (1000 * 60)) / 1000);

        // add prefix number
        hours = ("0" + hours).slice(-2);
        minutes = ("0" + minutes).slice(-2);
        seconds = ("0" + seconds).slice(-2);

        timeLeftOfExam.textContent = hours + ":" + minutes + ":" + seconds;
    }, 1000);

    setTimeout(function () {
        // akan dieksekusi jika waktu ujian habis
        clearInterval(examTimeleftInterval);
        handleSubmitFinishExam();
    }, endDatetime.getTime() - now.getTime());
}

function handleSubmitFinishExam() {
    alert(
        "Waktu Sudah Habis!!, Tekan OK untuk menyimpan jawaban ujian saat ini!"
    );
    document.getElementById("form-save-exam").submit();
}
