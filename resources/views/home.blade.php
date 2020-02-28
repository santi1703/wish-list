@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <admin-gift-list-component baseurl="{{ url('/') }}" userid="{{ \Illuminate\Support\Facades\Auth::user()->id }}"></admin-gift-list-component>
        </div>
    </div>
@endsection
<script>
    import GiftComponent from "../../js/components/GiftListComponent";

    export default {
        components: {GiftListComponent}
    }
</script>
