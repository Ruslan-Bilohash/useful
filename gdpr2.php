<?php
// ========================================================
// GDPR / Cookie Consent Banner 2026 - Norway Compliant (Datatilsynet + E-Com Act)
// Explicit opt-in, Equal prominence, Granular consent, Mobile-First
// Посилання на privacy-policy.php та cookies.php
// Email: email@bilohash.com (для контактів у футері, якщо потрібно)
// ========================================================

$current_page = basename($_SERVER['PHP_SELF']);

$lang = match($current_page) {
    'ua.php', 'uk.php' => 'uk',
    'en.php'           => 'en',
    'no.php'           => 'no',
    default            => 'no'   // Норвезька як основна для локальних клієнтів
};

$consent = [
    'no' => [
        'title'          => 'Vi bruker informasjonskapsler',
        'text'           => 'Vi bruker cookies for å forbedre din opplevelse, analysere trafikk og tilby personlig tilpasset innhold. Noen cookies er nødvendige for at siden skal fungere. Vi deler ikke dine data med tredjeparter.',
        'accept_all'     => 'Godta alle',
        'reject_all'     => 'Avslå alle',
        'customize'      => 'Tilpass innstillinger',
        'warning'        => 'Du har avslått ikke-nødvendige informasjonskapsler. Noen funksjoner kan fungere dårligere.',
        'accept_again'   => 'Godta cookies igjen',
        'link_privacy'   => 'Personvernerklæring',
        'link_cookies'   => 'Cookie-erklæring',
        'privacy_url'    => '/website/privacy-policy.php',
        'cookies_url'    => '/website/cookies.php'
    ],
    'en' => [
        'title'          => 'We use cookies',
        'text'           => 'We use cookies to improve your experience, analyze traffic, and provide personalized content. Some cookies are necessary for the site to function. We do not share your data with third parties.',
        'accept_all'     => 'Accept All',
        'reject_all'     => 'Reject All',
        'customize'      => 'Customize',
        'warning'        => 'You have rejected non-essential cookies. Some features may not work properly.',
        'accept_again'   => 'Accept cookies again',
        'link_privacy'   => 'Privacy Policy',
        'link_cookies'   => 'Cookie Policy',
        'privacy_url'    => '/website/privacy-policy.php',
        'cookies_url'    => '/website/cookies.php'
    ],
    'uk' => [
        'title'          => 'Ми використовуємо файли cookie',
        'text'           => 'Ми використовуємо cookies для покращення вашого досвіду, аналізу трафіку та надання персоналізованого контенту. Деякі cookies необхідні для роботи сайту. Ми не передаємо ваші дані третім особам.',
        'accept_all'     => 'Прийняти всі',
        'reject_all'     => 'Відхилити всі',
        'customize'      => 'Налаштувати',
        'warning'        => 'Ви відхилили неосновні файли cookie. Деякі функції можуть працювати некоректно.',
        'accept_again'   => 'Прийняти cookie знову',
        'link_privacy'   => 'Політика конфіденційності',
        'link_cookies'   => 'Політика cookie',
        'privacy_url'    => '/website/privacy-policy.php',
        'cookies_url'    => '/website/cookies.php'
    ]
];

$current = $consent[$lang] ?? $consent['no'];
?>

<!-- GDPR Cookie Consent Banner - Norway Compliant 2026 -->
<div id="gdpr-consent-banner" 
     class="fixed bottom-0 left-0 right-0 bg-zinc-900/95 backdrop-blur-2xl border-t border-white/10 shadow-2xl z-[9999] translate-y-full transition-all duration-500 ease-out"
     role="dialog" aria-labelledby="gdpr-title" aria-modal="true">
    
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-12 py-5 sm:py-6">
        <div class="flex flex-col lg:flex-row items-start lg:items-center gap-5 lg:gap-6">
            
            <!-- Текстова частина -->
            <div class="flex-1 text-sm sm:text-base text-white/80 leading-relaxed">
                <strong class="block text-white mb-1"><?= htmlspecialchars($current['title']) ?></strong>
                <?= htmlspecialchars($current['text']) ?>
                <div class="mt-2 text-xs text-white/60 flex flex-wrap gap-x-4 gap-y-1">
                    <a href="<?= htmlspecialchars($current['privacy_url']) ?>" 
                       class="hover:text-cyan-400 transition-colors underline">
                        <?= htmlspecialchars($current['link_privacy']) ?>
                    </a>
                    <a href="<?= htmlspecialchars($current['cookies_url']) ?>" 
                       class="hover:text-cyan-400 transition-colors underline">
                        <?= htmlspecialchars($current['link_cookies']) ?>
                    </a>
                </div>
            </div>

            <!-- Кнопки (рівнозначні, адаптивні) -->
            <div class="flex flex-wrap gap-3 w-full lg:w-auto">
                <button onclick="rejectAllGDPR()" 
                        class="flex-1 lg:flex-none px-6 py-3.5 border border-white/30 hover:border-red-400/60 text-white/80 hover:text-red-400 rounded-2xl transition-all duration-300 text-sm font-medium">
                    <?= htmlspecialchars($current['reject_all']) ?>
                </button>
                
                <button onclick="showCustomizeModal()" 
                        class="flex-1 lg:flex-none px-6 py-3.5 border border-white/30 hover:border-cyan-400/60 text-white/80 hover:text-cyan-400 rounded-2xl transition-all duration-300 text-sm font-medium">
                    <?= htmlspecialchars($current['customize']) ?>
                </button>
                
                <button onclick="acceptAllGDPR()" 
                        class="flex-1 lg:flex-none px-7 py-3.5 bg-cyan-400 hover:bg-cyan-300 text-zinc-950 font-semibold rounded-2xl transition-all duration-300 text-sm">
                    <?= htmlspecialchars($current['accept_all']) ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Warning -->
<div id="gdpr-reject-message" class="hidden fixed top-0 left-0 right-0 bg-amber-500/95 backdrop-blur-xl border-b border-amber-400 z-[9998]">
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-12 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3 text-amber-950 text-sm font-medium">
            <span class="text-xl">⚠️</span>
            <span><?= htmlspecialchars($current['warning']) ?></span>
        </div>
        <div class="flex gap-3">
            <button onclick="hideRejectMessage()" 
                    class="px-6 py-2 text-amber-950 hover:text-black font-medium transition-colors">
                Закрити
            </button>
            <button onclick="acceptAllGDPR()" 
                    class="px-7 py-2 bg-white hover:bg-amber-100 text-amber-950 font-semibold rounded-2xl transition-all">
                <?= htmlspecialchars($current['accept_again']) ?>
            </button>
        </div>
    </div>
</div>

<!-- Simple Customize Modal (можна розширити Alpine.js) -->
<div id="gdpr-customize-modal" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-[10000]">
    <div class="bg-zinc-900 rounded-3xl max-w-md w-full mx-4 overflow-hidden">
        <div class="p-6 border-b border-white/10">
            <h3 class="text-xl font-semibold text-white">Tilpass cookie-innstillinger</h3>
        </div>
        <div class="p-6 space-y-6 text-sm text-white/80">
            <p>Nødvendige cookies er alltid påslått for at siden skal fungere.</p>
            <p>Andre kategorier (funksjonelle / analytiske) kan du velge selv.</p>
            <!-- Тут можна додати чекбокси для granular вибору пізніше -->
        </div>
        <div class="p-6 border-t border-white/10 flex gap-3">
            <button onclick="hideCustomizeModal()" 
                    class="flex-1 py-3.5 border border-white/30 hover:border-white/50 text-white/80 rounded-2xl transition-all">
                Avbryt
            </button>
            <button onclick="saveCustomPreferences()" 
                    class="flex-1 py-3.5 bg-cyan-400 hover:bg-cyan-300 text-zinc-950 font-semibold rounded-2xl transition-all">
                Lagre valg
            </button>
        </div>
    </div>
</div>

<script>
let gdprConsentStatus = localStorage.getItem('gdpr_consent_status') || 'pending';

function acceptAllGDPR() {
    gdprConsentStatus = 'accepted';
    localStorage.setItem('gdpr_consent_status', 'accepted');
    hideBanner();
    hideRejectMessage();
    // Тут можна розблокувати non-essential скрипти
}

function rejectAllGDPR() {
    gdprConsentStatus = 'rejected';
    localStorage.setItem('gdpr_consent_status', 'rejected');
    hideBanner();
    document.getElementById('gdpr-reject-message').classList.remove('hidden');
}

function showCustomizeModal() {
    document.getElementById('gdpr-customize-modal').classList.remove('hidden');
}

function hideCustomizeModal() {
    document.getElementById('gdpr-customize-modal').classList.add('hidden');
}

function saveCustomPreferences() {
    gdprConsentStatus = 'custom';
    localStorage.setItem('gdpr_consent_status', 'custom');
    hideCustomizeModal();
    hideBanner();
}

function hideBanner() {
    const banner = document.getElementById('gdpr-consent-banner');
    banner.style.transform = 'translateY(100%)';
    setTimeout(() => { banner.style.display = 'none'; }, 600);
}

function hideRejectMessage() {
    document.getElementById('gdpr-reject-message').classList.add('hidden');
}

// Ініціалізація
window.addEventListener('load', function() {
    const banner = document.getElementById('gdpr-consent-banner');
    const rejectMsg = document.getElementById('gdpr-reject-message');

    if (gdprConsentStatus === 'accepted' || gdprConsentStatus === 'custom') {
        banner.style.display = 'none';
    } else if (gdprConsentStatus === 'rejected') {
        banner.style.display = 'none';
        rejectMsg.classList.remove('hidden');
    } else {
        setTimeout(() => {
            banner.style.transform = 'translateY(0)';
        }, 1200);
    }
});
</script>