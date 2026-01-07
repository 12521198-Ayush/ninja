<?php

namespace App\Addons\EmbeddedSignup\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Addons\EmbeddedSignup\Repository\EmbeddedSignupRepository;

class EmbeddedSignupController extends Controller
{
    protected $repo;
    public function __construct(EmbeddedSignupRepository $repo)
    {
        $this->repo = $repo;
        if (!addon_is_activated('embedded_signup')) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function index()
    {
        return view('addon:EmbeddedSignup::index');
    }

    public function store(Request $request)
    {
        if (isDemoMode()) {
            $data = [
                'status' => false,
                'message'  => __('this_function_is_disabled_in_demo_server'),
            ];
            return response()->json($data);
        }
        return $this->repo->store($request);
    }

    public function sync(Request $request)
    {
        if (isDemoMode()) {
            $data = [
                'status' => false,
                'message'  => __('this_function_is_disabled_in_demo_server'),
            ];
            return response()->json($data);
        }
        return $this->repo->sync();
    }

    public function delete(Request $request, $id)
    {
        if (isDemoMode()) {
            $data = [
                'status' => false,
                'message'  => __('this_function_is_disabled_in_demo_server'),
            ];
            return response()->json($data);
        }
        return $this->repo->delete($request, $id);
    }

    public function getBusinessProfileDetails($id)
    {
        return $this->repo->getBusinessProfileDetails($id);
    }

    public function updateBusinessProfile(Request $request, $id)
    {
        if (isDemoMode()) {
            $data = [
                'status' => false,
                'message'  => __('this_function_is_disabled_in_demo_server'),
            ];
            return response()->json($data);
        }
        return $this->repo->updateBusinessProfile($request, $id);
    }
}
