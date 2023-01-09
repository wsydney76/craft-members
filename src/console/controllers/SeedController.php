<?php

namespace wsydney76\members\console\controllers;

use Craft;
use craft\console\Controller;
use craft\elements\Entry;
use craft\elements\User;
use craft\helpers\ArrayHelper;
use yii\console\ExitCode;
use yii\helpers\Console;
use function implode;

/**
 * Seed controller
 */
class SeedController extends \modules\main\console\controllers\SeedController
{
    public $defaultAction = 'create-members-entries';

    public function options($actionID): array
    {
        $options = parent::options($actionID);
        switch ($actionID) {
            case 'index':
                // $options[] = '...';
                break;
        }
        return $options;
    }

    /**
     * members/seed command
     */
    public function actionCreateMembersEntries(): int
    {

        $entry = Entry::find()->section('page')->type('pageTemplate')->slug('members')->one();
        if ($entry) {
            console::error('Membership Entries exist');
            return ExitCode::UNSPECIFIED_ERROR;
        }

        if ($this->interactive && !$this->confirm('Create Membership Entries?')) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $homepage = Entry::findOne(['slug' => '__home__']);

        $parent = $this->createEntry([
            'section' => 'page',
            'type' => 'pageTemplate',
            'title' => 'Members',
            'slug' => 'members',
            'parent' => $homepage,
            'fields' => [
                'pageTemplate' => '@members/_pages/members'
            ],
            'localized' => [
                'de' => [
                    'title' => 'Mitglieder',
                    'slug' => 'mitglieder'
                ]
            ]
        ]);


        $items = [
            [
                'title' => 'Login',
                'slug' => 'login',
                'title_en' => 'Login',
                'slug_en' => 'login',
                'membersTemplate' => 'login.twig'
            ], [
                'title' => 'Registrieren',
                'slug' => 'registrieren',
                'title_en' => 'Register',
                'slug_en' => 'register',
                'membersTemplate' => 'register.twig'
            ], [
                'title' => 'Profil',
                'slug' => 'profil',
                'title_en' => 'Profile',
                'slug_en' => 'profile',
                'membersTemplate' => 'profile.twig'
            ], [
                'title' => 'Passwort vergessen?',
                'slug' => 'passwort-vergessen',
                'title_en' => 'Forgot password?',
                'slug_en' => 'forgot-password',
                'membersTemplate' => 'forgotpassword.twig'
            ], [
                'title' => 'Passwort vergeben',
                'slug' => 'passwort-vergeben',
                'title_en' => 'Set password',
                'slug_en' => 'set-password',
                'membersTemplate' => 'setpassword.twig'
            ], [
                'title' => 'Ungültig',
                'slug' => 'ungueltig',
                'title_en' => 'Invalid',
                'slug_en' => 'invalid',
                'membersTemplate' => 'invalidtoken.twig'
            ],
        ];

        foreach ($items as $item) {

            $entry = $this->createEntry([
                'section' => 'page',
                'type' => 'pageTemplate',
                'parent' => $parent,
                'title' => $item['title_en'],
                'slug' => $item['slug_en'],
                'fields' => [
                    'pageTemplate' => "@members/_pages/{$item['membersTemplate']}",
                ],
                'localized' => [
                    'de' => [
                        'title' => $item['title'],
                        'slug' => $item['slug'],
                    ]
                ]
            ]);

        }

        return ExitCode::OK;
    }

    protected function localize($entry, $title, $slug)
    {
        $localizedEntry = $entry->getLocalized()->site('en')->one();
        if ($localizedEntry) {
            $localizedEntry->title = $title;
            $localizedEntry->slug = $slug;
            Craft::$app->elements->saveElement($localizedEntry);
        }
    }
}
