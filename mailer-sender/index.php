<?php
/**
 * 🔥 SMART VERSION — Resume sending via NAV IT
 * With duplicate protection + enhanced professional signature
 * Log: emaillog.txt
 */

echo "<h1>🚀 Smart Resume Sending for NAV IT</h1>";
echo "<p><strong>Start:</strong> " . date('Y-m-d H:i:s') . "</p><hr>";

// ==================== SETTINGS ====================
$yourName     = "Ruslan Bilohash";
$yourEmail    = "email@bilohash.com";
$phone        = "+47 462 55 885";
$smtpHost     = "smtp.hostinger.com";
$smtpPort     = 465;
$smtpUsername = "email@bilohash.com";
$smtpPassword = "password";
$smtpSecure   = "ssl";

$minDelay     = 12;
$maxDelay     = 20;

$emailsFile   = "email.txt";      // file with email addresses
$logFile      = "emaillog.txt";   // sending log

// ==================== PHPMailer ====================
$phpmailerPath = __DIR__ . '/PHPMailer/src/';
require_once $phpmailerPath . 'Exception.php';
require_once $phpmailerPath . 'PHPMailer.php';
require_once $phpmailerPath . 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->CharSet     = 'UTF-8';
$mail->SMTPAuth    = true;
$mail->SMTPDebug   = 0;
$mail->Debugoutput = 'html';
$mail->Host        = $smtpHost;
$mail->Port        = $smtpPort;
$mail->SMTPSecure  = $smtpSecure;
$mail->Username    = $smtpUsername;
$mail->Password    = $smtpPassword;

$mail->SMTPOptions = [
    'ssl' => [
        'verify_peer'       => false,
        'verify_peer_name'  => false,
        'allow_self_signed' => true
    ]
];

$mail->setFrom($yourEmail, $yourName);

// ==================== PROFESSIONAL EMAIL BODY (FULLY IN ENGLISH) ====================
$emailBody = '
<div style="font-family: Arial, sans-serif; max-width: 680px; margin: 0 auto; background: #ffffff; border: 1px solid #e0e0e0; border-radius: 10px; overflow: hidden;">
    <div style="background: linear-gradient(135deg, #007bff, #0056b3); color: white; padding: 35px; text-align: center;">
        <h2>Ruslan Bilohash — PHP Developer & Automation Specialist</h2>
    </div>
    
    <div style="padding: 40px 35px; line-height: 1.8; color: #333333; font-size: 16px;">
       
        <p>Dear Hiring Manager,</p>
       
        <p>I am a motivated self-taught PHP developer currently living in Drammen, Norway. 
        After relocating from Ukraine due to the war, I am actively learning Norwegian and looking for 
        part-time, internship or junior positions in web development.</p>
       
        <p>With strong practical experience in building websites, admin panels, multilingual systems and automation tools from scratch, 
        I believe I can bring real value to your team.</p>

        <p>I also specialize in <strong>mass data collection</strong>, writing automation scripts for lead generation, 
        email collection, safe bulk mailing without getting banned, and creating custom CRM systems for full sales and recruitment automation.</p>
       
        <div style="background: #f8f9fa; padding: 25px; border-left: 5px solid #007bff; margin: 30px 0;">
            <strong>Ruslan Bilohash</strong><br>
            Drammen, Norway<br>
            Phone: ' . $phone . ' (WhatsApp / Telegram)<br>
            Email: rbilohash@gmail.com<br><br>
            <strong>Portfolio:</strong> <a href="https://bilohash.com">bilohash.com</a><br>
            <strong>GitHub:</strong> <a href="https://github.com/ruslan-bilohash">github.com/ruslan-bilohash</a>
        </div>
       
        <p>I would be grateful for the opportunity to discuss how my skills and motivation can support your projects.</p>
       
        <p><em>Found you thanks to a tool I created for searching IT and marketing companies.</em></p>
       
        <p>Thank you for your time and consideration.</p>
       
        <p>Best regards,<br>
        <strong>Ruslan Bilohash</strong></p>
    </div>
</div>';

// ==================== LOAD EMAILS AND LOG ====================
if (!file_exists($emailsFile)) {
    die("<h2 style='color:red;'>File $emailsFile not found!</h2>");
}

// Load already sent emails
$sentEmails = [];
if (file_exists($logFile)) {
    $sentLines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($sentLines as $line) {
        if (strpos($line, '| SUCCESS |') !== false) {
            $parts = explode('|', $line);
            if (isset($parts[2])) {
                $sentEmails[trim($parts[2])] = true;
            }
        }
    }
}

// Load and clean emails
$lines = file($emailsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$uniqueEmails = [];

foreach ($lines as $line) {
    $email = trim($line);
    $email = preg_replace('/^u003e/', '', $email);   // remove u003e prefix
    $email = strtolower(trim($email));

    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !isset($sentEmails[$email])) {
        $uniqueEmails[$email] = true;
    }
}

$emailList = array_keys($uniqueEmails);
$total = count($emailList);

echo "<p><strong>Total unique emails to send:</strong> <b>$total</b></p>";
echo "<p><strong>Already sent before:</strong> " . count($sentEmails) . "</p><hr>";

// ==================== SENDING PROCESS ====================
$sentNow = 0;
foreach ($emailList as $index => $toEmail) {
    $num = $index + 1;
    $percent = round(($num / $total) * 100, 1);

    echo "<p><strong>[$num/$total] — $percent%</strong> → $toEmail</p>";

    try {
        $mail->clearAddresses();
        $mail->addAddress($toEmail);
        $mail->Subject = "PHP Developer from Drammen – Open to Part-time / Internship";
        $mail->isHTML(true);
        $mail->Body = $emailBody;
        $mail->AltBody = "Ruslan Bilohash - PHP Developer & Automation Specialist from Drammen, Norway";

        $mail->send();

        $sentNow++;
        file_put_contents($logFile, date("Y-m-d H:i:s") . " | SUCCESS | " . $toEmail . "\n", FILE_APPEND);
        echo "<span style='color:green;'>✓ Sent successfully</span><br>";

    } catch (Exception $e) {
        file_put_contents($logFile, date("Y-m-d H:i:s") . " | FAILED | " . $toEmail . " | " . $e->getMessage() . "\n", FILE_APPEND);
        echo "<span style='color:red;'>✗ Error: " . htmlspecialchars($e->getMessage()) . "</span><br>";
    }

    if ($num < $total) {
        $delay = rand($minDelay, $maxDelay);
        echo "<small>⏳ Pause {$delay} seconds...</small><br><br>";
        sleep($delay);
    }
}

echo "<hr>";
echo "<h2 style='color:green;'>🎉 Sending completed!</h2>";
echo "<p><strong>Total processed:</strong> $total</p>";
echo "<p><strong>Successfully sent now:</strong> $sentNow</p>";
echo "<p><strong>Sending log:</strong> <b>$logFile</b></p>";
?>
