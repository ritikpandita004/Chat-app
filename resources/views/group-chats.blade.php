<x-app-layout>
 

    <div class="container mt-5">
        <div class="row">
            @if (count($groups) > 0 || count($joinedGroups) > 0)
                <div class="col-md-3">
                    <ul class="list-group">
                        @foreach ($groups as $group)
                            <li class="list-group-item list-group-item-dark cursor-pointer group-list" data-id="{{ $group->id }}">
                                <img src="/{{ $group->image }}" alt="Group Image" class="user-image">
                                {{ $group->name }}
                            </li>
                        @endforeach

                        {{-- Joined Groups --}}
                        @foreach ($joinedGroups as $group)
                            @if ($group->getGroup)
                                <li class="list-group-item list-group-item-dark cursor-pointer group-list" data-id="{{ $group->getGroup->id }}">
                                    <img src="/{{ $group->getGroup->image }}" alt="Group Image" class="user-image">
                                    {{ $group->getGroup->name }}
                                </li>
                            @else
                                <li class="list-group-item list-group-item-dark">
                                    <em>Group not found</em>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                <div class="col-md-9">
                    <h3 class="group-start-head">Start the chat</h3>

                    <div class="group-chat-section">
                        <div id="group-chat-container" class="message-container">
                            <!-- Example messages -->
                            <div class="message sent">Hello, this is a sent message!</div>
                            <div class="message received">Hi there, this is a received message!</div>
                        </div>
                        <form action="" id="group-chat-form">
                            <input type="text" name="message" placeholder="Enter the message" id="group-message" class="border" required>
                            <input type="submit" value="send-message" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            @else
                <div class="col-md-12">
                    <h5>No groups Found</h5>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
