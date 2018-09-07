<div class="flex mb-20">
                            <div class="stats-box">
                                <p>Pending</p>
                                <h3 class="is-amount">{{ $pendingsum }} <small>{{ config::get('settings.currency') }}</small></h3>
                            </div>
                            <div class="stats-box">
                                <p>Completed</p>
                                <h3 class="is-amount">{{ $completedsum }} <small>{{ config::get('settings.currency') }}</small></h3>
                            </div>
                            <div class="stats-box">
                                <p>Lifetime</p>
                                <h3 class="is-amount">{{ $lifetimesum }} <small>{{ config::get('settings.currency') }}</small></h3>
                            </div>
                            
                     </div>