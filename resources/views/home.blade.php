@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
{{--            <div class="col-md-8">--}}
                {{--            <div class="card">--}}
                {{--                <div class="card-header">Dashboard</div>--}}

                {{--                <div class="card-body">--}}
                {{--                    @if (session('status'))--}}
                {{--                        <div class="alert alert-success" role="alert">--}}
                {{--                            {{ session('status') }}--}}
                {{--                        </div>--}}
                {{--                    @endif--}}

                {{--                    You are logged in!--}}
                {{--                </div>--}}
                {{--            </div>--}}
{{--            </div>--}}
            <admin-gift-component></admin-gift-component>
        </div>
    </div>
@endsection
<script>
    import GiftComponent from "../js/components/Admin/GiftComponent";

    export default {
        components: {GiftComponent}
    }
</script>
