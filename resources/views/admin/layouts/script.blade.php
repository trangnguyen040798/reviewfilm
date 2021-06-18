<script src="{{ asset('bower_components/bower/admin/myjs/jquery-3.5.1.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/bower/admin/myjs/moment.min.js') }}
"></script>
{{-- <script src="{{ asset('bower_components/bower/admin/myjs/popper.min.js') }}"></script> --}}
<script src="{{ asset('bower_components/bower/admin/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('bower_components/bower/admin/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>

<script src="{{ asset('bower_components/bower/admin/myjs/fullcalendar.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('bower_components/bower/admin/myjs/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('bower_components/bower/admin/demo/default/custom/components/base/toastr.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/bower/admin/myjs/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/bower/admin/myjs/fileinput.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/bower/admin/myjs/handlebars.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('bower_components/bower/admin/myjs/comboTreePlugin.js') }}"></script>
<script src="{{ asset('bower_components/bower/admin/myjs/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('bower_components/bower/admin/myjs/select2.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() {
	    $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	    });
	});
	let asset = '{{ asset('') }}';
</script>
@yield('script')