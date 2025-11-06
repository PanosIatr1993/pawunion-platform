<?php
require_once '../config/db.php';
require_once '../includes/functions.php';
require_once '../middleware/require_login.php';

include_once '../components/header.php';
include_once '../components/navbar.php';
?>

<main>
    <h1 class="centrify">FAQ & Help</h1>
    
    <section class="faq-section">
        <h2 class="centrify">Frequently Asked Questions</h2>
        
        <div class="faq-container">
            <?php
            $faqs = [
                [
                    'question' => 'How does Paw Union work?',
                    'answer' => 'Paw Union is a platform designed to help reunite lost pets with their owners. Users can report lost pets, search for found pets in their region, and contact pet owners through our secure messaging system. Region-based searches improve the chances of finding pets nearby.'
                ],
                [
                    'question' => 'How is my pet\'s information used?',
                    'answer' => 'Your pet\'s profile (type, breed, color, last seen location, image, and description) is publicly visible to help with the search. Your personal contact details remain private — other users can reach you via a secure contact form.'
                ],
                [
                    'question' => 'Why does Paw Union use region-based filtering?',
                    'answer' => 'Because most pets are found close to where they went missing, region filtering increases success by focusing on likely areas.'
                ],
                [
                    'question' => 'How does the contact system protect my privacy?',
                    'answer' => 'Messages are relayed through our platform. This way, your email stays hidden, and you choose whether to respond or not.'
                ],
                [
                    'question' => 'What should I do if I find a lost pet?',
                    'answer' => 'Check for ID tags and contact the owner. If unavailable, visit a vet or shelter to scan for a microchip. Then, report the pet on Paw Union. See our <a href="ethical-guide.php">Ethical Guide</a> for full steps.'
                ],
                [
                    'question' => 'How do I update my lost pet\'s status when found?',
                    'answer' => 'Login, go to "My Listings", and use the "Mark as Found" button. This will update the listing and move it to the Found Pets section.'
                ],
                [
                    'question' => 'What resources are available for pet owners looking for lost pets?',
                    'answer' => 'Visit our <a href="pet-recovery.php">Pet Recovery Resources</a> page for educational material, local contacts, and emotional support tools.'
                ]
            ];

            foreach ($faqs as $index => $faq): ?>
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <h3><?= htmlspecialchars($faq['question']) ?></h3>
                        <span class="toggle-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p><?= $faq['answer'] ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    
    <section class="contact-section">
        <h2 class="centrify">Need More Help?</h2>
        <p class="centrify">If your question wasn’t answered above, feel free to reach out directly:</p>
        
        <form action="#" method="post" class="contact-form">
            <div class="form-group">
                <label for="name">Your Name*</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Your Email*</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="subject">Subject*</label>
                <input type="text" id="subject" name="subject" required>
            </div>
            
            <div class="form-group">
                <label for="message">Message*</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            
            <button type="submit" class="btn-primary">Send Message</button>
        </form>
    </section>
</main>

<?php include_once '../components/footer.php'; ?>

<script>
    function toggleFAQ(element) {
        const answer = element.nextElementSibling;
        const icon = element.querySelector('.toggle-icon');

        const isOpen = answer.style.display === 'block';

        // Close all other answers
        document.querySelectorAll('.faq-answer').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.toggle-icon').forEach(i => i.textContent = '+');

        // Toggle selected
        if (!isOpen) {
            answer.style.display = 'block';
            icon.textContent = '-';
        }
    }
</script>