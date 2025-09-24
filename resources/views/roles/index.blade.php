

      @extends('admin.layouts.dashboard')

@section('content')
       <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight ">
                {{ __('Roles') }}
            </h2>
            <a href="{{ route('roles.create') }}"
              class="btn btn-success btn-sm rounded">
                Create
            </a>
        </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

           {{-- <table class="w-full">
            <thead class="bg-gray-200 text-gray-600  text-sm leading-normal">
                <tr class="border-b border-gray-200">
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left">Permissions</th>
                    <th class="px-6 py-3 text-left">Created</th>
                    <th class="px-6 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @if ($roles->isNotEmpty())
                    @foreach ($roles as $role)
                        <tr>
                            <td class="px-6 py-3 text-left">{{$role->id}}</td>
                            <td class="px-6 py-3 text-left">{{$role->name}}</td>
                            <td class="px-6 py-3 text-left">{{$role->permissions->pluck('name')->implode(',')}}</td>
                            <td class="px-6 py-3 text-left">{{ $role->created_at->format('d M, Y') }}</td>
                            <td class="px-6 py-3 text-center">
                                @can('edit roles')
                                <a href="{{ route('roles.edit',$role->id) }}"
                                   class="bg-slate-600 px-4 py-2 text-sm text-white rounded-md hover:bg-slate-500">
                                    Edit
                                </a>
                                @endcan
                                <a href="javascript:void(0);" onclick="deleteItemRole({{ $role->id }})"
                                   class="bg-red-600 px-4 py-2 text-sm text-white rounded-md hover:bg-slate-500">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
           </table> --}}
                      <div class="table-responsive">
    <table class="table table-striped table-hover align-middle mb-0" role="table" aria-label="Product Table">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                               <th class="px-6 py-3 text-left">Permissions</th>
                <th scope="col">Created</th>

               <th scope="col" class="text-center" style="width:150px;">Actions</th>
            </tr>
        </thead>
        <tbody>
   @if ($roles->isNotEmpty())
                    @foreach ($roles as $role)
                        <tr>
                            <td class="px-6 py-3 text-left">{{$role->id}}</td>
                            <td class="px-6 py-3 text-left">{{$role->name}}</td>
                            <td class="px-6 py-3 text-left">{{$role->permissions->pluck('name')->implode(',')}}</td>
                            <td class="px-6 py-3 text-left">{{ $role->created_at->format('d M, Y') }}</td>
                                       <td class="actions-col">
   <div class="d-flex gap-2 justify-content-center align-items-center">
    <!-- Edit -->
    <a href="{{ route('roles.edit',$role->id) }}"
       class="btn btn-sm btn-outline-warning d-flex align-items-center justify-content-center"
       style="width: 35px; height: 35px; border-radius: 50%;"
       title="Edit">
        <i class="bi bi-pencil"></i>
    </a>

    <!-- Delete -->
    <a href="javascript:void(0);"
       onclick="deleteItemrole({{ $role->id }})"
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
               {{$roles->links()}}
           </div>
        </div>
    </div>
@endsection
