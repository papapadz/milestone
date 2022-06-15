<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use App\Models\Employee;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Task;
use App\Models\ToMill;
use App\Models\Rice;
use App\Models\Darak;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Hash;
use PDF;
use Carbon\Carbon;

class ManagementController extends Controller
{

    public function Supply()
    {
        $user = Auth::user();

        $employee = Employee::with([
            'company'=>function($q){
                $q->select('id', 'name');
            }
        ])->where('user_id', $user->id)->first();

        $palay = Product::where('active', 1)->where('company_id', $employee->company->id)->with(['supplier' => function($q){
            $q->select('id', 'name');
        }])->orderBy('created_at', 'desc')->get();


        $toMill = ToMill::where('company_id', $employee->company_id)->with(['product' => function($q){
            $q->select('id', 'company_id', 'supplier_id', 'name', 'quantity', 'unit');
        }])->orderBy('created_at', 'desc')->get();

        $rice = Rice::where('company_id', $employee->company_id)->with(['product' => function($q){
            $q->select('id', 'company_id', 'supplier_id', 'name', 'quantity', 'unit');
        }])->orderBy('created_at', 'desc')->get();

        $darak = Darak::where('company_id', $employee->company_id)->with(['product' => function($q){
            $q->select('id', 'company_id', 'supplier_id', 'name', 'quantity', 'unit');
        }])->orderBy('created_at', 'desc')->get();

        // dd($toMill);
        return view('management.supply', [
            'palay'     => $palay,
            'toMill'    => $toMill,
            'rice'      => $rice,
            'darak'     => $darak
        ]);

    }   /* function Supply()*/

    public function addPalay()
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->first();

        $data = [
            'suppliers'  => Supplier::where('company_id', $employee->company_id)->where('active', 1)->orderBy('name', 'asc')->get()
        ];

        return view('management.addPalay', $data);

    } /*public function addPalay()*/

    public function storePalay(Request $request)
    {
        $company = Employee::with([
            'company'=>function($q){
                $q->select('id', 'name');
            }
        ])
        ->first();

        $palay = new Product;
        $palay->company_id = $company->id;
        $palay->supplier_id = $request->supplier;
        $palay->name = $request->variant;
        $palay->quantity = $request->quantity;
        $palay->unit = $request->unit;
        $palay->date_ordered = $request->date_ordered;
        $palay->date_delivered = $request->date_delivered;
        $palay->moving = $request->moving;
        $palay->save();

        if($palay->save())
        {
            Alert::Success('Success!', 'New Item');
            return redirect('supply');
        }

    }   /* function storePalay()*/

    public function updateProduct(Request $request)
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->first();

        if ($request->isMethod('get'))
        {
            $product = Product::where('id', $request->id)->with(['to_mill'])->first();
            $data = [
                'suppliers' => Supplier::where('company_id', $employee->company_id)->where('active', 1)->orderBy('name', 'asc')->get(),
                'product'   => $product
            ];

            return view('management.addPalay', $data);

        }elseif($request->isMethod('post'))
        {
            $product = Product::find($request->id);
            $product->name = $request->variant;
            $product->supplier_id = $request->supplier;
            $product->quantity = $request->quantity;
            $product->unit = $request->unit;
            $product->date_ordered = $request->date_ordered;
            $product->date_delivered = $request->date_delivered;
            $product->moving = $request->moving;


            if($product->save())
            {
                if($request->toMill)
                {
                    ToMill::create(['product_id' => $product->id, 'company_id' => $employee->company_id]);
                }

                Alert::Success('Success!', 'New Item');
                return redirect('supply');
            }

        }
    }       /* updateProduct() */

    public function toMillUpdate(Request $request)
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->first();

        if ($request->isMethod('get'))
        {
            $toMill = ToMill::where('id', $request->id)->with('product')->first();

            $data = [
                'toMill'    => $toMill
            ];
            return view('management.toMill', $data);

        }elseif($request->isMethod('post')){

            $toMill = ToMill::where('id', $request->id)->first();

            /* Create Rice record */
            $rice = new Rice;
            $rice->mill_id = $toMill->id;
            $rice->product_id = $toMill->product_id;
            $rice->company_id = $employee->company_id;
            $rice->quantity = $request->riceQty;
            $rice->unit = $request->riceUnit;
            $rice->save();

            /* Create Darak record */
            $darak = new Darak;
            $darak->mill_id = $toMill->id;
            $darak->product_id = $toMill->product_id;
            $darak->company_id = $employee->company_id;
            $darak->quantity = $request->darakQty;
            $darak->unit = $request->darakUnit;
            $darak->save();

            $toMill->status = 'complete';
            $toMill->save();

            Alert::Success('Success!', 'New Item');
            return redirect('supply');

        }
    }       /* toMillUpdate() */

    public function viewPalay()
    {

        $company = Employee::with([
            'company'=>function($q){
                $q->select('id', 'name');
            }
        ])
        ->first();

        $palay = Product::where('active', 1)
        ->where('company_id', $company->company->id)->get();

        return view('management.viewPalay', [
            'palay' => $palay,
        ]);


    } /*public function viewPalay()*/

    public function AddEmployee(Request $request)
    {
        $user = User::get();

        $user->role = 'ceo' ? ($employee = $request->session()->get('ceo')) : $employee = $request->session()->get('manager');
        // dd($employee);


        $company = Employee::with([
            'company'=>function($q){
                $q->select('id', 'name');
            }
        ])
        ->first();

        // dd($company);

        return view('management.addEmployee', [
            'user'      => $user,
            'company'   => $company,
        ]);

    } /*public function AddEmployee()*/

    public function AddUser()
    {
        $user = User::get();
        $company = Company::where('active', 1)->get();
        return view('management.addUser', [
            'user'      => $user,
            'company'   => $company,
        ]);

    } /*public function AddUser()*/

    public function storeEmployee(Request $request)
    {
        $validator = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'role' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!@#$%^&*()]).*$/',
            'role' => 'required',
        ],[
            'password.regex' => 'Password must contain lower (a-z) and uppercase characters (A-Z), numbers (0-9) and special characters (!@#$%^&*())'
        ]);

        if($request->role!='admin')
            $validator = $request->validate([
                'company' => 'required',
                'age' => 'required|numeric|min:18',
                'contact_no' => 'required|min:11',
                'address' => 'required',
                'gender' => 'required',
            ]);

        $user = new User;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = app('hash')->make($request->password);
        $user->save();

        if(($user->role == 'ceo') || ($user->role == 'manager') || ($user->role == 'employee')){
            $employee = new Employee;
            $employee->user_id = $user->id;
            $employee->company_id = $request->company;
            $employee->age = $request->age;
            $employee->contact_no = $request->contact_no;
            $employee->address = $request->address;
            $employee->position = $user->role;
            $employee->gender = $request->gender;
            $employee->save();
        }

        if($user->save()){
            Alert::Success('Success!', 'New User');
            return back();
        }

    } /*public function storeEmployee()*/

    public function manageAccount()
    {

        return view('management.manageAccount');

    } /*public function manageAccount()*/

    public function postManageAccount(Request $request)
    {

        $current = $request->current;
        $new = $request->new;
        $confirm = $request->confirm;
        $user = Auth::user();

        if(Hash::check($current, $user->password)){
            //they match

            if($new == $confirm){
                $pass = User::where('id', $user->id)->update([
                    'password'    => app('hash')->make($new),
                ]);

                Alert::Success('Success!', 'Password changed');
                return redirect('/');
            }

        }


        return view('management.manageAccount');

    } /*public function postManageAccount()*/

    public function employeeDirectory()
    {

        $company = Employee::with([
            'company'=>function($q){
                $q->select('id', 'name');
            }
        ])
        ->first();

        $employee = Employee::where('active', 1)
        ->where('company_id', $company->id)
        ->with([
            'user'=>function($q){
                $q->select('id', 'firstname', 'lastname', 'email');
            }
        ])
        ->get();

        // dd($employee);

        return view('management.employeeDirectory', [
            'employee' => $employee,
        ]);

    } /*public function employeeDirectory()*/

    public function addAccount()
    {

        return view('management.addAccount');

    } /*public function addAccount()*/

    public function storeAccount(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|unique:companies',
            'email' => 'email|required|unique:companies',
            'contact_no' => 'required|min:11',
            'address' => 'required',
            'contract_duration' => 'required'
        ]);

        $company = new Company;
        $company->name = $request->name;
        $company->email = $request->email;
        $company->contact_no = $request->contact_no;
        $company->address = $request->address;
        $company->contract_duration = $request->contract_duration;
        $company->save();

        if ($company->save()) {
            Alert::Success('Success!', 'New Account has been added');
            return redirect()->route('dashboard');
        }else
            Alert::Danger('Error!', 'Something went wrong');
            return back('management.addAccount');

    } /*public function storeAccount()*/

    public function updateAccount($id){
        $company = Company::find($id);

        if($company->active == '1'){
            $company->active = '0';
            $company->save();

            if($company->save()){
                Alert::Success('Success!', 'Unsubscribed an account');
                return back()->with('message','Operation Successful !');
            }
        }
        if($company->active == '0'){
            $company->active = '1';
            $company->save();

            if($company->save()){
                Alert::Success('Success!', 'Subscribed an account');
                return back()->with('message','Operation Successful !');
            }
        }

    }/* updateRequest */

    public function Task()
    {

        $company = Employee::with([
            'company'=>function($q){
                $q->select('id', 'name');
            }
        ])
        ->first();

        $task = Task::with([
            'user'=>function($q){
                $q->select('id', 'firstname', 'lastname');
            }
        ])
        ->where('company_id', $company->id)->get();

        $onprogress = Task::with([
            'user'=>function($q){
                $q->select('id', 'firstname', 'lastname');
            }
        ])
        ->where('company_id', $company->id)
        ->where('status', 1)
        ->get();

        $completed = Task::with([
            'user'=>function($q){
                $q->select('id', 'firstname', 'lastname');
            }
        ])
        ->where('company_id', $company->id)
        ->where('status', 0)
        ->get();

        // dd($task);

        return view('management.task',[
            'task'      => $task,
            'onprogress'=> $onprogress,
            'completed'=> $completed
        ]);

    } /*public function OMTask()*/

    public function addTask(){

        $company = Employee::with([
            'company'=>function($q){
                $q->select('id', 'name');
            }
        ])
        ->first();

        $employee = Employee::with([
            'user'=>function($q){
                $q->select('id', 'firstname', 'lastname');
            }
        ])->where('company_id', $company->id)->get();

        // dd($employee);

        return view('management.addTask',[
            'employee' => $employee
        ]);

    } /* public function addTask() */

    public function storeTask(Request $request){

        $validator = $request->validate([
            'employee' => 'required',
            'name' => 'required',
            'description' => 'required'
        ]);

        $company = Employee::with([
            'company'=>function($q){
                $q->select('id', 'name');
            }
        ])
        ->first();

        $user = Auth::user();

        $task = new Task;
        $task->assigned_by = $user->id;
        $task->assigned_for = $request->employee;
        $task->company_id = $company->id;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->save();

        if($task->save()){

            Alert::Success('Success!', 'New Task has been added');
            return redirect()->back();

        }
        else {
            Alert::Error('Sorry!', 'Task has not been added. Try again.');
            return redirect()->back();
        }

    } /* public function storeTask() */

    public function updateTask($id){
        $task = Task::find($id);

        if($task->status == '1'){
            $task->status = '0';
            $task->end_date = Carbon::now()->toDateTimeString();
            $task->save();

            if($task->save()){
                Alert::Success('Success!', 'Task Completed');
                return back()->with('message','Operation Successful !');
            }
        }
        if($task->status == '0'){
            $task->status = '1';
            $task->end_date = null;
            $task->save();

            if($task->save()){
                Alert::Success('Success!', 'Task Pending');
                return back()->with('message','Operation Successful !');
            }
        }

    }   /* updateTask */

    public function suppliers(Request $request)
    {
        $employee = Employee::select('id', 'user_id', 'company_id')->where('user_id', Auth::user()->id)->first();

        $data = [
            'suppliers' => Supplier::where('company_id', $employee->company_id)->get()
        ];

        return view('management.suppliers', $data);
    }       /* suppliers() */

    public function addNewSupplier(Request $request)
    {
        if ($request->isMethod('get'))
        {
         /* Load supplier form */
         return view('management.addSupplier');

        }elseif($request->isMethod('post'))
        {
            /* Save new supplier */
            $user = Auth::user();
            $employee = Employee::where('user_id', $user->id)->first();

            $data = [
                'company_id' => $employee->company_id,
                'name'       => $request->name,
                'email'       => $request->email,
                'address'    => $request->address
            ];
            Supplier::create($data);
            return redirect('suppliers');
        }
    }       /* addNewSupplier() */

    public function editSupplier(Request $request)
    {
        if ($request->isMethod('get'))
        {
         /* Load supplier form */
         $data = [
             'supplier' => Supplier::find($request->id)
         ];

         return view('management.addSupplier', $data);

        }elseif($request->isMethod('post'))
        {
           $supplier =  Supplier::find($request->id);
           $supplier->name = $request->name;
           $supplier->email = $request->email;
           $supplier->address = $request->address;
           $supplier->active = $request->active;
           $supplier->save();

            return redirect('suppliers');

        }
    }


}

