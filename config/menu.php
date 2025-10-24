<?php




/*
|--------------------------------------------------------------------------
| Sidebar Menu Configuration Guide
|--------------------------------------------------------------------------
|
| PURPOSE:
| ONLY FOR NAVIGATION/INDEX ROUTES.
| FOR CRUD ACTIONS LIKE STORE, UPDATE, DELETE, DEFINE THOSE IN WEB ROUTES
|
| Each top-level key (e.g., 'dashboard', 'inventory') represents a sidebar
| section. Each section can have multiple 'subitems', which are the actual
| clickable links in your sidebar.
|
| STRUCTURE:
| 'key'       → Unique identifier for grouping.
| 'title'     → Display name in the sidebar.
| 'icon'      → SVG icon (string).
| 'roles'     → Which roles can see this section.
| 'subitems'  → Array of pages under this section.
|
| Each subitem:
|   'title'   → Text shown in the sidebar.
|   'type'    → 'view' (Blade view) | 'controller' (Controller@index) | 'url' (external link)
|   'view'    → Required if type = 'view' → e.g. 'pages.dashboard.overview'
|   'action'  → Required if type = 'controller' → e.g. 'EmployeeController@index'
|   'uri'     → URL path (auto-registered as route)
|   'name'    → Route name (for route() helper)
|   'roles'   → Who can access (['*'] = all)
|   'method'  → Optional, defaults to GET
|
*/

use App\Http\Controllers\ProductController;

return [

    'dashboard' => [
        'key' => 'dashboard',
        'title' => 'Dashboard',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z"/><path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z"/></svg>',
        'roles' => ['*'],
        'subitems' => [
            [
                'title' => 'Overview',
                'type' => 'view',
                'view' => 'pages.dashboard.overview',
                'uri' => 'dashboard/overview',
                'name' => 'dashboard.overview',
                'roles' => ['*'],
            ],
            [
                'title' => 'Point of Sales',
                'uri' => 'dashboard/pos',
                'name' => 'dashboard.pos',
                'roles' => ['*'],
            ],
        ],
    ],

    'inventory' => [
        'key' => 'inventory',
        'title' => 'Inventory',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path d="M12.378 1.602a.75.75 0 0 0-.756 0L3 6.632l9 5.25 9-5.25-8.622-5.03ZM21.75 7.93l-9 5.25v9l8.628-5.032a.75.75 0 0 0 .372-.648V7.93ZM11.25 22.18v-9l-9-5.25v8.57a.75.75 0 0 0 .372.648l8.628 5.033Z"/></svg>',
        'roles' => ['manager', 'admin', 'superadmin'],
        'subitems' => [
            [
                'title' => 'Products',
                'uri' => 'inventory/products',
                'name' => 'inventory.products',
                'roles' => ['*'],
            ],
            [
                'title' => 'Purchase Order',
                'uri' => 'inventory/stock-in',
                'name' => 'inventory.stock-in',
                'roles' => ['*'],
            ],
        ],
    ],

    'services' => [
        'key' => 'services',
        'title' => 'Services',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path fill-rule="evenodd" d="M12 6.75a5.25 5.25 0 0 1 6.775-5.025.75.75 0 0 1 .313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 0 1 1.248.313 5.25 5.25 0 0 1-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 1 1 2.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0 1 12 6.75ZM4.117 19.125a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z" clip-rule="evenodd"/></svg>',
        'roles' => ['staff', 'manager', 'admin', 'superadmin'],
        'subitems' => [
            [
                'title' => 'Service Ticket',
                'type' => 'view',
                'view' => 'pages.services.service-ticket',
                'uri' => 'services/service-ticket',
                'name' => 'services.service-ticket',
                'roles' => ['*'],
            ],
            [
                'title' => 'Ticket Tracking',
                'type' => 'view',
                'view' => 'pages.services.ticket-tracking',
                'uri' => 'services/ticket-tracking',
                'name' => 'services.ticket-tracking',
                'roles' => ['*'],
            ],
        ],
    ],

    'customer' => [
        'key' => 'customer',
        'title' => 'Customer',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"/></svg>',
        'roles' => ['staff', 'manager', 'admin', 'superadmin'],
        'subitems' => [
            [
                'title' => 'Customer Management',
                'type' => 'controller',
                'action' => 'App\\Http\\Controllers\\CustomerController@index',
                'uri' => 'customers/customer-management',
                'name' => 'customers.customer-management',
                'roles' => ['*'],
            ],
            [
                'title' => 'After Sales',
                'type' => 'view',
                'view' => 'pages.customer.after-sales',
                'uri' => 'customers/after-sales',
                'name' => 'customers.after-sales',
                'roles' => ['*'],
            ],
        ],
    ],

    'employee' => [
        'key' => 'employee',
        'title' => 'Employee',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z"/></svg>',
        'roles' => ['admin', 'superadmin'],
        'subitems' => [
            [
                'title' => 'Staff Management',
                'uri' => '/employee/staff-management',
                'name' => 'employees.index',
                'roles' => ['admin', 'superadmin'],
            ],
        ],
    ],

    'history' => [
        'key' => 'history',
        'title' => 'History',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z"/><path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z"/></svg>',
        'roles' => ['staff', 'manager', 'admin', 'superadmin'],
        'subitems' => [
            [
                'title' => 'Transaction History',
                'type' => 'view',
                'view' => 'pages.history.transaction-history',
                'uri' => 'history/transaction-history',
                'name' => 'history.transaction-history',
                'roles' => ['*'],
            ],
            [
                'title' => 'Resolution History',
                'type' => 'view',
                'view' => 'pages.history.resolution-history',
                'uri' => 'history/resolution-history',
                'name' => 'history.resolution-history',
                'roles' => ['*'],
            ],
            [
                'title' => 'Purchase Order History',
                'type' => 'view',
                'view' => 'pages.history.purchase-order',
                'uri' => 'history/purchase-order',
                'name' => 'history.purchase-order',
                'roles' => ['*'],
            ],
            [
                'title' => 'Checkout Page',
                'type' => 'view',
                'view' => 'pages.history.checkout',
                'uri' => 'history/checkout',
                'name' => 'history.checkout',
                'roles' => ['*'],
            ],

            [
                'title' => 'Audit Logs',
                'type' => 'controller',
                'action' => 'App\\Http\\Controllers\\AuditLogController@index',
                'uri' => 'history/audit-logs',
                'name' => 'history.audit-logs',
                'roles' => ['admin', 'superadmin'],
            ],
            
        ],
    ],

    'settings' => [
        'key' => 'settings',
        'title' => 'Settings',
        'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
  <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 0 0-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 0 0-2.282.819l-.922 1.597a1.875 1.875 0 0 0 .432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 0 0 0 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 0 0-.432 2.385l.922 1.597a1.875 1.875 0 0 0 2.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 0 0 2.28-.819l.923-1.597a1.875 1.875 0 0 0-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 0 0 0-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 0 0-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 0 0-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 0 0-1.85-1.567h-1.843ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" clip-rule="evenodd" />
</svg>',

        'roles' => ['admin', 'superadmin'],
        'subitems' => [
            [
                'title' => 'Categories',
                'uri' => 'settings/categories',
                'name' => 'settings.categories',
                'roles' => ['admin', 'superadmin'],
            ],
            [
                'title' => 'Promotions',
                'type' => 'controller',
                'action' => 'App\\Http\\Controllers\\PromotionController@index',
                'uri' => 'settings/promotions',
                'name' => 'settings.promotions',
                'roles' => ['*'],
            ],
            [
                'title' => 'Suppliers',
                'uri' => 'settings/suppliers',
                'name' => 'settings.suppliers',
                'roles' => ['*'],
            ],
        ],
    ],

];
