# Brownie Website
 This is the official website of Turtle Pond, run on the PHP/MySQL LAMP stack.
 
 This repository keeps track of the changes made to the static content of the website as well as some dynamic pages like the sub blog and shop.

## Environment Installation
0. Run on an Ubuntu server (tested version: 24.04.2 LTS)
1. Install a web server (tested: apache2)
2. Create a folder for this website in the webserver directory.
3. Run `docker-dev-script.sh` to install necessary PHP files.
4. Complete `.env` file from `.env.sample` (see below)
5. Add `/includes/ganalytics.php`, which is the Google Analytics HTML snippet.
6. Theoretically, you are ready to go now.

## Environment Configuration

Configuration supports a root `.env` file as the canonical source, which should be placed in a designated project root folder as defined in `/includes/dotenv.php`.

### Files involved

- `.env` (root): primary key/value config file, ignored by git.
- `config.php`: keeps legacy globals, now loads values from `.env` when present and otherwise fails if missing.
- `includes/mysql.env.php`: keeps legacy DB array, now loads values from `.env` when present and otherwise fails if missing.
- `includes/dotenv.php`: shared parser/loader used by both files.

### First-time setup

1. Copy `.env.sample` to `.env`.
2. Fill in real values in `.env`.
- Includes references to Discord API IDs and values, Cloudinary API IDs and values, database IDs and values, Twitch/YouTube IDs, etc.

### Array values in `.env`

Array-backed config keys can be provided as JSON (recommended) or comma-separated lists:

- `SUB_PERK_ROLES`
- `IRIAM_STAR_ROLES`
- `BROWNIEVAL_SUB_ONLY_VIDEOS`

Examples:

```dotenv
SUB_PERK_ROLES=["123","456","789"]
IRIAM_STAR_ROLES=111,222,333
```
