<h4>Withdraw Details</h4>
   <div class="col-md-12 well">
    <div class="col-md-4">
        <p>Pending</p>
        <h3 class="is-amount">{{ $pendingsum }} <small>{{ config::get('settings.currency') }}</small></h3>
    </div>
    <div class="col-md-4">
        <p>Completed</p>
        <h3 class="is-amount">{{ $completedsum }} <small>{{ config::get('settings.currency') }}</small></h3>
    </div>
    <div class="col-md-4">
        <p>Lifetime</p>
        <h3 class="is-amount">{{ $lifetimesum }} <small>{{ config::get('settings.currency') }}</small></h3>
    </div>
    
</div>