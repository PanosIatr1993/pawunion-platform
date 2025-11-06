<?php
require_once '../config/db.php';
require_once '../includes/functions.php';
require_once '../middleware/require_login.php';

include_once '../components/header.php';
include_once '../components/navbar.php';
?>

<main class="ethical-guide-page">
    <h1>Ethical Pet Finder Guide</h1>
    
    <section class="intro-section">
        <p>When you find a lost pet, it's important to act responsibly and ethically. This guide helps you understand why reporting found pets is essential and how to handle these situations properly.</p>
    </section>
    
    <section class="guide-section">
        <h2>Why Reporting Is Essential</h2>
        
        <div class="guide-content">
            <div class="guide-item">
                <h3>Reuniting Families</h3>
                <p>Every lost pet has a family who is likely searching desperately for their beloved companion. By reporting a found pet, you increase the chances of reuniting them with their worried family.</p>
            </div>
            
            <div class="guide-item">
                <h3>Legal Considerations</h3>
                <p>In Greece, pets are legally considered property. Keeping a found pet without making a reasonable effort to locate the owner may have legal consequences. Reporting protects both you and the pet.</p>
            </div>
            
            <div class="guide-item">
                <h3>Animal Welfare</h3>
                <p>Pets that are separated from their families often experience stress and anxiety. Quickly returning them to their familiar environment is in their best interest.</p>
            </div>
            
            <div class="guide-item">
                <h3>Community Trust</h3>
                <p>When people in Athens responsibly report found pets, it builds a stronger sense of trust and responsibility in the community—one where lost pets are more likely to find their way home.</p>
            </div>
        </div>
    </section>
    
    <section class="guide-section">
        <h2>How to Handle a Found Pet Responsibly</h2>
        
        <div class="guide-content steps">
            <div class="guide-step">
                <div class="step-number">1</div>
                <div class="step-content">
                    <h3>Safety First</h3>
                    <p>Approach the animal carefully, as lost pets may be frightened. If the animal appears aggressive or injured, contact animal control or a local Athens municipality shelter instead of handling it yourself.</p>
                </div>
            </div>
            
            <div class="guide-step">
                <div class="step-number">2</div>
                <div class="step-content">
                    <h3>Check for ID</h3>
                    <p>Look for a collar with ID tags, which may have the owner's contact information. If there’s a tag but no response, leave a message and proceed to the next steps.</p>
                </div>
            </div>
            
            <div class="guide-step">
                <div class="step-number">3</div>
                <div class="step-content">
                    <h3>Report the Found Pet</h3>
                    <p>Report the pet here on PawUnion. Include a photo and description, and notify local shelters and vets such as the Athens Stray Animal Shelter or Animal Action Greece.</p>
                </div>
            </div>
            
            <div class="guide-step">
                <div class="step-number">4</div>
                <div class="step-content">
                    <h3>Check for a Microchip</h3>
                    <p>Visit a vet or shelter in your area to scan for a microchip. This is often the fastest way to identify the owner.</p>
                </div>
            </div>
            
            <div class="guide-step">
                <div class="step-number">5</div>
                <div class="step-content">
                    <h3>Spread the Word</h3>
                    <p>Post the pet’s photo in local Facebook groups or neighborhood notice boards. Areas like Kifisia, Pagrati, or Nea Smyrni have active community groups for lost pets.</p>
                </div>
            </div>
            
            <div class="guide-step">
                <div class="step-number">6</div>
                <div class="step-content">
                    <h3>Verify Ownership</h3>
                    <p>If someone claims the pet, ask for proof such as photos, vet papers, or descriptions of unique traits that confirm ownership.</p>
                </div>
            </div>
        </div>
    </section>
    
    <section class="guide-section">
        <h2>Ethical Considerations When Finding a Pet</h2>
        
        <div class="ethical-dos-donts">
            <div class="ethical-do">
                <h3>Do:</h3>
                <ul>
                    <li>Report the found pet promptly</li>
                    <li>Provide temporary shelter if safe and possible</li>
                    <li>Take clear, recent photos</li>
                    <li>Make an honest effort to locate the owner</li>
                    <li>Note when and where the pet was found</li>
                </ul>
            </div>
            
            <div class="ethical-dont">
                <h3>Don't:</h3>
                <ul>
                    <li>Assume the pet is abandoned</li>
                    <li>Give the pet away without searching for its owner</li>
                    <li>Make negative assumptions about the owner</li>
                    <li>Remove ID tags or collars</li>
                    <li>Judge based on appearance—many lost pets may look rough after days outside</li>
                </ul>
            </div>
        </div>
    </section>
    
    <section class="cta-section">
        <h2>Found a Pet?</h2>
        <p>Be a hero today. Help them get back home.</p>
        <a href="report.php" class="btn-primary">Report a Found Pet</a>
    </section>
</main>

<?php include_once '../components/footer.php'; ?>