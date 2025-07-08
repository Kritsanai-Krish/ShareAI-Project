# ShareAI Project

Simple prototype for a group subscription sharing platform. Backend uses PHP with LiteDB via COM on Windows.

## Requirements
- PHP 7.4+ on Windows
- COM extension enabled
- LiteDB.dll registered for COM

## Structure
- `config/` – configuration and database connection
- `classes/` – PHP classes (User, Group, etc.)
- `api/` – REST style endpoints returning JSON
- `public/` – static frontend files

The CSS included is adapted from `examplecss.html`.

## Running
Place `LiteDB.dll` and register it for COM. The web root should point to the
`public/` folder. Ensure `uploads/` and `data/` directories are writable for the
web server.

## API Summary
- `api/register.php` – create an account
- `api/login.php` – login and start session
- `api/create_group.php` – create a new sharing group
- `api/join_group.php` – join via invite code
- `api/upload_payment.php` – upload proof image
- `api/confirm_payment.php` – owner approves or rejects payment
- `api/get_credentials.php` – fetch decrypted credentials if paid
- `api/set_credentials.php` – owner stores encrypted credentials
- `api/get_messages.php` / `api/send_message.php` – group chat via long polling
- `api/get_dashboard.php` – list user groups and payment status
