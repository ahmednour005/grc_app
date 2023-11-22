<?php
namespace App\Http\Traits;
use LdapRecord\Container;
use LdapRecord\Connection;
use LdapRecord\Models\Entry;
use App\Models\Setting;
trait LdapTrait {

    public $connection;
    public $container;
    public $CheckConnection=true;
    public $MessageConnection='';
    /**
     * make connection with ldap
     *
     * @return array
     */
    public function LdapConnection()
    {
        $connection = new Connection([
            'hosts' => explode(',', getLdapValue('LDAP_DEFAULT_HOSTS')),
            'port' => getLdapValue('LDAP_DEFAULT_PORT'),
            'base_dn' => getLdapValue('LDAP_DEFAULT_BASE_DN'),
            'username' => getLdapValue('LDAP_DEFAULT_USERNAME'),
            'password' => getLdapValue('LDAP_DEFAULT_PASSWORD'),
            // Optional Configuration Options
            'use_ssl'          => (getLdapValue('LDAP_DEFAULT_SSL')=='true')?true:false,
            'use_tls'          => (getLdapValue('LDAP_DEFAULT_TLS')=='true')?true:false,
            'version'          => (int)getLdapValue('LDAP_DEFAULT_VSERSION'),
            'timeout'          => (int)getLdapValue('LDAP_DEFAULT_TIMEOUT'),
            'follow_referrals' => (getLdapValue('LDAP_DEFAULT_Follow')=='true')?true:false,
        ]);
        try {
            $connection->connect();
           $container=Container::addConnection($connection);
            $this->connection=$connection;
            $this->container=$container;
        } catch (\LdapRecord\Auth\BindException $e) {
            $error = $e->getDetailedError();

            echo $error->getErrorCode();
            echo $error->getErrorMessage();
            echo $error->getDiagnosticMessage();
        }


    }
    /**
     * get list users from ldap
     *
     * @return true
     */
    public function GetLdapUsers(){
        $this->LdapConnection();
       $this->connection->query();
          $Entries= array();
             if(getLdapValue('LDAP_USER_FLITER')){
                 $filters =explode (",", getLdapValue('LDAP_USER_FLITER'));

                $Entries= Entry::
                whereHas('sn')
                ->whereHas('cn')
                ->whereHas('uid')
                ->rawFilter($filters);
                if(getLdapValue('LDAP_name')){
                    $Entries=$Entries->whereHas(getLdapValue('LDAP_name'));
                }
                if(getLdapValue('LDAP_email')){
                    $Entries=$Entries->whereHas(getLdapValue('LDAP_email'));
                }
                if(getLdapValue('LDAP_username')){
                    $Entries=$Entries->whereHas(getLdapValue('LDAP_username'));
                }
                if(getLdapValue('LDAP_password')){
                    $Entries=$Entries->whereHas(getLdapValue('LDAP_password'));
                }
                if(getLdapValue('LDAP_dapartment')){
                    $Entries=$Entries->whereHas(getLdapValue('LDAP_dapartment'));
                }
                $Entries=$Entries->get();
             }else{
                $Entries= Entry::whereHas('sn')
                ->whereHas('cn');
                if(getLdapValue('LDAP_name')){
                    $Entries=$Entries->whereHas(getLdapValue('LDAP_name'));
                }
                if(getLdapValue('LDAP_email')){
                    $Entries=$Entries->whereHas(getLdapValue('LDAP_email'));
                }
                if(getLdapValue('LDAP_username')){
                    $Entries=$Entries->whereHas(getLdapValue('LDAP_username'));
                }
                if(getLdapValue('LDAP_password')){
                    $Entries=$Entries->whereHas(getLdapValue('LDAP_password'));
                }
                if(getLdapValue('LDAP_dapartment')){
                    $Entries=$Entries->whereHas(getLdapValue('LDAP_dapartment'));
                }
                $Entries=$Entries->get();

            }
        return $Entries;

    }

    public function FilterData(){
       $query = $this->connection->query();
       $results= $query->
       rawFilter('(samaccountname=jdoe)')->get();
      return $results;
    }


    /**
     * make connection with ldap
     *
     * @return array
     */
    public function LdapTestConnect()
    {
        $connection = new Connection([
            'hosts' => explode(',', getLdapValue('LDAP_DEFAULT_HOSTS')),
            'port' => getLdapValue('LDAP_DEFAULT_PORT'),
            'base_dn' => getLdapValue('LDAP_DEFAULT_BASE_DN'),
            'username' => getLdapValue('LDAP_DEFAULT_USERNAME'),
            'password' => getLdapValue('LDAP_DEFAULT_PASSWORD'),
            // Optional Configuration Options
            'use_ssl'          => (getLdapValue('LDAP_DEFAULT_SSL')=='true')?true:false,
            'use_tls'          => (getLdapValue('LDAP_DEFAULT_TLS')=='true')?true:false,
            'version'          => (int)getLdapValue('LDAP_DEFAULT_VSERSION'),
            'timeout'          => (int)getLdapValue('LDAP_DEFAULT_TIMEOUT'),
            'follow_referrals' => (getLdapValue('LDAP_DEFAULT_Follow')=='true')?true:false,
        ]);

        try {
            $connection->connect();
           $container=Container::addConnection($connection);
            $this->connection=$connection;
            $this->container=$container;
            $this->CheckConnection=true;
            $this->MessageConnection=__('locale.successfullyConnection');

        } catch (\LdapRecord\Auth\BindException $e) {
            $error = $e->getDetailedError();
            $this->CheckConnection= $error->getErrorCode();
            $this->MessageConnection= $error->getErrorMessage();
            // echo $error->getDiagnosticMessage();
        }

        return array(
            'valid'=> $this->CheckConnection,
            'message'=> $this->MessageConnection

        );

    }

    /**
     * make connection with ldap
     *
     * @return array
     */
    public function CheckExistUserLdap($mail,$username)
    {
        $this->LdapConnection();
        $user = $this->connection->query()->where('mail', '=', $mail)->where('givenname', '=', $username)->first();

        if($user){
            $name=$this->LdapName();
            $username=$this->LdapUsername();
            $email=$this->LdapEmail();
            $password=$this->LdapPassword();
            $department=$this->LdapDapartment();
            $fillable=array(
                'name'=>isset($user[$name])?$user[$name][0]:'',
                'username'=>isset($user[$username])?$user[$username][0]:'',
                'email'=>isset($user[$email])?$user[$email][0]:'',
                'password'=>isset($user[$password])?$user[$password][0]:'',
                'department'=>isset($user[$department])?$user[$department][0]:''
            );
            return $fillable;
        }else{
            return 0;
        }

    }

    /**
     * get name value with ldap
     *
     * @return array
     */
    public function LdapName()
    {
        $name=Setting::where('name','LDAP_name')->first();

            return $name->value;

    }
    /**
     * get username value with ldap
     *
     * @return array
     */
    public function LdapUsername()
    {
        $name=Setting::where('name','LDAP_username')->first();

            return $name->value;

    }

    /**
     * get email value with ldap
     *
     * @return array
     */
    public function LdapEmail()
    {
        $email=Setting::where('name','LDAP_email')->first();

            return $email->value;

    }
    /**
     * get password value with ldap
     *
     * @return array
     */
    public function LdapPassword()
    {
        $password=Setting::where('name','LDAP_password')->first();

            return $password->value;

    }

    /**
     * get dapartment value with ldap
     *
     * @return array
     */
    public function LdapDapartment()
    {
        $dapartment=Setting::where('name','LDAP_dapartment')->first();

            return $dapartment->value;

    }



}
