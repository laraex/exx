                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        <i class="glyphicon glyphicon-bell"></i> <span class="label label-danger">{{ count(Session::get('usernotifications')) }}</span>
                                    </a>
                                    <ul class="dropdown-menu p-0 dropdown-menu-lg">
                                       @foreach (Session::get('usernotifications') as $notification)
                                          <li>
                                            <form method="post" class="rejectkyc" action="{{ url('myaccount/notification') }}">
                                            {{ csrf_field() }} 
                                            <input type="hidden" name="notificationid" value="{{ $notification['id'] }}">
                                            <input type="hidden" name="notificationtype" value="{{ $notification['type'] }}">
                                            {!! Form::submit($notification->data['string1'] , ['class' => '']) !!}
                                            </form>
                                        </li>
                                       @endforeach
                                    </ul>
