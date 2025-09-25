 <script>
        // Auto dismiss alerts after 5 seconds
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
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
        function deleteItemrole(id){
    if(confirm('Are you sure to delete?')){
        $.ajax({
            url: '{{ route("roles.destroy") }}',
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

function deleteItemuser(id){
    if(confirm('Are you sure to delete?')){
        $.ajax({
            url: '{{ route("users.destroy") }}',
            type: 'DELETE',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response){
                if(response.status){
                    window.location.reload(); // refresh page to show changes
                } else {
                    alert('Roles not found!');
                }
            },
            error: function(err){
                console.log(err);
                alert('Delete failed!');
            }
        });
    }
}
 function clearModalBackdrops() {
            document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
                backdrop.remove();
            });
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            console.log('Modal backdrops cleared');
        }

        // Immediate backdrop cleanup
        document.addEventListener('DOMContentLoaded', function() {
            // Clear on page load
            clearModalBackdrops();

            // Clear on window focus (when returning to tab)
            window.addEventListener('focus', clearModalBackdrops);

            // Clear on page visibility change
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden) {
                    clearModalBackdrops();
                }
            });

            // Emergency clear on any click if backdrop exists but no modal is open
            document.addEventListener('click', function(e) {
                setTimeout(function() {
                    if (!document.querySelector('.modal.show') && document.querySelector('.modal-backdrop')) {
                        clearModalBackdrops();
                    }
                }, 100);
            });
        });
         setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
