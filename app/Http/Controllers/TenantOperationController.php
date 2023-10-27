<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stancl\Tenancy\Database\Models\Domain;

class TenantOperationController extends Controller
{
    // Create tenant

    public function getAllTenants(Request $request)
    {
        $tenants = Domain::orderBy('tenant_name', 'asc')->get();
        return response()->json([
            'tenants' => $tenants
        ], 200);
    }

    public function createTenant(Request $request)
    {
        DB::beginTransaction();

        try {
            //code...
            $centralDomain = config('tenancy.central_domains')[1];
            $tenant = Tenant::create();
            $domain = $request->tenant_domain . "." . $centralDomain;
            $tenant->domains()->create(['domain' =>  $domain, 'tenant_name' => $request->tenant_name]);
            $domain = Domain::where('tenant_id', $tenant->id)->first();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return $th;
        }
        return response()->json($domain, 200);
    }
}
