<?php

namespace App\Repositories;

use App\Enums\UserStatusEnum;
use App\Models\Language;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository extends Repository
{
    public function model(): string
    {
        return User::class;
    }

    public function getAccountUsersWithFirstCheckin(int $accountId) {
        return $this->model->whereHas('checkinTests')->with(['checkinTests'])->where('account_id', $accountId)->get();
    }

    /**
     * Undocumented function
     *
     * @param array $options
     * @param string|null $name
     * @param string|null $active
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(array $options, string $name = null, string $status = null): LengthAwarePaginator|Collection
    {
        $page = $options['page'] ?? 1;
        $length = $options['per_page'] ?? 10;
        $order = isset($options['order']) ? $options['order'] :'ASC';
        $name = $options['name'] ?? null;
        $listAll = $options['list_all'] ?? null;

        $query =  $this->model;

        if(isset($name)){
            $query = $query->whereLike(['name','email','mobile'], $name);
        }
        
        if(isset($status) && $status === 'active'){
            $query = $query->where('status', UserStatusEnum::ACTIVE_STATUS);
        }
        if(isset($status) && $status === 'block'){
            $query = $query->where('status', UserStatusEnum::BLOCKED_STATUS);

        }   if(isset($status) && $status === 'deactivated'){
            $query = $query->where('status', UserStatusEnum::DEACTIVATED_STATUS);

        }
        if(isset($status) && $status === 'unverified'){
            $query = $query->where('status', UserStatusEnum::UNVERIFIED_STATUS);
        }
        if (isset($order)) {
            $query = $query->orderBy('id',$order);
        }

        if(isset($listAll) && $listAll == true){
            return $query->get();
         }
        return $query->with("userCredit")->paginate($length, ['*'], 'page', $page);
    }


    /**
     * Undocumented function
     *
     * @param array $options
     * @param string|null $name
     * @param string|null $active
     * @return mixed
     */
    public function getCanSchoolOwner($options = [])
    {
        $name = $options['name'] ?? null;
        $email = $options['email'] ?? null;
        $school_id = $options['school_id'] ?? null;

        $query= $this->model->select('id','name','email')->whereDoesntHave('roles',function($q){
            $q->where('code','student')
            ->orWhere(function ($query) {
                $query->where('code', 'schooladmin');
            })
            ->orWhere(function ($query) {
                $query->where('system_role', 1);
            });
        });
        if (isset($name)) {
            $query = $query->where('name','like',"%$name%");
        }

        if (isset($email)) {
            $query = $query->where('email','like',"%$email%");
        }

        $query = $query->whereDoesntHave('enrollments');

        return $query->get();
    }

    /**
     * findByEmail function
     *
     * @param [type] $email
     * @return array
     */
    public function findByEmail($email)
    {
        return $this->model->firstWhere('email', $email);
    }

    /**
     * findByEmail function
     *
     * @param [type] $email
     * @return array
     */
    public function getCanStudentEnroll($options = [])
    {
        $name = $options['name'] ?? null;
        $email = $options['email'] ?? null;

        $query= $this->model->select('id','name','email')->whereDoesntHave('roles')->whereDoesntHave('enrollments');
        if (isset($name)) {
            $query = $query->where('name','like',"%$name%");
        }

        if (isset($email)) {
            $query = $query->where('email','like',"%$email%");
        }

        $query = $query->whereDoesntHave('classStudents');

        return $query->get();
    }

    /**
     * findByEmail function
     *
     * @param [type] $email
     * @return array
     */
    public function getCanEnrollment($options = [])
    {
        $name = $options['name'] ?? null;
        $email = $options['email'] ?? null;
        $school_id = $options['school_id'] ?? null;

        $query= $this->model->select('id','name','email')->whereDoesntHave('roles',function($q){
            $q->where('code','student')->orWhere('system_role',1)->orWhere('code','schooladmin');
        });

        if (isset($name)) {
            $query = $query->where('name','like',"%$name%");
        }

        if (isset($email)) {
            $query = $query->where('email','like',"%$email%");
        }

        $query = $query->whereDoesntHave('enrollments',function($q) use($school_id){
            $q->where('school_id','!=',$school_id);
        });

        return $query->get();
    }



    public function getAccountUsers(int $id, array $options = []): LengthAwarePaginator
    {
        $page = $options['page'] ?? 1;
        $length = $options['per_page'] ?? 10;

        return $this->model->with(['logo'])
            ->withCount(['playedPrograms','playedProgramsLastMonth','sentPraiseMessagesLastMonth'])
            ->orderBy('played_programs_last_month_count', 'DESC')
            ->orderBy('sent_praise_messages_last_month_count', 'DESC')
            ->where('account_id', $id)->paginate($length, ['*'], 'page', $page);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function getAccountUsage()
    {
        $licencedAccounts = $this->model->where('account_id', auth()->user()->account_id)
            ->where('license_status', User::LICENSE_ACTIVE)->count();

        $activeCount = $this->model->withCount(['playedProgramsLastMonth', 'sentPraiseMessagesLastMonth'])
            ->having('played_programs_last_month_count', '>', 0)
            ->orHaving('sent_praise_messages_last_month_count', '>', 0)
            ->where('license_status', User::LICENSE_ACTIVE)
            ->where('account_id', auth()->user()->account_id)->count();

        $data = [
            'active_users' => $activeCount,
            'all_licenced_users' => $licencedAccounts,
            'inactive_users' => $licencedAccounts - $activeCount
        ];

        return $data;
    }

    public function suspendUsers($accountId)
    {
        $updateAll = $this->model->where('account_id', $accountId)
            ->where('license_status', User::LICENSE_ACTIVE)
            ->update(['license_status' => User::LICENSE_SUSPENDED]);
    }

    public function resetSuspendedUsers($accountId)
    {
        $updateAll = $this->model->where('account_id', $accountId)
            ->where('license_status', User::LICENSE_SUSPENDED)
            ->update(['license_status' => User::LICENSE_ACTIVE]);
    }

    public function listSchoolAdmins($options = [])
    {
        $page = $options['page'] ?? 1;
        $length = $options['per_page'] ?? 10;
        $order = isset($options['order']) ? $options['order'] :'ASC';
        $name = $options['name'] ?? null;
        $schoolID = $options['school_id'] ?? null;

        $query =  $this->model;

        if (isset($order)) {
            $query = $query->orderBy('id',$order);
        }

        $query = $query->where('school_id',$schoolID)->where('is_school_admin',1);

        return $query->paginate($length, ['*'], 'page', $page);


    }



}
