<x-app-layout>
  <div class="container mt-5">
      <h1 style="font-size:30px" ms-5 >Groups</h1>
      <!-- Button trigger modal -->
<button type="button" class="btn btn-primary mt-5" data-toggle="modal" data-target="#creategroupmodal">
  Create Group
</button>

  <table class="table">
      <thead>
          <tr>
              <th>S.No </th>
              <th>Image</th>
              <th>Name</th>
              <th>Limit</th>
              <th>Members</th>
              <th>Actions</th>
          </tr>
      </thead>
      <tbody>
          @if(count($groups) > 0)
          @php
              $i=0;
          @endphp
          @foreach ($groups as $group)
              <tr>
                  <td>{{++$i}}</td>
                  <td><img src="{{$group->image}}" alt="{{$group->name}}" width="100px" height="100px"></td>
                  <td>{{$group->name}}</td>
                  <td>{{$group->join_limit}}</td>

                  <td>
                  <a style="cursor: pointer" class="addMember"
                  data-limit="{{$group->join_limit}}"
                  data-id="{{$group->id}}" data-toggle="modal" data-target="#memberModal">
                  Members
              </a>
              </td>
              <td>
                  <i class="fa fa-trash deleteGroup" aria-hidden="true" data-id="{{$group->id}}"data-name="{{$group->name}}"data-toggle="modal" data-target="#deleteGroupModal"> </i>
                  <a class="copy cursor-pointer" data-id="{{$group->id}}">
                    <i class="fa fa-copy" ></i>
                  </a>
              </td>
              </tr>

          @endforeach


          @else

          <tr>
              <th colspan="6"> No groups found</th>
          </tr>
          @endif
      </tbody>

  </table>
<!-- Modal -->
<div class="modal fade" id="creategroupmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLongTitle">Create group</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;


          </span>
        </button>
      </div>
      <form enctype="multipart/form-data" id="createGroupForm">
          @csrf
      <div class="modal-body">
        <input type="text" name="name" placeholder="Enter Group Name" class="w-100 mb-2" required>

        <input type="file" name="image" class="w-100 mb-2" required>

        <input type="number" name="limit" min="1" placeholder="Enter user
        Limit" required class="w-100 mb-2">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Create</button>
      </div>
      </form>
    </div>
  </div>
</div>

  <!-- Member Modal -->
  <div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

      <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">

          <div class="modal-header">

            <h5 class="modal-title" id="exampleModalLongTitle">Members</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

              <span aria-hidden="true">&times;


              </span>
            </button>
          </div>
          <form id="add-member-form">
              @csrf
          <div class="modal-body">
              <input type="hidden" name="group_id" id="add-group-id">
              <input type="hidden" name="limit" id="add-limit">

              <table class="table">
                  <thead>
                      <tr>
                          <th>Select</th>
                          <th>Name</th>
                      </tr>

                  </thead>
                  <tbody>
                      <tr>
                          <td colspan="2">
                              <div class="addMemberTable">

                                  <table class="table addMembersInTable">

                                  </table>

                              </div>

                          </td>
                      </tr>
                  </tbody>

              </table>
          </div>
          <div class="modal-footer">
              <span id="add-member-error"></span>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add members</button>
          </div>
          </form>
        </div>
      </div>
    </div>


    {{-- delete group --}}

  <div class="modal fade" id="deleteGroupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

      <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">

          <div class="modal-header">

            <h5 class="modal-title" id="exampleModalLongTitle">Delete Group</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">

              <span aria-hidden="true">&times;


              </span>
            </button>
          </div>
          <form id="delete-group-form">
              @csrf
          <div class="modal-body">
              <input type="hidden" name="id" id="delete-group-id">
              <p>Are you sure you want to delete <b id="group-name"></b> Group?</p>
          </div>
          <div class="modal-footer">
              <span id="add-member-error"></span>
              
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Delete Group</button>
          </div>
          </form>
        </div>
      </div>
    </div>


  </div>


</x-app-layout>
