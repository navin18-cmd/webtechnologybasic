const API_BASE = "php";
const ringLength = 2 * Math.PI * 70;

document.addEventListener("DOMContentLoaded", () => {
    const page = document.body.dataset.page;
    attachCommonFormValidation(page);

    if (page === "index") {
        initDashboard();
    }

    if (page === "history") {
        loadHistory();
    }

    if (page === "contact") {
        setupContactForm();
    }
});

function attachCommonFormValidation(page) {
    if (page === "signup") {
        const form = document.getElementById("signupForm");
        const error = document.getElementById("signupError");
        form?.addEventListener("submit", (event) => {
            const name = form.name.value.trim();
            const email = form.email.value.trim();
            const password = form.password.value;

            if (!name || !validateEmail(email) || password.length < 6) {
                event.preventDefault();
                error.textContent = "Enter valid name, email, and password (min 6 chars).";
                return;
            }

            error.textContent = "";
        });
    }

    if (page === "login") {
        const form = document.getElementById("loginForm");
        const error = document.getElementById("loginError");
        form?.addEventListener("submit", (event) => {
            const email = form.email.value.trim();
            const password = form.password.value;

            if (!validateEmail(email) || password.length < 6) {
                event.preventDefault();
                error.textContent = "Enter a valid email and password.";
                return;
            }

            error.textContent = "";
        });
    }
}

async function initDashboard() {
    const goalForm = document.getElementById("goalForm");
    const markDoneBtn = document.getElementById("markDoneBtn");
    const goalFormError = document.getElementById("goalFormError");
    const actionMessage = document.getElementById("actionMessage");
    const userMessage = document.getElementById("userMessage");

    if (goalForm) {
        goalForm.addEventListener("submit", async (event) => {
            event.preventDefault();

            const name = goalForm.goalName.value.trim();
            const days = Number.parseInt(goalForm.goalDays.value, 10);

            if (!name || Number.isNaN(days) || days < 1 || days > 365) {
                goalFormError.textContent = "Enter a goal name and days between 1 and 365.";
                return;
            }

            goalFormError.textContent = "";
            const response = await postData(`${API_BASE}/goal.php`, { goal_name: name, total_days: days });

            if (!response.success) {
                goalFormError.textContent = response.message || "Could not start goal.";
                return;
            }

            actionMessage.textContent = "Goal started successfully.";
            goalForm.reset();
            await refreshDashboard();
        });
    }

    if (markDoneBtn) {
        markDoneBtn.addEventListener("click", async () => {
            const response = await postData(`${API_BASE}/progress.php`, {});

            if (!response.success) {
                actionMessage.textContent = response.message || "Could not mark today done.";
                return;
            }

            actionMessage.textContent = response.message || "Marked for today.";
            await refreshDashboard();
        });
    }

    const statusRes = await fetchJson(`${API_BASE}/status.php`);
    if (!statusRes.loggedIn) {
        userMessage.textContent = "Please login or signup to start tracking your goal.";
    } else {
        userMessage.textContent = `Welcome, ${statusRes.user_name}.`;
    }

    await refreshDashboard();
}

async function refreshDashboard() {
    const dashboardRes = await fetchJson(`${API_BASE}/goal.php`);
    const goal = dashboardRes.goal;
    const ringProgress = document.getElementById("ringProgress");
    const currentGoalName = document.getElementById("currentGoalName");
    const currentDay = document.getElementById("currentDay");
    const totalDays = document.getElementById("totalDays");
    const streakCount = document.getElementById("streakCount");
    const progressPercent = document.getElementById("progressPercent");
    const missedNotice = document.getElementById("missedNotice");

    if (!ringProgress || !currentGoalName || !currentDay || !totalDays || !streakCount || !progressPercent || !missedNotice) {
        return;
    }

    if (!goal) {
        currentGoalName.textContent = "No active goal";
        currentDay.textContent = "0";
        totalDays.textContent = "0";
        streakCount.textContent = "0";
        progressPercent.textContent = "0%";
        ringProgress.style.strokeDasharray = String(ringLength);
        ringProgress.style.strokeDashoffset = String(ringLength);
        missedNotice.hidden = true;
        return;
    }

    const doneDays = Number.parseInt(goal.done_days, 10) || 0;
    const maxDays = Number.parseInt(goal.total_days, 10) || 1;
    const streak = Number.parseInt(goal.streak, 10) || 0;
    const percent = Math.min(100, Math.round((doneDays / maxDays) * 100));
    const offset = ringLength - (ringLength * percent) / 100;

    currentGoalName.textContent = goal.goal_name;
    currentDay.textContent = String(doneDays);
    totalDays.textContent = String(maxDays);
    streakCount.textContent = String(streak);
    progressPercent.textContent = `${percent}%`;

    ringProgress.style.strokeDasharray = String(ringLength);
    ringProgress.style.strokeDashoffset = String(offset);
    missedNotice.hidden = !goal.missed_day;
}

async function loadHistory() {
    const list = document.getElementById("historyList");
    const message = document.getElementById("historyMessage");
    if (!list || !message) {
        return;
    }

    const res = await fetchJson(`${API_BASE}/history.php`);
    if (!res.success) {
        message.textContent = res.message || "Please login to view history.";
        return;
    }

    if (!Array.isArray(res.history) || res.history.length === 0) {
        message.textContent = "No activity yet. Start and mark your goal daily.";
        return;
    }

    message.textContent = "";
    list.innerHTML = "";
    res.history.forEach((item) => {
        const li = document.createElement("li");
        li.textContent = `${item.goal_name} - Done on ${item.done_date}`;
        list.appendChild(li);
    });
}

function setupContactForm() {
    const form = document.getElementById("contactForm");
    const feedback = document.getElementById("contactFeedback");

    form?.addEventListener("submit", (event) => {
        event.preventDefault();
        const name = document.getElementById("contactName").value.trim();
        const email = document.getElementById("contactEmail").value.trim();
        const message = document.getElementById("contactMessage").value.trim();

        if (!name || !validateEmail(email) || message.length < 5) {
            feedback.textContent = "Please enter valid details before sending.";
            return;
        }

        feedback.textContent = "Thanks! Your message is recorded.";
        form.reset();
    });
}

async function fetchJson(url) {
    try {
        const res = await fetch(url, { credentials: "include" });
        return await res.json();
    } catch (error) {
        return { success: false, message: "Network error." };
    }
}

async function postData(url, payload) {
    try {
        const res = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            credentials: "include",
            body: JSON.stringify(payload)
        });

        return await res.json();
    } catch (error) {
        return { success: false, message: "Network error." };
    }
}

function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}