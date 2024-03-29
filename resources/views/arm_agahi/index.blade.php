@extends('layouts.app')
@section('content')
@if(session()->has('warning'))
    <div class="alert alert-warning">{{session()->get('warning')}}</div>
@endif
    <table class="table table-bordered">
        <tr style="height:1px;">
            <th style="width:30px; background-color:lightblue; text-align:center;">ردیف</th>
            <th style="width:200px; background-color:lightblue; text-align:center;">عنوان شبکه</th>
            <th style="width:100px; background-color:lightblue; text-align:center;">ضریب آرم آگهی</th>
            <th style="width:100px; background-color:lightblue; text-align:center;">از تاریخ</th>
            <th style="width:100px; background-color:lightblue; text-align:center;">تا تاریخ</th>
            <th style="width:200px; background-color:lightblue; text-align:center;">View Log File</th>
            <th style="width:200px; background-color:lightblue;">Action</th>
        </tr>
        @foreach($channels as $channel)
            @foreach($arm_agahies as $arm)
                @if($channel->id == $arm->channel_id)
                    <tr class="rowt" style="height:1px;">
                        <td class="rowtt" style="height:1px; text-align:center;"></td>
                        <td style="height:1px;">{{$channel->channel_name}}</td>
                        <td style="height:1px;">{{$arm->coef}}</td>
                        <td style="height:1px;">{{$arm->from_date}}</td>
                        <td style="height:1px;">{{$arm->to_date}}</td>

                        @foreach($users as $user)
                            @if($user->id == $arm->user_id)
                                <td>{{$user->name}}</td>
                            @endif
                        @endforeach

                        <td class="btn-group" >
                            @can('Edit_ArmAgahi')
                                <a href="{{route('arm_agahi.edit', $arm->id)}}" class="btn btn-warning btn-send-ajax" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-pencil-alt"></i></a>
                            @endcan

                            @can('Delete_ArmAgahi')
                            <form action="{{route('arm_agahi.destroy' , $arm->id)}}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger"><i class="fa fa-trash-alt"></i></button>
                            </form>
                            @endcan
                        </td>

                    </tr>
                @endif
            @endforeach
        @endforeach
    </table>  

    <form action="{{route('arm_agahi_search')}}" method="get">  
        <!-- <div class="container"> -->
            <label style="font-weight:bold; color:gray; margin-right:20px;">جستجو</label>
            <div style="width: fit-content">
            <div class="row" style="border:1px ridge lightblue; height:70px; margin-right:10px; padding:15px;">

                <div class="col" >
                    <div class="form-group" style="width:300px;">
                        <select name="channel_id" id="myselect" multiple>
                            @foreach($channels as $channel)
                                <option value="{{$channel->id}}">{{$channel->channel_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <input type="text" name="coef" class="form-control" placeholder="ضریب">
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <input data-jdp name="from_date" placeholder="از تاریخ" class="form-control" />
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <input data-jdp name="to_date" placeholder="تا تاریخ" class="form-control" />
                    </div>
                </div>

                <div class="col">
                    <div class="form-group" style="width:300px;">
                        <select name="user_id" id="myselect-2" multiple>
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <input type="submit" value="جستجو" class="btn btn-primary">
                    </div>
                </div>
                
            </div>
            </div>
        <!-- </div> -->
    </form>


    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        // add form edit
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>

    $('.btn-send-ajax').click(function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
        url:url 
        })
        .done(function( data ) {
            console.log(data);
        });
    });
</script>
@endsection

