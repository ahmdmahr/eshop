<!-- Javascript -->
<script src="{{asset('backend/assets/bundles/libscripts.bundle.js')}}"></script>    
<script src="{{asset('backend/assets/bundles/vendorscripts.bundle.js')}}"></script>
<script src="{{asset('backend/assets/bundles/jvectormap.bundle.js')}}"></script> 

{{-- summernote --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>

<script src="{{asset('backend/assets/vendor/summernote/dist/summernote.js')}}"></script>
{{---------------------------------}}

<!-- JVectorMap Plugin Js -->
<script src="{{asset('backend/assets/bundles/morrisscripts.bundle.js')}}"></script>
<script src="{{asset('backend/assets/bundles/knob.bundle.js')}}"></script>
<script src="{{asset('backend/assets/bundles/mainscripts.bundle.js')}}"></script>
<script src="{{asset('backend/assets/js/pages/ui/sortable-nestable.js')}}"></script>
<script src="{{asset('backend/assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('backend/assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('backend/assets/vendor/switch-button-bootstrap/src
/bootstrap-switch-button.js')}}"></script>
<script src="{{asset('backend/assets/js/index.js')}}"></script>




@yield('scripts')

<script>
    setTimeout(function(){
        $('#alert').slideUp();
    },4000);
</script>