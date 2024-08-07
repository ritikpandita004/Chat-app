<x-app-layout>

    <div class="container mt-4">

        <img src="/{{$groupData->image}}" width="200px" height="200px" alt="">
        <h1><b>{{$groupData->name}}</b></h1>
        <p><b>Total Members:- </b>{{$totalMembers}}</p>

    @if ($available != 0)
    <p> Available for <b> {{$available}}</b> Members </p>

    @endif
    @if ($isOwner)
    <p>Creator cannot join the group</p>

    @elseif($isJoined>0)
    <p>You arlready have joined this group</p>

    @elseif($available==0)
    <p>the group is full</p>

    @else

    <button class="btn btn-primary join-now" data-id="{{$groupData->id}}">Join now</button>


    @endif
    </div>




</x-app-layout>
