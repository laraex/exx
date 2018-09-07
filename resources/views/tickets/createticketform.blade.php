<form method="post" action="{{ url('myaccount/ticket/store')}}" class="form-horizontal" id="ticket" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                        <label>{{ trans('forms.subject') }}</label>
                        <input type="text" name="subject" id="subject" class='form-control' value="{{ old('subject') }}">
                        <small class="text-danger">{{ $errors->first('subject') }}</small>
                    </div>
                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label>{{ trans('forms.description') }}</label>
                        <textarea class='form-control' name="description" >{{ old('description') }}</textarea>
                        <small class="text-danger">{{ $errors->first('description') }}</small>
                    </div>
                    <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
                        <label>{{ trans('forms.priority') }}</label>
                        <select class="form-control" id="priority" name="priority">  
                            @foreach ($priorities as $priority)
                                <option value="{{ $priority->id }}" {{ (Form::old("priority") == $priority->id ? "selected":"") }}>{{ $priority->name }}</option>
                            @endforeach
                        </select>
                        
                        <small class="text-danger">{{ $errors->first('priority') }}</small>
                    </div>
                    <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                        <label>{{ trans('forms.category') }}</label>
                        <select class="form-control" id="category" name="category">  
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ (Form::old("category") == $category->id ? "selected":"") }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        
                        <small class="text-danger">{{ $errors->first('category') }}</small>
                    </div>

                     <div class="form-group{{ session('mimecheck') ? ' has-error' : '' }}">
                        <label>{{ trans('forms.attachment') }} (Jpeg, Jpg, Png, Pdf.)</label>
                       <input type="file" name="attachments[]" multiple='multiple' />
                        <small class="text-danger">{{ session('mimecheck') }}</small>
                    </div>

                    <div class="form-group">
                        <input value="{{ trans('forms.submit_btn') }}" class="btn btn-success" type="submit">
                        <a href="" class="btn btn-default">{{ trans('forms.reset') }}</a>
                    </div>
                </form>