<?php

namespace wsydney76\members\models;

use Craft;
use craft\base\Model;

/**
 * Members settings
 */
class Settings extends Model
{
    public string $memberTemplate = '@members/_pages/member.twig';
}
