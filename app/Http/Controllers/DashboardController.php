<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Inventory;
use App\Models\Location;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $locationsCount = Location::count();
        $suppliersCount = Supplier::count();
        $divisionsCount = Division::count();
        $inventoryCount = Inventory::count();
        $usersCount = User::count();

        // Count inventories by category
        $inventoryByCategory = Inventory::select('category', \DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get();

        // Prepare the data for chart (labels and dataset)
        $categories = $inventoryByCategory->pluck('category');
        $categoryCounts = $inventoryByCategory->pluck('total');

        // Count users by division
        $usersByDivision = User::select('division_id', \DB::raw('count(*) as total'))
            ->groupBy('division_id')
            ->with('division') // Eager load division data
            ->get();

        // Prepare the data for the users-by-division chart
        $divisionLabels = $usersByDivision->pluck('division.name');
        $userCountsByDivision = $usersByDivision->pluck('total');

        return view('admin.dashboard', compact(
            'locationsCount',
            'divisionsCount',
            'inventoryCount',
            'usersCount',
            'suppliersCount',
            'categories',
            'categoryCounts',
            'divisionLabels',
            'userCountsByDivision'
        ));
    }
}
