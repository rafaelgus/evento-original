<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use EventoOriginal\Core\Enums\RoleType;
use EventoOriginal\Core\Services\CustomerService;
use EventoOriginal\Core\Services\RoleService;
use EventoOriginal\Core\Services\UserService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    private $userService;
    private $roleService;
    private $customerService;

    public function __construct(
        UserService $userService,
        CustomerService $customerService,
        RoleService $roleService
    ) {
        $this->userService = $userService;
        $this->roleService = $roleService;
        $this->customerService = $customerService;
    }

    public function register(StoreCustomerRequest $request)
    {
        $customerRole = $this->roleService->findByName(RoleType::CUSTOMER);

        $user = $this->userService->create(
            $request->input('first_name') . " " . $request->input('last_name'),
            $request->input('email'),
            $request->input('password'),
            [$customerRole]
        );

        try {
            $data = $request->all();
            $data['user'] = $user;

            $this->customerService->create($data);

            Auth::guard()->login($user);

            Log::info("Customer registerd");

            return redirect()->route('my_account')->with('status', trans('auth.register_success'));
        } catch (Exception $exception) {
            Auth::guard()->logout();
            Log::error("Error creating user: " . $exception->getMessage());
            $this->userService->remove($user);

            return redirect()->back()->with('error', trans('auth.register_error'));
        }
    }

    public function affiliateSummary()
    {
        $customer = current_user()->getCustomer();

        return view('frontend.profile.affiliates.summary')->with([
            'customer' => $customer
        ]);
    }
}
