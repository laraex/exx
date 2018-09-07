<div class="comments-list">
        @foreach($commentlists as $data)
            <div class="comment-wrapper">
                    <div class="comment-update">
                        <p>{{ $data->user->name }} <span><small> {{ $data->created_at->diffForHumans() }} </small></span></p>
                    </div>
                    <div class="comment-content">
                            <p>{{ $data['content'] }}</p>
                     </div>
            </div>
        @endforeach
</div>
       {{ $commentlists->links() }}