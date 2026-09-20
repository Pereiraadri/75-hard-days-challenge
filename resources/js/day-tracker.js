const csrfToken = () => document.querySelector('meta[name="csrf-token"]')?.content ?? '';

async function patch(url) {
    const response = await fetch(url, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': csrfToken(),
            Accept: 'application/json',
        },
    });

    if (!response.ok) {
        throw new Error(`Request failed with status ${response.status}`);
    }

    return response.json();
}

function refreshScore(tracker) {
    const goalCards = tracker.querySelectorAll('[data-goal-toggle]');
    const completedCount = tracker.querySelectorAll('[data-goal-toggle].is-done').length;
    const completionRatio = goalCards.length > 0 ? completedCount / goalCards.length : 0;

    const completedLabel = tracker.querySelector('[data-score-completed]');
    if (completedLabel) {
        completedLabel.textContent = completedCount;
    }

    const ring = tracker.querySelector('[data-score-ring]');
    if (ring) {
        const circumference = 2 * Math.PI * Number(ring.dataset.radius);
        ring.style.strokeDashoffset = circumference - completionRatio * circumference;
    }
}

function lockGoals(tracker) {
    tracker.querySelectorAll('[data-goal-toggle]').forEach((card) => {
        card.classList.add('is-locked');
        card.disabled = true;
    });
}

async function toggleGoal(tracker, card) {
    card.disabled = true;
    card.classList.toggle('is-done');
    refreshScore(tracker);

    try {
        const { completed } = await patch(card.dataset.url);
        card.classList.toggle('is-done', completed);
    } catch {
        card.classList.toggle('is-done');
    } finally {
        card.disabled = false;
        refreshScore(tracker);
    }
}

async function validateDay(tracker, button) {
    const initialLabel = button.textContent;
    button.disabled = true;
    button.textContent = button.dataset.pendingLabel;

    try {
        await patch(tracker.dataset.validateUrl);
        button.textContent = button.dataset.doneLabel;
        button.classList.replace('button--primary', 'button--done');
        lockGoals(tracker);
    } catch {
        button.textContent = initialLabel;
        button.disabled = false;
    }
}

async function unvalidateDay(tracker, button) {
    button.disabled = true;

    try {
        await patch(tracker.dataset.unvalidateUrl);
        window.location.reload();
    } catch {
        button.disabled = false;
    }
}

export default function initDayTracker() {
    const tracker = document.querySelector('[data-day-tracker]');

    if (!tracker) {
        return;
    }

    tracker.addEventListener('click', (event) => {
        const goalCard = event.target.closest('[data-goal-toggle]');
        if (goalCard) {
            toggleGoal(tracker, goalCard);
            return;
        }

        const validateButton = event.target.closest('[data-day-validate]');
        if (validateButton) {
            validateDay(tracker, validateButton);
            return;
        }

        const unvalidateButton = event.target.closest('[data-day-unvalidate]');
        if (unvalidateButton) {
            unvalidateDay(tracker, unvalidateButton);
        }
    });
}
