<?php
// ========================================================
// GDPR Consent Banner - остаточна версія
// При відмові показує повідомлення зверху з можливістю прийняти знову
// ========================================================

$current_page = basename($_SERVER['PHP_SELF']);

$lang = match($current_page) {
    'ua.php' => 'uk',
    'ru.php' => 'ru',
    'en.php' => 'en',
    default  => 'lt'
};

$consent = [
    'lt' => [
        'text'       => 'Mes naudojame slapukus, kad pagerintume jūsų patirtį svetainėje. Naršydami toliau, jūs sutinkate su mūsų slapukų politika.',
        'accept'     => 'Sutinku',
        'reject'     => 'Atmesti',
        'warning'    => 'Jūs atsisakėte slapukų. Kai kurios funkcijos gali veikti ne visai teisingai.',
        'accept_again' => 'Priimti slapukus',
        'link_text'  => 'Skaityti daugiau',
        'link_url'   => '/privatumo-politika.php'
    ],
    'ru' => [
        'text'       => 'Мы используем файлы cookie для улучшения вашего опыта. Продолжая просмотр, вы соглашаетесь с нашей политикой cookie.',
        'accept'     => 'Согласен',
        'reject'     => 'Отклонить',
        'warning'    => 'Вы отклонили использование cookie. Некоторые функции могут работать некорректно.',
        'accept_again' => 'Принять cookie',
        'link_text'  => 'Подробнее',
        'link_url'   => '/privatumo-politika.php'
    ],
    'uk' => [
        'text'       => 'Ми використовуємо файли cookie для покращення вашого досвіду. Продовжуючи перегляд, ви погоджуєтеся з нашою політикою cookie.',
        'accept'     => 'Погоджуюсь',
        'reject'     => 'Відхилити',
        'warning'    => 'Ви відхилили використання cookie. Деякі функції можуть працювати некоректно.',
        'accept_again' => 'Прийняти cookie знову',
        'link_text'  => 'Докладніше',
        'link_url'   => '/privatumo-politika.php'
    ],
    'en' => [
        'text'       => 'We use cookies to improve your experience. By continuing to browse, you agree to our cookie policy.',
        'accept'     => 'I Agree',
        'reject'     => 'Reject',
        'warning'    => 'You rejected cookies. Some features may not work correctly.',
        'accept_again' => 'Accept cookies again',
        'link_text'  => 'Learn more',
        'link_url'   => '/privacy-policy.php'
    ]
];

$current = $consent[$lang];
?>

<!-- GDPR Consent Banner -->
<div id="gdpr-consent" class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-2xl z-[9999] transform translate-y-full transition-transform duration-300">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12 py-5 flex flex-col sm:flex-row items-center gap-4">
        <div class="flex-1 text-sm text-gray-700">
            <?= htmlspecialchars($current['text']) ?>
            <a href="<?= htmlspecialchars($current['link_url']) ?>" class="text-cyan-600 hover:text-cyan-700 underline ml-1">
                <?= htmlspecialchars($current['link_text']) ?>
            </a>
        </div>
        
        <div class="flex gap-3">
            <button onclick="rejectGDPR()" 
                    class="px-6 py-3 border border-gray-300 hover:border-red-300 text-gray-700 hover:text-red-600 rounded-2xl transition-all">
                <?= htmlspecialchars($current['reject']) ?>
            </button>
            <button onclick="acceptGDPR()" 
                    class="px-8 py-3 bg-cyan-500 hover:bg-cyan-600 text-white font-medium rounded-2xl transition-all">
                <?= htmlspecialchars($current['accept']) ?>
            </button>
        </div>
    </div>
</div>

<!-- Повідомлення при відмові (зверху сторінки) -->
<div id="gdpr-reject-message" class="hidden fixed top-0 left-0 right-0 bg-amber-100 border-b border-amber-400 py-4 z-[9998]">
    <div class="max-w-screen-2xl mx-auto px-5 lg:px-12 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3 text-amber-800 text-sm">
            <span class="text-xl">⚠️</span>
            <span><?= htmlspecialchars($current['warning']) ?></span>
        </div>
        
        <div class="flex gap-3">
            <button onclick="closeRejectMessage()" 
                    class="px-5 py-2 text-amber-700 hover:text-amber-900 font-medium">
                Закрити
            </button>
            <button onclick="acceptGDPRAgain()" 
                    class="px-6 py-2 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-xl transition-all">
                <?= htmlspecialchars($current['accept_again']) ?>
            </button>
        </div>
    </div>
</div>

<script>
function acceptGDPR() {
    document.getElementById('gdpr-consent').style.transform = 'translateY(100%)';
    localStorage.setItem('gdpr_accepted', 'true');
    document.getElementById('gdpr-reject-message').classList.add('hidden');
}

function rejectGDPR() {
    document.getElementById('gdpr-consent').style.transform = 'translateY(100%)';
    document.getElementById('gdpr-reject-message').classList.remove('hidden');
    localStorage.setItem('gdpr_accepted', 'rejected');
}

function closeRejectMessage() {
    document.getElementById('gdpr-reject-message').classList.add('hidden');
}

function acceptGDPRAgain() {
    acceptGDPR(); // повторно приймаємо
}

// Перевірка при завантаженні сторінки
window.addEventListener('load', function() {
    const status = localStorage.getItem('gdpr_accepted');
    
    if (status === 'true') {
        document.getElementById('gdpr-consent').style.display = 'none';
    } 
    else if (status === 'rejected') {
        document.getElementById('gdpr-consent').style.display = 'none';
        document.getElementById('gdpr-reject-message').classList.remove('hidden');
    } 
    else {
        // Показуємо банер з затримкою
        setTimeout(() => {
            document.getElementById('gdpr-consent').style.transform = 'translateY(0)';
        }, 1200);
    }
});
</script>
