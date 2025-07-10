<?php

use Newnet\Zone\ZoneAdminMenuKey;
use Newnet\Setting\SettingAdminMenuKey;

AdminMenu::addItem(__('zone::menu.zone.index'), [
    'id'         => ZoneAdminMenuKey::ZONE,
    'parent'     => SettingAdminMenuKey::SYSTEM,
    'route'      => config('cms.zone.enable_country') ? 'zone.admin.country.index' : 'zone.admin.province.index',
    'icon'       => 'typcn typcn-sort-numerically-outline',
    'order'      => 7,
]);
