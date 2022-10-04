@extends('layouts.nav')

@section('content')
<div class="container">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Task</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if(Auth::user()->role == 'ceo')
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">CEO</a></li>
                        @endif
                        @if(Auth::user()->role == 'manager')
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Manager</a></li>
                            @endif
                        <li class="breadcrumb-item active">Task</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        TASKS
                        <a href="{{ route('addTask') }}" class="mr-2 btn btn-sm btn-warning float-right">
                            <i class="nav-icon fa-solid fas fa-plus"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="bg-warning">
                                <tr>
                                    <th>Assigned to</th>
                                    <th>Task</th>
                                    <th>Date Assigned</th>
                                    <th>Date Completed</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($task) == 0)
                                <span class="d-flex justify-content-center bg-danger">
                                    No Active Task
                                </span>
                                @endif
                                @if(count($task) != 0)
                                @foreach($task as $row)
                                <tr>
                                    <td> {{$row->user->firstname}} {{$row->user->lastname}} </td>
                                    <td> {{$row->name}} 
                                        @if($row->priority==1)
                                            <span class="badge badge-danger">Priority Level 1</span>
                                        @elseif($row->priority==2)
                                            <span class="badge badge-danger">Priority Level 2</span>
                                        @elseif($row->priority==3)
                                            <span class="badge badge-info">Priority Level 3</span>
                                        @elseif($row->priority==4)
                                            <span class="badge badge-warning">Priority Level 4</span>
                                        @elseif($row->priority==5)
                                            <span class="badge badge-warning">Priority Level 5</span>
                                        @endif
                                    </td>
                                    <td>{{ Carbon\Carbon::parse($row->created)->toDateTimeString() }}</td>
                                    <td>
                                        @if($row->end_date)
                                        {{ Carbon\Carbon::parse($row->end_date)->toDateTimeString() }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td> {{$row->status == 1 ? 'In Progress...' : 'Completed' }} </td>
                                    @if($row->status == 1)
                                    <td>
                                        <a class="btn btn-warning" href="{{url('update-task/'.$row->id)}}">
                                            <i class="fas fa-check"></i>
                                        </a>
                                    </td>
                                    @endif
                                    @if($row->status == 0)
                                    <td>
                                        {{-- <a class="btn btn-danger" href="{{url('update-task/'.$row->id)}}">
                                            <i class="fas fa-times"></i>
                                        </a> --}}
                                        <button class="btn btn-danger" data-id="{{ $row->id }}" data-toggle="modal" data-target="#exampleModal">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        COMPLETED
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="bg-warning">
                                <tr>
                                    <th>Assigned to</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($completed) == 0)
                                <span class="d-flex justify-content-center bg-danger">
                                    No Completed Tasks
                                </span>
                                @endif
                                @if(count($completed) != 0)
                                @foreach($completed as $row)
                                <tr>
                                    <td>{{$row->user->firstname}} {{$row->user->lastname}}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->updated_at}}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        IN PROGRESS
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="bg-warning">
                                <tr>
                                    <th>Assigned To</th>
                                    <th>Task</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($onprogress) == 0)
                                <span class="d-flex justify-content-center bg-danger">
                                    No On Going Tasks
                                </span>
                                @endif
                                @if(count($onprogress) != 0)
                                @foreach($onprogress as $row)
                                <tr>
                                    <td> {{$row->user->firstname}} {{$row->user->lastname}} </td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->updated_at}}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<form action="{{ route('deleteTask') }}">
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h5 class="modal-title" id="exampleModalLabel">Delete Task?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="number" name="modaltaskid" id="modaltaskid" hidden>
          <textarea id="delmessage" name="delmessage" class="form-control" required>

          </textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Delete Task</button>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@section('scripts')
<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') // Extract info from data-* attributes
        //var task = button.data('task')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        //modal.find('.modal-title').text('Task: ' + task)
        modal.find('#modaltaskid').val(id)
})
</script>
@endsection