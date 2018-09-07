<?php

namespace App;
//use App\Events\BuycoinSaved;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Coinorder extends Model
{

    use PresentableTrait;

    protected $presenter = "App\Presenters\SitePresenter";

    protected $table='coin_orders';

    protected $fillable = ['from_user_id','to_user_id','type','amount','order_amount','transaction_id','request_coin_id','from_currency','status','transaction_id','commission','to_amount','request','bitcoin_hash_id','payment_gateway_id','coin_orders_ref_id','approve_at','receive_amount','comments_approve','process_via','comments_pending','btc_hash_id','ltc_hash_id','eth_hash_id'];

    protected $dates=['approve_at','cancel_at'];

    protected $appends = array('levelcommission', 'referralcommission');

    public function buyer() {
        return $this->hasOne('App\User', 'id', 'from_user_id');
    }

   
    public function getReferralcommissionAttribute() {
        if($this->type === "order" && $this->status === "approve") {
        $Referralcommission = new \stdClass;
        $Referralcommission->beneficiary = $this->buyer->sponsor;
        $Referralcommission->percentage = $this->buyer->sponsor->referralgroup->referral_commission;
        $Referralcommission->commission = $this->buyer->sponsor->referralgroup->referral_commission * $this->amount * 0.01 ;

        return $Referralcommission;
        } else {
            throw new \Exception("Commission can't be calculated for this order");
        }
    }

    public function getLevelcommissionAttribute() {
        
        if($this->type === "order" && $this->status === "approve") {
            $levelCommission = collect();
            
             $benificiaryUsers = $this->buyer->uplines;
            
             foreach($benificiaryUsers as $key=>$benificiaryUser) {
     
                 $levelCommissionArray = json_decode($benificiaryUser->referralgroup->level_commission);
                 $maxCommission = count($levelCommissionArray);
     
                 $commission = new \stdClass;
                 $commission->level = $key+1;
                 $commission->beneficiary = $benificiaryUser;
                 if($key < $maxCommission){
                     $commission->percentage = $levelCommissionArray[$key]->commission_value;
                     $commission->commission = $levelCommissionArray[$key]->commission_value * $this->amount * 0.01 ;
                 } else {
                     $commission->percentage = null;
                     $commission->commission = null ;
                 }      
                 $levelCommission->push($commission);
             }
             return $levelCommission;
        } else {
            throw new \Exception("Commission can't be calculated for this order");
        }
        
    }
    public function tocurrency()
    {
        return $this->belongsTo('App\Models\Currency','request_coin_id');
    }
    public function fromcurrency()
    {
        return $this->belongsTo('App\Models\Currency','from_currency');
    }

    // protected $dispatchesEvents = [
    //     'saved' => BuycoinSaved::class,
    // ];
}
