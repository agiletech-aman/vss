<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'region_id',      // NEW
        'warehouse_id',   // NEW
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the region this user is assigned to
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Get the warehouse this user is assigned to
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * Check if user is a Region Officer
     */
    public function isRegionOfficer(): bool
    {
        return $this->hasRole('region_officer');
    }

    /**
     * Check if user is a Warehouse Officer
     */
    public function isWarehouseOfficer(): bool
    {
        return $this->hasRole('warehouse_officer');
    }

    /**
     * Get accessible warehouses based on user role
     * 
     * This is the KEY method that enables role-based filtering
     */
    public function getAccessibleWarehouses()
    {
        // SuperAdmin and Admin: Full access to all warehouses
        if ($this->hasRole('superadmin') || $this->hasRole('admin')) {
            return Warehouse::with('region')->get();
        }

        // Region Officer: Only warehouses in their assigned region
        if ($this->isRegionOfficer() && $this->region_id) {
            return Warehouse::where('region_id', $this->region_id)
                ->with('region')
                ->get();
        }

        // Warehouse Officer: Only their specific warehouse
        if ($this->isWarehouseOfficer() && $this->warehouse_id) {
            return Warehouse::where('id', $this->warehouse_id)
                ->with('region')
                ->get();
        }

        // Default: No access
        return collect();
    }

    /**
     * Get accessible warehouse names (for filtering)
     */
    public function getAccessibleWarehouseNames(): array
    {
        return $this->getAccessibleWarehouses()
            ->pluck('warehouse')  // Your warehouse table uses 'warehouse' field for name
            ->toArray();
    }

    /**
     * Check if user has access to a specific warehouse
     */
    public function hasAccessToWarehouse(string $warehouseName): bool
    {
        return in_array($warehouseName, $this->getAccessibleWarehouseNames());
    }
}
