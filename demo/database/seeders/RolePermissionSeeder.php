<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | ALL SYSTEM PERMISSIONS
        |--------------------------------------------------------------------------
        */

        $permissions = [

            // Dashboard
            'view_dashboard',

            // User Management / RBAC
            'view_users',
            'manage_users',
            'manage_roles',
            'manage_permissions',

            // Regions
            'view_regions',
            'manage_regions',

            // Warehouses
            'view_warehouses',
            'manage_warehouses',

            // Alerts
            'view_fire_alerts',
            'view_smoke_alerts',
            'view_rodent_alerts',
            'view_reports',

            // FRS
            'view_frs',

            // Sack Counting
            'view_sack',

            // NMS
            'view_nms',

            // Live Streaming
            'view_live_stream',

            // Recording
            'manage_recording',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        /*
        |--------------------------------------------------------------------------
        | ROLES
        |--------------------------------------------------------------------------
        */

        $superadmin = Role::firstOrCreate(['name' => 'superadmin']);
        $admin      = Role::firstOrCreate(['name' => 'admin']);
        $ro         = Role::firstOrCreate(['name' => 'region_officer']);      // NEW
        $wo         = Role::firstOrCreate(['name' => 'warehouse_officer']);   // NEW
        $user       = Role::firstOrCreate(['name' => 'user']);

        /*
        |--------------------------------------------------------------------------
        | ROLE PERMISSION ASSIGNMENT
        |--------------------------------------------------------------------------
        */

        // 🔥 SuperAdmin = FULL ACCESS
        $superadmin->syncPermissions(Permission::all());

        // 🛠 Admin = Operational control + User Management
        $admin->syncPermissions([
            'view_dashboard',
            'view_users',
            'manage_users',
            'view_regions',
            'manage_regions',
            'view_warehouses',
            'manage_warehouses',
            'view_fire_alerts',
            'view_smoke_alerts',
            'view_rodent_alerts',
            'view_reports',
            'view_frs',
            'view_sack',
            'view_nms',
            'view_live_stream',
            'manage_recording',
        ]);

        // 📍 Region Officer = View their region's data only (NO user management)
        $ro->syncPermissions([
            'view_dashboard',
            'view_regions',
            'view_warehouses',
            'view_fire_alerts',
            'view_smoke_alerts',
            'view_rodent_alerts',
            'view_reports',
            'view_frs',
            'view_sack',
            'view_nms',
            'view_live_stream',
        ]);

        // 🏭 Warehouse Officer = View their warehouse only (NO user management)
        $wo->syncPermissions([
            'view_dashboard',
            'view_warehouses',
            'view_fire_alerts',
            'view_smoke_alerts',
            'view_rodent_alerts',
            'view_reports',
            'view_frs',
            'view_sack',
            'view_nms',
            'view_live_stream',
        ]);

        // 👤 Normal User = Read Only
        $user->syncPermissions([
            'view_dashboard',
            'view_regions',
            'view_warehouses',
        ]);

        echo "\n✓ Roles and permissions seeded successfully\n";
        echo "  - SuperAdmin: Full access\n";
        echo "  - Admin: Operational + User Management\n";
        echo "  - Region Officer: Region-scoped data (no user mgmt)\n";
        echo "  - Warehouse Officer: Warehouse-scoped data (no user mgmt)\n";
        echo "  - User: Read only\n\n";
    }
}
