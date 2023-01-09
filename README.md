# Members

Enables membership functionality Craft Starter.

__Proof of Concept only__

## Requirements

This plugin requires Craft CMS 4.3.x or later, and PHP 8.0.2 or later.

Latest version of [Craft 4 Starter](https://github.com/wsydney76/craft4-ddev-starter) must be installed.

## Installation

Update `composer.json`

```json
{
  "minimum-stability": "dev",
  "prefer-stable": true,
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/wsydney76/craft-members"
    }
  ]
}
```

Open your terminal and run the following commands:


```bash
# go to the project directory
cd /path/to/my-project.test

# tell Composer to load the plugin
composer require wsydney76/craft-members

# tell Craft to install the plugin
./craft plugin/install members
```

## Prepare

Tbd.

Currently, this plugin assumes that there are two sites: `en` and `de`, with `en` as primary site.

This is the case with a fresh install of the starter.

Add to `config/general.php`:

```php
// The URI Craft should use for user login on the front end.
->loginPath([
    'de' => 'mitglieder/login',
    'en' => 'members/login'
])

// The URI or URL that Craft should use for Set Password forms on the front end.
->setPasswordPath([
    'de' => 'mitglieder/passwort-vergeben',
    'en' => 'members/set-password',
])

// Whether users should automatically be logged in after activating their account or resetting their password.
->autoLoginAfterAccountActivation(true)

// The URI that users without access to the control panel should be redirected to after activating their account.
->activateAccountSuccessPath([
    'de' => 'mitglieder',
    'en' => 'members',
])

// The URI Craft should redirect to when user token validation fails
->invalidUserTokenPath([
    'de' => 'mitglieder/ungueltig',
    'en' => 'members/invalid',
])
```

## Settings

* Create a `members` user group.
* In `settings`, check `Allow pulic registration` and select  `members` as 'Default User Group'.
* In the plugins settings, enter a custom template path. This template display member specific content on the 'members' page.

## Create pages

Run `craft members/seed`

## Notification Emails

Better matching texts for notification emails are prepared in  `./vendor/wsydney76/craft-members/translations`. Copy them to the `translations` folder of your project.

## CSS

Add to `content` in `tailwind.config.js`:

```javascript
'./vendor/wsydney76/craft-members/src/templates/**/*.twig'
```

Run `npm run build`.
