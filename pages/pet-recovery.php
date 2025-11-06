<?php
require_once '../config/db.php';
require_once '../includes/functions.php';
require_once '../middleware/require_login.php';

// Get support message
$support_message = getSupportMessage();

include_once '../components/header.php';
include_once '../components/navbar.php';
?>

<main class="recovery-resources-page">
    <h1>Pet Recovery Resources</h1>

    <section class="support-message">
        <div class="message-box">
            <h2>Support Message</h2>
            <p id="supportMessage"><?php echo $support_message; ?></p>
        </div>
    </section>

    <section class="resources-section">
        <h2>Animal Shelters in Athens</h2>
        <div class="resource-cards">
            <div class="resource-card">
                <h3>Local Shelters</h3>
                <ul>
                    <li><strong>Animal Action Greece</strong> (Plaka/Athens Center) - +30 210 384 0010</li>
                    <li><strong>Stray.gr</strong> (Northern Suburbs – Marousi) - +30 694 429 2229</li>
                    <li><strong>SPAZ - Society for the Protection of Stray Animals</strong> (Glyfada) - +30 210 894 2060</li>
                    <li><strong>Kivotos tou Kosmou - Animal Shelter</strong> (Kolonos) - +30 210 514 1935</li>
                    <li><strong>Filozoiki Neas Filadelfeias</strong> (Nea Filadelfeia) - +30 210 251 2340</li>
                </ul>
            </div>

            <div class="resource-card">
                <h3>Online Support Groups</h3>
                <ul>
                    <li><a href="https://www.facebook.com/groups/straysofgreece" target="_blank" rel="noopener">Strays of Greece – Facebook Group</a></li>
                    <li><a href="https://www.facebook.com/groups/greekanimalrescue/" target="_blank" rel="noopener">Greek Animal Rescue Group</a></li>
                    <li><a href="https://www.animalactiongreece.org" target="_blank" rel="noopener">Animal Action Greece Website</a></li>
                    <li><a href="https://stray.gr" target="_blank" rel="noopener">Stray.gr Community</a></li>
                </ul>
            </div>
        </div>
    </section>

    <section class="breathing-exercise">
        <h2>Calming Breathing Exercise</h2>
        <p>If you're feeling anxious or stressed, try this simple breathing exercise to help calm your mind.</p>

        <div class="breathing-container">
            <div class="breathing-circle" id="breathingCircle">
                <span class="breathing-text">Breathe</span>
            </div>
            <div class="breathing-instructions" id="breathingInstructions">Breathe in...</div>
            <button class="btn-primary" id="startBreathing">Start Breathing Exercise</button>
        </div>
    </section>

    <section class="resources-section">
        <h2>Educational Resources</h2>

        <div class="resource-article">
            <h3>Pet Identification Tips</h3>
            <ul>
                <li><strong>Microchipping:</strong> Ensure your pet has a microchip and that your contact information is up-to-date in the registry.</li>
                <li><strong>ID Tags:</strong> Always keep a collar with ID tags on your pet, even indoors.</li>
                <li><strong>Updated Photos:</strong> Take clear photos of your pet regularly, including distinguishing features.</li>
                <li><strong>DNA Records:</strong> Consider keeping a DNA sample of your pet for identification purposes.</li>
            </ul>
        </div>

        <div class="resource-article">
            <h3>Recovery Strategies</h3>
            <ul>
                <li><strong>Immediate Action:</strong> Report to local shelters and animal control within the first hour.</li>
                <li><strong>Ground Search:</strong> Search your immediate neighborhood within a 3-mile radius.</li>
                <li><strong>Scent Items:</strong> Leave familiar-smelling items near where your pet was last seen.</li>
                <li><strong>Posters:</strong> Create bright, waterproof posters with a clear photo and your contact information.</li>
                <li><strong>Social Media:</strong> Post on local social media groups and lost pet websites.</li>
            </ul>
        </div>

        <div class="resource-article">
            <h3>Why Pets Don't Always Return Home</h3>
            <p>Contrary to popular belief, many pets do not find their way home on their own. This is because:</p>
            <ul>
                <li>They may become disoriented, especially in unfamiliar areas</li>
                <li>Fear can cause them to hide and avoid human contact</li>
                <li>Injury or illness may prevent them from traveling</li>
                <li>They may be picked up by well-meaning individuals</li>
                <li>New scents and surroundings can confuse their sense of direction</li>
            </ul>
            <p>This is why active searching is essential when your pet goes missing.</p>
        </div>
    </section>
</main>

<?php include_once '../components/footer.php'; ?>

<script src="/assets/js/main.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    setInterval(() => {
        const randomIndex = Math.floor(Math.random() * supportMessages.length);
        supportMessageElement.textContent = supportMessages[randomIndex];
    }, 20000);

    const startButton = document.getElementById('startBreathing');
    const breathingCircle = document.getElementById('breathingCircle');
    const instructions = document.getElementById('breathingInstructions');

    startButton.addEventListener('click', () => {
        startButton.style.display = 'none';
        breathingCircle.classList.add('animate');

        let phase = 'inhale';
        instructions.textContent = 'Breathe in...';

        const breathingInterval = setInterval(() => {
            if (phase === 'inhale') {
                phase = 'hold';
                instructions.textContent = 'Hold...';
            } else if (phase === 'hold') {
                phase = 'exhale';
                instructions.textContent = 'Breathe out...';
            } else {
                phase = 'inhale';
                instructions.textContent = 'Breathe in...';
            }
        }, 4000);

        setTimeout(() => {
            clearInterval(breathingInterval);
            breathingCircle.classList.remove('animate');
            instructions.textContent = 'Great job! Feel free to try again.';
            startButton.style.display = 'block';
        }, 12000);
    });
});
</script>