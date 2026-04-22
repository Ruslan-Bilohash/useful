# Email Sender – Smart Resume Distribution System

Powerful and safe PHP script for sending personalized resumes.

### 🔥 Main Features

- **Smart duplicate protection** — automatically skips already sent emails using `emaillog.txt`
- **Safe sending with delays** — random pause between 12–20 seconds to avoid spam filters
- **Clean email processing** — automatically removes `u003e` prefixes and duplicates
- **Detailed logging** — every successful and failed send is logged with timestamp
- **Professional HTML email template** — modern, responsive and branded design
- **Easy configuration** — all settings are at the top of the file

### What I specialize in

I am a PHP Developer & Automation Specialist with extensive experience in:
- Mass data collection and lead generation
- Writing automation scripts for scraping and parsing
- Safe bulk email sending without getting banned
- Building custom CRM systems for sales and recruitment automation
- Creating powerful tools for searching IT and marketing companies

### How it works

1. Put your cleaned email list into `email.txt` (one email per line)
2. Configure your SMTP settings in the script
3. Run the script — it will send your resume to each new email with a professional message
4. All sent emails are saved in `emaillog.txt` so you can safely restart the script anytime

### Email Content Includes

- Introduction as a motivated PHP developer in Norway
- Information about relocation and Norwegian language learning
- Detailed description of technical skills and automation expertise
- Portfolio and GitHub links
- Note: *"Found you thanks to a tool I created for searching IT and marketing companies."*

### Technologies

- PHP 8+
- PHPMailer (included in `/PHPMailer` folder)
- SMTP with SSL support (Hostinger example)
- HTML5 responsive email template

### Files in the project

- `sender.php` — main smart sending script
- `email.txt` — your list of emails (one per line)
- `emaillog.txt` — log of sent emails
- `PHPMailer/` — library for sending emails

### Usage

```bash
php sender.php
