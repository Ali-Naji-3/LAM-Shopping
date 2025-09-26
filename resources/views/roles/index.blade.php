

      @extends('admin.dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-semibold fs-4 text-dark mb-0">
        {{ __('Roles') }}
    </h2>

    <a href="{{ route('roles.create') }}" class="btn btn-success btn-sm rounded mt-2 m-4 mb-0">
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

    {{ $roles->links('pagination::bootstrap-5') }}


           </div>
        </div>
    </div>
@endsection
