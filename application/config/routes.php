<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Home/default - redirect to login
$route['default_controller'] = 'auth/index';

// ==================== AUTHENTICATION ====================
$route['login']   = 'auth/login';
$route['logout']  = 'auth/logout';
$route['profile'] = 'adminprofile/index';
$route['profile/change_password'] = 'adminprofile/change_password';
$route['admin']         = 'auth/index';

// ==================== DASHBOARD ====================
$route['dashboard'] = 'dashboard/index';

// ==================== STANDARD CRUD MODULES ====================
// Any module whose controller/model follow the Services pattern
// (index/create/edit/delete/toggle) just needs its slug added here —
// no need to hand-write 5 route lines per module.
//
// Left  = URL segment under , e.g. testimonials
// Right = controller name, e.g. Testimonials
$standard_modules = [
    'services'         => 'services',
    'testimonials'     => 'testimonials',
    'process-steps'    => 'processsteps',
    'spotlight-slides' => 'spotlightslides',
    // add future simple modules here, e.g.:
    // 'org-chart'     => 'org_chart',
];

foreach ($standard_modules as $url_slug => $controller) {
    $route["{$url_slug}"]                 = "{$controller}/index";
    $route["{$url_slug}/create"]          = "{$controller}/create";
    $route["{$url_slug}/edit/(:num)"]     = "{$controller}/edit/$1";
    $route["{$url_slug}/delete/(:num)"]   = "{$controller}/delete/$1";
    $route["{$url_slug}/toggle/(:num)"]   = "{$controller}/toggle/$1";
}

// ==================== PRODUCT CATALOG ====================
// Categories follow the standard CRUD shape.
$route['products']                 = 'productcategories/index';
$route['products/create']          = 'productcategories/create';
$route['products/edit/(:num)']     = 'productcategories/edit/$1';
$route['products/delete/(:num)']   = 'productcategories/delete/$1';
$route['products/toggle/(:num)']   = 'productcategories/toggle/$1';

// Types are nested under a category (for index/create) or stand alone
// by their own id (for edit/delete/toggle).
$route['products/types/(:num)']               = 'producttypes/index/$1';
$route['products/types/(:num)/create']         = 'producttypes/create/$1';
$route['products/types/edit/(:num)']           = 'producttypes/edit/$1';
$route['products/types/delete/(:num)']         = 'producttypes/delete/$1';
$route['products/types/toggle/(:num)']         = 'producttypes/toggle/$1';

// ==================== CONTENT CARDS ====================
// One controller shared by all 7 sections, filtered by section_key.
// The (:num) routes (edit/delete/toggle act on a card id) must come
// BEFORE the (:any) section-scoped routes below, or "edit"/"delete"
// would themselves get matched as a section_key.
$route['content']                    = 'contentcards/overview';
$route['content/edit/(:num)']        = 'contentcards/edit/$1';
$route['content/delete/(:num)']      = 'contentcards/delete/$1';
$route['content/toggle/(:num)']      = 'contentcards/toggle/$1';
$route['content/(:any)/create']      = 'contentcards/create/$1';
$route['content/(:any)']             = 'contentcards/index/$1';

// ==================== PAGE HEROES ====================
// Edit-only — the 6 page rows are fixed, so there's no create/delete.
$route['page-heroes']              = 'pageheroes/index';
$route['page-heroes/edit/(:any)']  = 'pageheroes/edit/$1';

// ==================== SITE SETTINGS ====================
// Single form covering every known key — no per-row CRUD at all.
$route['site-settings']            = 'sitesettings/index';

// ==================== ORG CHART ====================
// Shareholder/manager are edited as singletons; departments get full CRUD.
$route['org-chart']                          = 'orgchart/index';
$route['org-chart/shareholder']              = 'orgchart/edit_shareholder';
$route['org-chart/manager']                  = 'orgchart/edit_manager';
$route['org-chart/departments/create']       = 'orgchart/create_department';
$route['org-chart/departments/edit/(:num)']  = 'orgchart/edit_department/$1';
$route['org-chart/departments/delete/(:num)'] = 'orgchart/delete_department/$1';
$route['org-chart/departments/toggle/(:num)'] = 'orgchart/toggle_department/$1';

// ==================== CONTACT MESSAGES ====================
// Read/status-only inbox — submissions come from the public contact
// form, not from this admin, so there's no create route.
$route['messages']                = 'contactmessages/index';
$route['messages/view/(:num)']    = 'contactmessages/view/$1';
$route['messages/status/(:num)']  = 'contactmessages/update_status/$1';
$route['messages/delete/(:num)']  = 'contactmessages/delete/$1';

// Error handling (must be last)
$route['404_override'] = 'errors';
$route['translate_uri_dashes'] = FALSE;