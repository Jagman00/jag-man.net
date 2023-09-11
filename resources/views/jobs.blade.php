@extends('auth.layouts')



<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@section('content')
<div class="items-center justify-center text-white">

I have completed {{ auth()->user()->jobs->count() }} jobs!
<div class="jobCard border-0 ">
    
            <div class="card-body jobCardTable">
                <div class="jobsTable items-center table-wrap overflow-hidden"><div class='container'>
                <table id="jobT" class="table items-center" style="width:100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope='col'>Job ID</th>
                            <th scope='col'>Name</th>
                            <th scope='col'>Source</th>
                            <th scope='col'>Destination</th>
                            <th scope='col'>Distance Driven</th>
                            <th scope='col'>Cargo</th>
                            <th scope='col'>Cargo Damage</th>
                            
                        </tr>
                    </thead>
                </table>
    </div>
</div>
            </div>
        </div>
</div>
   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js" charset="utf8" type="text/javascript"></script>

<script type="text/javascript">
    $(function () {
          var table = $('#jobT').DataTable({
              processing: true,
              serverSide: true,
              ajax: "{{ route('jobs.index') }}",
              order: [[0, 'desc']],
                searching: false,
                pagingType: 'simple_numbers',
                "pageLength" : 10,
                "bLengthChange": false,
              columns: [
                {
                        data: 'jobID'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: "jobSourceCity"
                        
                    },
                    {
                        data: 'jobDestinationCity'
                    },
                    {
                        data: 'jobDistanceDriven',
                        render: function (data) {
                            var newData = data + ' KM';
                            return newData;
                        }
                        
                    },
                    {
                        data: 'jobCargo'
                    },
                    {
                        data: 'actualCargoDamage',
                        render: function(data) {
                            var newData = (data*100).toFixed(2);
                            return newData + ' %'; 
                        }
                    },
              ], responsive: true,
          });
        });
</script>
@endsection