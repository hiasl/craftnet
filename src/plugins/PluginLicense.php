<?php

namespace craftnet\plugins;

use craft\base\Model;
use craft\helpers\ArrayHelper;

/**
 * @property string $shortKey
 */
class PluginLicense extends Model
{
    public $id;
    public $pluginId;
    public $editionId;
    public $ownerId;
    public $cmsLicenseId;
    public $pluginHandle;
    public $edition;
    public $expirable = true;
    public $expired = false;
    public $autoRenew = false;
    public $email;
    public $key;
    public $notes;
    public $privateNotes;
    public $lastVersion;
    public $lastAllowedVersion;
    public $lastActivityOn;
    public $lastRenewedOn;
    public $expiresOn;
    public $dateCreated;
    public $dateUpdated;
    public $uid;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['expirable', 'expired', 'plugin', 'edition', 'email', 'key'], 'required'],
            [['id', 'pluginId', 'editionId', 'ownerId', 'cmsLicenseId'], 'number', 'integerOnly' => true, 'min' => 1],
            [['email'], 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        $names = parent::attributes();
        ArrayHelper::removeValue($names, 'privateNotes');
        return $names;
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return [
            'plugin',
        ];
    }

    /**
     * @inheritdoc
     */
    public function datetimeAttributes(): array
    {
        $attributes = parent::datetimeAttributes();
        $attributes[] = 'lastActivityOn';
        $attributes[] = 'lastRenewedOn';
        $attributes[] = 'expiresOn';
        return $attributes;
    }

    /**
     * Returns a shortened version of the license key.
     *
     * @return string
     */
    public function getShortKey(): string
    {
        return substr($this->key, 0, 4);
    }

    /**
     * @return Plugin
     */
    public function getPlugin(): Plugin
    {
        return Plugin::find()
            ->id($this->pluginId)
            ->status(null)
            ->one();
    }
}
