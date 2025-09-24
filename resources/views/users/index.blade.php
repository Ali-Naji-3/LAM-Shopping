
            @extends('admin.layouts.dashboard')

@section('content')


     <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight ">
                {{ __('Users') }}
            </h2>
            <a href="{{ route('users.create') }}"
              class="btn btn-success btn-sm rounded">
                Create
            </a>
        </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


          <div class="table-responsive">
    <table class="table table-striped table-hover align-middle mb-0" role="table" aria-label="Product Table">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                {{-- <th scope="col">Phone</th> --}}
                <th scope="col">Role</th>
                <th scope="col">Created</th>

               <th scope="col" class="text-center" style="width:150px;">Actions</th>
            </tr>
        </thead>
        <tbody>
 @if ($users->isNotEmpty())
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-3 text-left">{{$user->id}}</td>
                            <td class="px-6 py-3 text-left">{{$user->name}}</td>
                            <td class="px-6 py-3 text-left">{{$user->email}}</td>
                            {{-- <td class="px-6 py-3 text-left">{{$user->mobile}}</td> --}}
                            <td class="px-6 py-3 text-left">{{$user->roles->pluck('name')->implode(',')}}</td>
                            <td class="px-6 py-3 text-left">{{ $user->created_at->format('d M, Y') }}</td>
                                       <td class="actions-col">
   <div class="d-flex gap-2 justify-content-center align-items-center">
    <!-- Edit -->
    <a href="{{ route('users.edit',$user->id) }}"
       class="btn btn-sm btn-outline-warning d-flex align-items-center justify-content-center"
       style="width: 35px; height: 35px; border-radius: 50%;"
       title="Edit">
        <i class="bi bi-pencil"></i>
    </a>

    <!-- Delete -->
    <a href="javascript:void(0);"
       onclick="deleteItemuser({{ $user->id }})"
       class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center"
       style="width: 35px; height: 35px; border-radius: 50%;"
       title="Delete">
        <i class="bi bi-trash"></i>
    </a>
</div>

</td>
                        </tr>
                    @endforeach
                @endif



            </tr>
            <!-- Repeat rows dynamically -->
        </tbody>
    </table>
</div>

           <div class="my-3">
               {{$users->links()}}
           </div>
        </div>
    </div>
    @endsection

