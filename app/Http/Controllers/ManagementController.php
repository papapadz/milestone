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
use App\Models\TaskDeletion;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Hash;
use PDF;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\PalayVariant;
use App\Mail\NotifyMail;
use App\Models\Notification;

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

        $palay = Product::where('active', 1)->where('company_id', $employee->company_id)->with(['supplier' => function($q){
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

    public function supplyMilled() {
        $user = Auth::user();

        $employee = Employee::with([
            'company'=>function($q){
                $q->select('id', 'name');
            }
        ])->where('user_id', $user->id)->first();

        $palay = Product::where('active', 1)->where('company_id', $employee->company_id)->with(['supplier' => function($q){
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
        return view('management.supplyMilled', [
            'palay'     => $palay,
            'toMill'    => $toMill,
            'rice'      => $rice,
            'darak'     => $darak
        ]);
    }

    public function addPalay()
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->first();

        $data = [
            'variants' => PalayVariant::get(),
            'suppliers'  => Supplier::where('company_id', $employee->company_id)->where('active', 1)->orderBy('name', 'asc')->get()
        ];

        return view('management.addPalay', $data);

    } /*public function addPalay()*/

    public function storePalay(Request $request)
    {
        $validator = $request->validate([
            'supplier' => 'required',
            'variant' => 'required',
            'quantity' => 'required|numeric|min:1',
            'unit' => 'required',
            'date_ordered' => 'required|date',
            'date_delivered' => 'required|date',
            'moving' => 'required'
        ]);
        
        $palay = new Product;
        $palay->company_id = Auth::User()->employee->company_id;
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
            PalayVariant::firstOrCreate(['variant'=>$request->variant]);
                
            Log::create([
                'user_id' => Auth::User()->id,
                'action' => 'add',
                'table' => 'products',
                'row_id' => $palay->id
            ]);
            Alert::Success('Success!', 'Item '.$request->variant.' has been added');
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
                'product'   => $product,
                'variants' => PalayVariant::get(),
            ];

            return view('management.addPalay', $data);

        }elseif($request->isMethod('post'))
        {
            $validator = $request->validate([
                'supplier' => 'required',
                'variant' => 'required',
                'quantity' => 'required|numeric|min:1',
                'unit' => 'required',
                'date_ordered' => 'required|date',
                'date_delivered' => 'required|date',
                'moving' => 'required'
            ]);

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
                    $tomillitem = ToMill::create(['product_id' => $product->id, 'company_id' => $employee->company_id]);
                    Log::create([
                        'user_id' => Auth::User()->id,
                        'action' => 'add',
                        'table' => 'to_mill',
                        'row_id' => $tomillitem->id
                    ]);

                    Notification::create([
                        'sender_id' => Auth::User()->id,
                        'receiver_id' => Auth::User()->id,
                        'message' => 'Rice variant '.$product->name.' has been added to the To Mill List.'
                    ]);
                }
                Log::create([
                    'user_id' => Auth::User()->id,
                    'action' => 'update',
                    'table' => 'products',
                    'row_id' => $product->id
                ]);
                Alert::Success('Success!', 'Item '.$request->variant.' has been added');
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
            
            if($toMill->product->unit=='ton')
                $max = $toMill->product->quantity*1000;
            else if($toMill->product->unit=='sacks')
                $max = $toMill->product->quantity*50;
            else
                $max = $toMill->product->quantity;

            if($request->riceUnit=='ton')
                $riceQty = $request->riceQty*1000;
            else if($request->riceUnit=='sacks')
                $riceQty = $request->riceQty*50;
            else
                $riceQty = $request->riceQty;

            if($request->darakUnit=='ton')
                $darakQty = $request->darakQty*1000;
            else if($request->darakUnit=='sacks')
                $darakQty = $request->darakQty*50;
            else
                $darakQty = $request->darakQty;
                
            $validator = $request->validate([
                'riceQty' => 'required|numeric|min:1|max:'.$max,
                'riceUnit' => 'required',
                'darakQty' => 'required|numeric|min:1|max:'.($max-$riceQty),
                'darakUnit' => 'required',
            ]);

            
            /* Create Rice record */
            $rice = new Rice;
            $rice->mill_id = $toMill->id;
            $rice->product_id = $toMill->product_id;
            $rice->company_id = $employee->company_id;
            $rice->quantity = $request->riceQty;
            $rice->unit = $request->riceUnit;
            $rice->save();

            Log::create([
                'user_id' => Auth::User()->id,
                'action' => 'add',
                'table' => 'rice',
                'row_id' => $rice->id
            ]);

            /* Create Darak record */
            $darak = new Darak;
            $darak->mill_id = $toMill->id;
            $darak->product_id = $toMill->product_id;
            $darak->company_id = $employee->company_id;
            $darak->quantity = $request->darakQty;
            $darak->unit = $request->darakUnit;
            $darak->save();

            Log::create([
                'user_id' => Auth::User()->id,
                'action' => 'add',
                'table' => 'darak',
                'row_id' => $darak->id
            ]);

            $toMill->status = 'complete';
            $toMill->save();

            Log::create([
                'user_id' => Auth::User()->id,
                'action' => 'update',
                'table' => 'to_mill',
                'row_id' => $toMill->id
            ]);

            $quantityLeft = $max - ($riceQty+$darakQty);
            $newQuantity = 0;
            $newUnit = 'kilogram';
            if($quantityLeft>=1000) {
                $newQuantity = $quantityLeft/1000;
                $newUnit = 'tons';
            } else if($quantityLeft>=50) {
                $newQuantity = $quantityLeft/50;
                $newUnit = 'sacks';
            } else 
                $newQuantity = $quantityLeft;

            $product = Product::find($toMill->product_id);
            $product->quantity = $newQuantity;
            $product->unit = $newUnit;
            $product->save();
 
            Notification::create([
                'receiver_id' => Auth::User()->id,
                'message' => 'Rice variant '.$product->name.' has been milled and produced '.$request->riceQty.' '.$request->riceUnit.' of Rice and '.$request->darakQty.' '.$request->darakUnit.' of Darak. Remaining inventory is '.$newQuantity.' '.$newUnit.'.'
            ]);

            Log::create([
                'user_id' => Auth::User()->id,
                'action' => 'update',
                'table' => 'products',
                'row_id' => $product->id
            ]);

            if($quantityLeft<10) {

                $details = [
                    'title' =>'Critical Limit Warning',
                    'message' => 'Palay Variant '.$product->name.' is at critical level. Current inventory: '.$newQuantity.' '.$newUnit.'. Please make necessary actions.'
                ];

                $employees = Employee::where('company_id',$product->company_id)->get();
                foreach($employees as $employee) {
                    if($employee->user->role == 'ceo' || $employee->user->role == 'manager') {
                        \Mail::to($employee->user->email)->send(new NotifyMail($details));
                        Notification::create([
                            'receiver_id' => $employee->user_id,
                            'message' => $details['message']
                        ]);
                    }
                }
            }
            
            Alert::Success('Success!', 'Item has been succesfully updated');
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


        // $company = Employee::with([
        //     'company'=>function($q){
        //         $q->select('id', 'name');
        //     }
        // ])
        // ->first();
        
        // dd($company);
        $company = Employee::where([['user_id',Auth::user()->id],['company_id',Auth::user()->employee->company_id]])->first();
        
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

        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'role' => 'required',
            'email' => 'email|required|unique_encrypted:users,email',
            'password' => 'min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!@#$%^&*()]).*$/',
            'role' => 'required'
        ];

        if($request->role!='admin')
            $rules = array_merge($rules, [
                'company' => 'required',
                'age' => 'required|numeric|min:18',
                'contact_no' => 'required|min:11',
                'address' => 'required',
                'gender' => 'required',
            ]);
        
        $validator = $request->validate($rules,[
            'password.regex' => 'Password must contain lower (a-z) and uppercase characters (A-Z), numbers (0-9) and special characters (!@#$%^&*())'
        ]);

        
     
        if($request->role == 'ceo') {
            
            $countCEO = Employee::where([['position','ceo'],['company_id',$request->company]])->count();
            
            if($countCEO==0) {
                $user = new User;
                $user->firstname = $request->firstname;
                $user->lastname = $request->lastname;
                $user->email = $request->email;
                $user->role = $request->role;
                $user->password = app('hash')->make($request->password);
                $user->save();
            } else {
                Alert::Error('Error!', 'Only 1 CEO is allowed per company');
                return back();
            }
        } else {
            $user = new User;
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->password = app('hash')->make($request->password);
            $user->save();
        }

       if(($request->role == 'ceo') || ($request->role == 'manager') || ($request->role == 'employee')){
            $employee = new Employee;
            $employee->user_id = $user->id;
            $employee->company_id = $request->company;
            $employee->age = $request->age;
            $employee->contact_no = $request->contact_no;
            $employee->address = $request->address;
            $employee->position = $user->role;
            $employee->gender = $request->gender;
            $employee->save();

            Log::create([
                'user_id' => Auth::User()->id,
                'action' => 'add',
                'table' => 'employees',
                'row_id' => $employee->id
            ]);
        }

        if($user->save()){
            Log::create([
                'user_id' => Auth::User()->id,
                'action' => 'add',
                'table' => 'users',
                'row_id' => $user->id
            ]);
            Alert::Success('Success!', 'New '.$request->role.' has been created');
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

        $validator = $request->validate([
            'password' => 'required',
            'new' => 'required|min:6',
            'confirm' => 'required|min:6',
        ]);
        if(Hash::check($current, $user->password)){
            //they match
            if($new == $confirm){
                $validator = $request->validate([
                    'new' => 'min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!@#$%^&*()]).*$/',
                ],[
                    'new.regex' => 'Password must contain lower (a-z) and uppercase characters (A-Z), numbers (0-9) and special characters (!@#$%^&*())',
                ]);
                
                $pass = User::where('id', $user->id)->update([
                    'password'    => app('hash')->make($new),
                ]);

                Alert::Success('Success!', 'Password changed');
                return redirect()->back();
            } else {
                Alert::Error('Success!', 'New password does not match');
                return redirect()->back();
            }

        } else  {
            Alert::Error('Warning!', 'Password is Incorrect');
            return redirect()->back();
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
            Log::create([
                'user_id' => Auth::User()->id,
                'action' => 'add',
                'table' => 'companies',
                'row_id' => $company->id
            ]);
            Alert::Success('Success!', 'New Account has been added');
            return redirect()->route('dashboard');
        }else
            Alert::Error('Error!', 'Something went wrong');
            return back('management.addAccount');

    } /*public function storeAccount()*/

    public function updateAccount($id){
        $company = Company::find($id);

        if($company->active == '1'){
            $company->active = '0';
            $company->save();

            if($company->save()){
                Log::create([
                    'user_id' => Auth::User()->id,
                    'action' => 'update',
                    'table' => 'companies',
                    'row_id' => $company->id
                ]);
                Alert::Success('Success!', 'Unsubscribed an account');
                return back()->with('message','Operation Successful !');
            }
        }
        if($company->active == '0'){
            $company->active = '1';
            $company->save();

            if($company->save()){
                Log::create([
                    'user_id' => Auth::User()->id,
                    'action' => 'update',
                    'table' => 'companies',
                    'row_id' => $company->id
                ]);
                Alert::Success('Success!', 'Subscribed an account');
                return back()->with('message','Operation Successful !');
            }
        }

    }/* updateRequest */

    public function Task()
    {

        // $company = Employee::with([
        //     'company'=>function($q){
        //         $q->select('id', 'name');
        //     }
        // ])
        // ->first();

        $employee = Employee::where('user_id',Auth::user()->id)->first();
        $company = $employee->company;
        $task = [];
        $onprogress = [];
        $completed = [];

        if($company) {
            $task = Task::with([
                'user'=>function($q){
                    $q->select('id', 'firstname', 'lastname');
                }
            ])
            ->where([['company_id', $company->id],['is_visible',true]])->get();

            $onprogress = Task::with([
                'user'=>function($q){
                    $q->select('id', 'firstname', 'lastname');
                }
            ])
            ->where([['company_id', $company->id],['is_visible',true]])
            ->where('status', 1)
            ->get();
    
            $completed = Task::with([
                'user'=>function($q){
                    $q->select('id', 'firstname', 'lastname');
                }
            ])
            ->where([['company_id', $company->id],['is_visible',true]])
            ->where('status', 0)
            ->get();
        }
        
        // dd($task);

        return view('management.task',[
            'task'      => $task,
            'onprogress'=> $onprogress,
            'completed'=> $completed
        ]);

    } /*public function OMTask()*/

    public function addTask(){

        // $company = Employee::with([
        //     'company'=>function($q){
        //         $q->select('id', 'name');
        //     }
        // ])
        // ->first();
        $employee = Employee::where('user_id',Auth::user()->id)->first();
        $company = $employee->company;
        $employees = Employee::where('company_id', $company->id)->get();        

        return view('management.addTask',[
            'employee' => $employees
        ]);

    } /* public function addTask() */

    public function storeTask(Request $request){

        $validator = $request->validate([
            'employee' => 'required',
            'name' => 'required',
            'description' => 'required',
            'priority' => 'required'
        ]);

        // $company = Employee::with([
        //     'company'=>function($q){
        //         $q->select('id', 'name');
        //     }
        // ])
        // ->first();
        $user = Auth::user();

        $employee = Employee::where('user_id',$user->id)->first();
        $company = $employee->company;
        
        $task = new Task;
        $task->assigned_by = $user->id;
        $task->assigned_for = $request->employee;
        $task->company_id = $company->id;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->priority = $request->priority;
        if(!$request->has('is_visible') && $employee->user->role=='employee')
            $task->is_visible = false;
        $task->save();

        if($task->save()){

            if(Auth::User()->id!=$request->employee) {
                $message = 'Assigned the task '.$request->name.' with level '.$request->priority.' priority.';
                $details = [
                    'title' => 'New Assigned Task',
                    'message' => $user->firstname.' '.$user->lastname.' '.$message
                ];
    
                Notification::create([
                    'sender_id' =>  $user->id,
                    'receiver_id' => $task->assigned_for,
                    'message' => $message
                ]);
    
                \Mail::to($task->user->email)->send(new NotifyMail($details));
            }

            Log::create([
                'user_id' => Auth::User()->id,
                'action' => 'add',
                'table' => 'tasks',
                'row_id' => $task->id
            ]);

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
                Log::create([
                    'user_id' => Auth::User()->id,
                    'action' => 'update',
                    'table' => 'tasks',
                    'row_id' => $task->id
                ]);

                Notification::create([
                    'sender_id' =>  Auth::User()->id,
                    'receiver_id' => $task->assigned_by,
                    'message' => 'Marked the task '.$task->name.' with level '.$task->priority.' priority as Complete'
                ]);

                Alert::Success('Success!', 'Task Completed');
                return back()->with('message','Operation Successful !');
            }
        }
        if($task->status == '0'){
            $task->status = '1';
            $task->end_date = null;
            $task->save();

            if($task->save()){
                Log::create([
                    'user_id' => Auth::User()->id,
                    'action' => 'update',
                    'table' => 'tasks',
                    'row_id' => $task->id
                ]);

                Notification::create([
                    'sender_id' =>  Auth::User()->id,
                    'receiver_id' => $task->assigned_by,
                    'message' => 'Marked the task '.$task->name.' with level '.$task->priority.' priority as Pending'
                ]);
                Alert::Success('Success!', 'Task Pending');
                return back()->with('message','Operation Successful !');
            }
        }

    }   /* updateTask */

    public function deleteTask(Request $request) {

        $validator = $request->validate([
            'modaltaskid' => 'required',
            'delmessage' => 'required|max:100'
        ]);

        $task = Task::find($request->modaltaskid);
        $task->status = '1';
        $task->end_date = null;
        $task->save();

        if($task->save()){           
            Log::create([
                'user_id' => Auth::User()->id,
                'action' => 'delete',
                'table' => 'tasks',
                'row_id' => $task->id
            ]);
            $taskDeletion = TaskDeletion::create([
                'task_id' => $request->modaltaskid,
                'message' => $request->delmessage,
                'user_id' => Auth::user()->id
            ]);
            Log::create([
                'user_id' => Auth::User()->id,
                'action' => 'add',
                'table' => 'task_deletions',
                'row_id' => $taskDeletion->id
            ]);
            Notification::create([
                'sender_id' =>  Auth::User()->id,
                'receiver_id' => $task->assigned_by,
                'message' => 'Deleted the task '.$task->name.' with level '.$task->priority.' with the message '.$request->delmessage.'.'
            ]);
            Alert::Success('Success!', 'Task Pending');
            return back()->with('message','Operation Successful !');
        }
    }

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
            $validator = $request->validate([
                'name' => 'required|unique:suppliers',
                'email' => 'email|required|unique:suppliers',
                'address' => 'required',
            ]);

            /* Save new supplier */
            $user = Auth::user();
            $employee = Employee::where('user_id', $user->id)->first();
            
            $data = [
                'company_id' => $employee->company_id,
                'name'       => $request->name,
                'email'       => $request->email,
                'address'    => $request->address
            ];
            $supplier = Supplier::firstOrcreate($data);

            Log::create([
                'user_id' => Auth::User()->id,
                'action' => 'add',
                'table' => 'suppliers',
                'row_id' => $supplier->id
            ]);
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
           if(Auth::user()->role!='employee')
           $supplier->active = $request->active;
           
           $supplier->save();

           Log::create([
                'user_id' => Auth::User()->id,
                'action' => 'update',
                'table' => 'suppliers',
                'row_id' => $supplier->id
            ]);

            return redirect('suppliers');

        }
    }

    public function logs() {
        return view('users.ceo.logs')->with('logs',Log::all());
    }

    public function notifications() {
        return view('users.notifications')->with('notifications',Notification::where('receiver_id',Auth::user()->id)->get());
    }

    public function notificationsMark($id) {

        Notification::where('id',$id)->update(['is_read' => true]);
        Alert::Success('Success!', 'Notification marked as read!');
        return redirect()->route('notifications');
    }
    
    public function toMillUpdateSold($id) {
        
        $toMill = ToMill::find($id);
        $toMill->is_sold = true;
        $toMill->save();

        $employees = Employee::where('company_id',$toMill->company_id)->get();
        foreach($employees as $employee) {
            if($employee->user->role == 'ceo' || $employee->user->role == 'manager')
                Notification::create([
                    'receiver_id' => $employee->user_id,
                    'message' => 'Palay with variant '.$toMill->product->name.' with '.$toMill->rice->quantity.' '.$toMill->rice->unit.' and '.$toMill->darak->quantity.' '.$toMill->rice->unit.'.'
                ]);
        }

        Log::create([
            'user_id' => Auth::User()->id,
            'action' => 'update',
            'table' => 'to_mill',
            'row_id' => $id
        ]);
        Alert::Success('Success!', 'Milled Products marked as sold!');
        return redirect()->route('supply-milled');
    }
}

