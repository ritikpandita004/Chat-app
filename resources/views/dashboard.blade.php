 <x-app-layout>
   <div class="container mt-5">
    <div class="row">


        @if (count($users)>0)

        <div class="col-md-3">
            <ul class="list-group">
                @foreach ($users as $user)
               @php
                   if ($user->image!==null && $user->image !=""){
                    $image = $user->image;
                   }


                    else{
                    $image="images/dummy.jpg";

                    }
               @endphp

                <li class="list-group-item list-group-item-dark cursor-pointer userlist "data-id="{{$user->id}}">

                <img src="{{ $image}}" alt="dsfdf" class="user-image">

                    {{ $user->name }}
                    <b><sup id="{{$user->id}}-status" class="offline-status">offline</sup></b>

                </li>

                <li>

                </li>

                @endforeach

            </ul>

        </div>


        <div class="col-md-9">
            <h3 class="start-chat">Start the chat</h3>

            <div class="chat-section">
                <div id="chat-container">


                </div>
                <form action="" id="chat-form">

                    <input type="text" name="message" placeholder="Enter the message" id="message" class="border" required>

                    <input type="submit" value="send-message" class="btn btn-primary">



                </form>

            </div>

        </div>



        @else

        <div class="col-md-12">

            <h5>No users Found</h5>

        </div>

        @endif
    </div>

   </div>


</x-app-layout>
