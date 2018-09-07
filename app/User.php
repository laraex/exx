<?php

namespace App;

use App\Notifications\ResetPasswordNotification;
use Backpack\CRUD\CrudTrait;
use App\Traits\UserInfo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cache;
use Laravel\Passport\HasApiTokens;
use Laracasts\Presenter\PresentableTrait;
/**
 * User Class
 *
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    use CrudTrait;
    use HasRoles;
    use UserInfo;
    use \Nckg\Impersonate\Traits\CanImpersonate;
    use SoftDeletes;
    use PresentableTrait;

    protected $presenter = "App\Presenters\SitePresenter";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'account_type',
        'referralgroup_id',
        'sponsor_id',
        'user_is_online',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'userprofile'
    ];

    /**
     * Additional appended attributes
     *
     * @var array
     */
    protected $appends = array('userprofile', 'uplines','isUserProfileCompleted','isKycApproved','isActive','SponsorCount','UserBalance');

    
     protected $with=['sponsor'];

    /**
     * A user belongs to a user group
     *
     * @return Usergroup Model
     */
    public function usergroup()
    {
        return $this->belongsTo('App\Models\Usergroup');
    }

    /**
     * A user belongs to a referral group
     *
     * @return Referralgroup Model
     */
    public function referralgroup()
    {
        return $this->belongsTo('App\Models\Referralgroup');
    }

    /**
     * A user has One User Profile
     *
     * @return Userprofile Model
     */
    public function userprofile()
    {
        return $this->hasOne('App\Models\Userprofile', 'user_id', 'id');
    }

    /**
     * A user has many user account - relation
     *
     * @return Useraccounts - collection
     */
    public function useraccount()
    {
        return $this->hasMany('App\Models\Usercurrencyaccount', 'user_id', 'id');
    }

    /**
     * A user has many activity logs
     *
     * @return activity logs - colletcion
     */
    public function loguser()
    {
        return $this->hasMany('App\Models\ActivityLog', 'causer_id', 'id');
    }

    /**
     * A user has many withdraws
     *
     * @return Withdraw Collection
     */
    public function withdraws()
    {
        return $this->hasMany('App\Models\Withdraw', 'user_id', 'id');
    }

    /**
     * A user has many tickets
     * 
     * @return Ticket Collection
     */
    public function agent()
    {
        return $this->hasMany('App\Models\Ticket', 'agent_id', 'id');
    }

    /**
     * A user has many gift card orders
     *
     * @return Giftcard Orders 
     * FIXME: 
     */
    public function giftcardorders()
    {
        return $this->belongsTo('App\GiftcardOrder');
    }

    /**
     * A user has one placement
     * 
     * @return Placement Model
     */
    public function placement()
    {
        return $this->hasOne('App\Placement', 'user_id');
    }

    public function referrals() {
        return $this->hasMany('App\User', 'sponsor_id');
    }


    /**
     * Appends a new sponsor user
     * 
     * @return User 
     */
    /*public function getSponsorAttribute()
    {
        if (is_null($this->sponsor_id)) {
            return null;
        } else {
            return User::find($this->sponsor_id);
        }
    }
*/

    /**
     * Appends all uplines 
     * 
     * @return User Collection
     */
    public function getUplinesAttribute()
    {
        
        $totalLevelsForCommission = 12;
        
        if ($this->placement()->exists()) {
            $uplines = $this->getUplines($totalLevelsForCommission);
            $uplineUsers = collect();
            foreach ($uplines as $upline) {
                $uplineUser= User::find($upline);
                $uplineUsers->push($uplineUser);
            }
            return $uplineUsers;
        } else {
            return null;
        }
    }
    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }  
    public function scopeByUserType($query, $group_id)
    {
        $query
            ->join('userprofiles', 'userprofiles.user_id', '=', 'users.id')
            ->where('userprofiles.usergroup_id', '=', $group_id);

        return $query;
        // return $query->where('usergroup_id', $id);
    }  
     public function getisUserProfileCompletedAttribute() {
        return $this->isUserProfileCompleted($this);
    }

    public function getisKycApprovedAttribute() {
        return $this->isKycApproved($this);
    }

    public function getisEmailVerifiedAttribute() {
        return $this->isEmailVerified($this);
    } 
     public function getIsActiveAttribute() {
        return $this->isActive($this);
    } 
    
    public function sponsor()
    {

        return $this->belongsTo('App\User', 'sponsor_id');
    }
    
//sowmi for export
    public function scopeUserGroup($query, $usergroup_id) 
    {
        return $query->whereHas('userprofile', function ($q) use ($usergroup_id) 
        {
            $q->where('usergroup_id',$usergroup_id);
        });
    }

//sowmi
    // public function balance()
    // {
    //     return $this->hasManyThrough('App\Models\Transaction','App\Models\Usercurrencyaccount','currency_id','account_id','id','id')->whereIn('usercurrencyaccounts.currency_id',[4,5,6,7])->where([['type','credit'],['status',1]]);
    // }

   //  public function referralCommissionTransactions()
   // {
   //      //$referral_accountingcode = $this->getAccountingCode('matrix-deposit-via-referral-commission');
     
   //     return $this->hasManyThrough('App\Transaction', 'App\Useraccount', 'user_id', 'account_id', 'id', 'id')->where('useraccounts.entity_type', 'Profile')->where([['type','credit'], ['status', 1], ['accounting_code_id', $this->referral_accountingcode]]);
   // }

    // public function userpayaccount()
    // {
    //     return $this->belongsTo('App\Models\Userpayaccount','id','user_id');
    // }
     
    public function isOnline()
    {
        return Cache::has('user_is_online'.$this->id);
    }

    public function scopeUserGroupforRegisterAfter($query,$usergroup_id,$date) 
    {
        return $query->whereHas('userprofile', function ($q) use ($usergroup_id,$date) 
        {
            $q->where('usergroup_id',$usergroup_id)
                ->where('created_at','>',$date);
        });
    }

    public function scopeUserGroupforRegisterBetween($query,$usergroup_id,$fromdate,$todate) 
    {
        return $query->whereHas('userprofile', function ($q) use ($usergroup_id,$fromdate,$todate) 
        {
            $q->where('usergroup_id',$usergroup_id)
                ->where([['created_at','>',$fromdate],['created_at','<',$todate]]);
        });
    }

    public function scopeUserGroupforRegisterOn($query,$usergroup_id,$registeron) 
    {
        return $query->whereHas('userprofile', function ($q) use ($usergroup_id,$registeron)
        {
            //dd($registeron);
            $q->where('usergroup_id',$usergroup_id)
                ->whereRaw('date(created_at) ='."'$registeron'");
        });
    }

    public function scopeUserGroupforStatus($query,$usergroup_id,$status) 
    {
        return $query->whereHas('userprofile', function ($q) use ($usergroup_id,$status) 
        {
            $q->where('usergroup_id',$usergroup_id)
                ->where('active',$status);
        });
    }

    public function scopeUserGroupforCountry($query,$usergroup_id,$country_id) 
    {

        return $query->whereHas('userprofile', function ($q) use ($usergroup_id,$country_id) 
        {
            $q->where('usergroup_id',$usergroup_id)
                ->where('country',$country_id);
        });
    }

    public function scopeUserGroupforEmail($query,$usergroup_id) 
    {
        return $query->whereHas('userprofile', function ($q) use ($usergroup_id) 
        {
            $q->where('usergroup_id',$usergroup_id)
                ->where('email_verified',1);
        });
    }
    
    public function downline()
    {
        return $this->hasMany('App\User', 'sponsor_id');
    }

    public function getSponsorCountAttribute()
    {
       return count($this->downline);
    }

     public function scopeUserGroupforKYCVerifyStatus($query,$usergroup_id) 
    {
        return $query->whereHas('userprofile', function ($q) use ($usergroup_id) 
        {
            $q->where('usergroup_id',$usergroup_id)
                ->where('kyc_verified_status',1);
        });
    }
  
     public function getUserBalanceAttribute() {
        return $this->getUserBalanceByUser($this);
    }
    
}