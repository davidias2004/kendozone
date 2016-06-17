<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\AuditingTrait;

class Club extends Model
{

    protected $table = 'club';
    public $timestamps = true;
    protected $guarded = ['id'];
    use SoftDeletes;
    use AuditingTrait;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($club) {

//            $club->clubs
            //TODO Unlink all clubs/users from assoc
//            foreach ($tournament->categoryTournaments as $ct) {
//                $ct->delete();
//            }
//            $tournament->invites()->delete();

        });
        static::restoring(function ($club) {

//            foreach ($tournament->categoryTournaments()->withTrashed()->get() as $ct) {
//                $ct->restore();
//            }

        });

    }

    public function president()
    {
        return $this->hasOne(User::class, 'id', 'president_id');
    }

//    public function vicepresident()
//    {
//        return $this->hasOne(User::class,'id','vicepresident_id');
//    }
//
//    public function secretary()
//    {
//        return $this->hasOne(User::class,'id','secretary_id');
//    }
//
//    public function treasurer()
//    {
//        return $this->hasOne(User::class,'id','treasurer_id');
//    }

//    public function admin()
//    {
//        return $this->hasOne(User::class,'id','admin_id');
//    }


    public function practicants()
    {
        return $this->hasMany('User');
    }

    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    public function scopeForUser($query, User $user)
    {

        if ($user->isFederationPresident() && $user->federationOwned != null) {
            $query->whereHas('association.federation', function ($query) use ($user) {
                $query->where('federation_id', $user->federationOwned->id);
            });
        }

        if ($user->isAssociationPresident() && $user->associationOwned) {
            $query->whereHas('association', function ($query) use ($user) {
                $query->where('id', $user->associationOwned->id);
            });
        }

        if ($user->isClubPresident() && $user->clubOwned) {
            $query->where('id', $user->clubOwned->id);
        }
    }

    public function belongsToFederationPresident(User $user) // Should be FederationUser????
    {
        return
            $user->federationOwned  != null &&
            $this->association      != null &&
            $this->association->federation != null &&
            $user->federationOwned->id == $this->association->federation->id;

    }

    public function belongsToAssociationPresident(User $user)
    {
        return  $user->associationOwned !=null &&
                $this->association != null &&
                $user->associationOwned->id == $this->association->id;

    }

    public function belongsToClubPresident(User $user)
    {
        return  $user->clubOwned != null &&
                $user->clubOwned->id == $this->id;

    }

}
