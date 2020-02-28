@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <admin-gift-component baseurl="{{ url('/admin') }}"></admin-gift-component>
        </div>
    </div>
@endsection
<script>
    import GiftComponent from "../../js/components/Admin/GiftComponent";

    export default {
        components: {GiftComponent}
    }
</script>
