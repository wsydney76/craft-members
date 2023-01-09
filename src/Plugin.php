<?php

namespace wsydney76\members;

use Craft;
use craft\base\Model;
use craft\base\Plugin as BasePlugin;
use craft\events\RegisterTemplateRootsEvent;
use craft\helpers\App;
use craft\web\View;
use wsydney76\members\models\Settings;
use wsydney76\members\twigextensions\TwigExtension;
use yii\base\Event;

/**
 * Members plugin
 *
 * @method static Plugin getInstance()
 * @method Settings getSettings()
 * @author wsydney76 <wsydney@web.de>
 * @copyright wsydney76
 * @license MIT
 */
class Plugin extends BasePlugin
{
    public string $schemaVersion = '1.0.0';
    public bool $hasCpSettings = true;

    public static function config(): array
    {
        return [
            'components' => [
                // Define component configs here...
            ],
        ];
    }

    public function init()
    {
        parent::init();

        // Defer most setup tasks until Craft is fully initialized
        Craft::$app->onInit(function() {
            $this->attachEventHandlers();
            // ...
        });
        Craft::$app->view->registerTwigExtension(new TwigExtension());
    }

    protected function createSettingsModel(): ?Model
    {
        return Craft::createObject(Settings::class);
    }

    protected function settingsHtml(): ?string
    {
        return Craft::$app->view->renderTemplate('members/_settings.twig', [
            'plugin' => $this,
            'settings' => $this->getSettings(),
        ]);
    }

    private function attachEventHandlers(): void
    {
        // Register event handlers here ...
        // (see https://craftcms.com/docs/4.x/extend/events.html to get started)

        Event::on(
            View::class,
            View::EVENT_REGISTER_SITE_TEMPLATE_ROOTS,
            function(RegisterTemplateRootsEvent $event) {
//                $templateRoot = $this->settings->templateRoot ?
//                    App::parseEnv('@templates/' . $this->settings->templateRoot) :
//                    $this->getBasePath() . '/templates';

                $templateRoot = $this->getBasePath() . '/templates';

                $event->roots['@members'] = $templateRoot;
            }
        );

    }
}
