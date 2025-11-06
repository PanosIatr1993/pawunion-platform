// Main JavaScript File for Paw Union App

document.addEventListener('DOMContentLoaded', function () {
    rotateSupportMessages();
    initEmoticonSelector();
    bindFAQToggles();
    bindTabSwitcher();
});

// Support message rotation
function rotateSupportMessages() {
    const supportMessageElement = document.getElementById('supportMessage');
    if (!supportMessageElement) return;

    const messages = [
        "Every hour counts! Start searching now.",
        "You're not alone in this journey.",
        "Stay strong - many pets are found within 48 hours.",
        "Your community is here to support you.",
        "Take a deep breath - we'll help you through this.",
        "Remember to take care of yourself while searching.",
        "Thousands of pets are reunited with their families every day.",
        "Your dedication makes all the difference.",
        "Don't lose hope - persistence is key to finding your pet.",
        "Your pet is looking for you too.",
        "We understand your worry - let us help you through this process.",
        "Take it one step at a time - you're doing great.",
        "Reach out for help when you need it - that's what we're here for.",
        "Remember to check shelters daily - new pets arrive constantly.",
        "Your detailed report increases the chances of finding your pet."
    ];

    supportMessageElement.textContent = messages[Math.floor(Math.random() * messages.length)];
    setInterval(() => {
        supportMessageElement.textContent = messages[Math.floor(Math.random() * messages.length)];
    }, 20000);
}

// Emoticon selector (used in report.php)
function initEmoticonSelector() {
    const emoticonButtons = document.querySelectorAll('.emoticon-btn');
    const selectedInput = document.getElementById('selected_emoticon');
    if (!emoticonButtons.length || !selectedInput) return;

    emoticonButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            emoticonButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            selectedInput.value = btn.dataset.emoticon;
        });
    });
}

// FAQ toggler (used in help.php)
function bindFAQToggles() {
    const faqs = document.querySelectorAll('.faq-question');
    faqs.forEach(faq => {
        faq.addEventListener('click', () => {
            const answer = faq.nextElementSibling;
            const icon = faq.querySelector('.toggle-icon');
            const isVisible = answer.style.display === 'block';
            answer.style.display = isVisible ? 'none' : 'block';
            icon.textContent = isVisible ? '+' : '-';
        });
    });
}

// Admin panel tab system (if applicable)
function bindTabSwitcher() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const tabName = btn.getAttribute('data-tab');
            tabButtons.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));

            btn.classList.add('active');
            document.getElementById(tabName)?.classList.add('active');
        });
    });
}