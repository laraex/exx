@extends('backpack::layout')
@section('content')
<section class="section">
    <div class="row">
        <div class="container">
            <h3>Giftcard Order</h3>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form method="post" action="{{ url('/admin/giftcardorders/addtowallet/'.$giftcardconfirm->id)}}" class="form-horizontal" id="contact" enctype="multipart/form-data">
                            {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Image : </label>
                                    <input type="file" name="giftcardorder">
                                </div>   
                                <div class="form-group">
                                    <textarea  rows="5" class="form-control"  placeholder="Comments" name="comment" id="comment" required></textarea>
                                </div>  
                                <div class="form-group">
                                    {!! Form::submit(trans('forms.confirm_btn'), ['class' => 'btn btn-primary']) !!}
                                    <a href="{{ url('/admin/giftcardorders') }}" class='btn btn-info'>Back to List</a>
                                </div>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
