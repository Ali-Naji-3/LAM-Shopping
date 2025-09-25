
@extends('admin.dashboard')

@section('content')

{{-- <x-app-layout>
    <x-slot name="header"> --}}
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight ">
                {{ __('Permissions') }}
            </h2>
          <a href="{{ route('permissions.create') }}" class="btn btn-success btn-sm rounded">
  Create
</a>
        </div>
    {{-- </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- <x-message></x-message> --}}

           <div class="table-responsive">
    <table class="table table-striped table-hover align-middle mb-0" role="table" aria-label="Product Table">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Created</th>

               <th scope="col" class="text-center" style="width:150px;">Actions</th>
            </tr>
        </thead>
        <tbody>
  @if ($permissions->isNotEmpty())
                    @foreach ($permissions as $permission)
                        <tr>
                            <td class="px-6 py-3 text-left">{{$permission->id}}</td>
                            <td class="px-6 py-3 text-left">{{$permission->name}}</td>
                            <td class="px-6 py-3 text-left">{{ $permission->created_at->format('d M, Y') }}</td>
                                       <td class="actions-col">
   <div class="d-flex gap-2 justify-content-center align-items-center">
    <!-- Edit -->
    <a href="{{ route('permissions.edit',$permission->id) }}"
       class="btn btn-sm btn-outline-warning d-flex align-items-center justify-content-center"
       style="width: 35px; height: 35px; border-radius: 50%;"
       title="Edit">
        <i class="bi bi-pencil"></i>
    </a>

    <!-- Delete -->
    <a href="javascript:void(0);"
       onclick="deleteItem({{ $permission->id }})"
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
               {{$permissions->links()}}
           </div>
        </div>
    </div>

    {{-- <x-slot name="scripts">
<script type="text/javascript">
function deleteItem(id){
    if(confirm('Are you sure to delete?')){
        $.ajax({
            url: '{{ route("permissions.destroy") }}',
            type: 'DELETE',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response){
                if(response.status){
                    window.location.reload(); // refresh page to show changes
                } else {
                    alert('Permission not found!');
                }
            },
            error: function(err){
                console.log(err);
                alert('Delete failed!');
            }
        });
    }
}
</script>
</x-slot>
</x-app-layout> --}}
@endsection
