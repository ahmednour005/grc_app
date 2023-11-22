@extends('admin.layouts.contentLayoutMaster')

@section('title', 'LDAP Authentication')
<!-- @section('title', __('configure.Extras')) -->

@section('vendor-style')
<!-- vendor css files -->
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
{{-- Page css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('content')

<!-- Basic Inputs start -->
<section id="basic-input">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('configure.ConfigurationLdap')}}</h4>
                    @if (auth()->user()->hasPermission('LDAP.test'))                    
                    <button class="dt-button  btn btn-info  me-2" type="button" onclick="testConnection()">
                        {{ __('configure.testConnection') }}
                    </button>
                    @endif                        
                </div>
                <div class="card-body">
                    @if (auth()->user()->hasPermission('LDAP.update'))
                    <form action="{{route('admin.configure.extras.LDAP-Configuration.save')}}" method="POST">
                        @CSRF
                    @endif
                        <div class="row">

                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="LDAPHOST">{{__('configure.LDAPHOST')}}</label>
                                    <input {{ auth()->user()->hasPermission('LDAP.update') ? '' : 'readonly' }} type="text" class="form-control " name="host"
                                        value="{{old('host',getLdapValue('LDAP_DEFAULT_HOSTS'))}}" id="host">
                                    @error('host')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="LDAPPORT">{{__('configure.LDAPPORT')}}</label>
                                    <input {{ auth()->user()->hasPermission('LDAP.update') ? '' : 'readonly' }} type="text" class="form-control " name="port"
                                        value="{{old('port',getLdapValue('LDAP_DEFAULT_PORT'))}}" id="port">
                                    @error('port')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="LDAPBASE_DN">{{__('configure.LDAPBASE_DN')}}</label>
                                    <input {{ auth()->user()->hasPermission('LDAP.update') ? '' : 'readonly' }} type="text" class="form-control " name="base_on"
                                        value="{{old('base_on',getLdapValue('LDAP_DEFAULT_BASE_DN'))}}" id="BASE_DN">
                                    @error('base_on')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="LDAPUSERNAME">{{__('configure.LDAPUSERNAME')}}</label>
                                    <input {{ auth()->user()->hasPermission('LDAP.update') ? '' : 'readonly' }} type="text" class="form-control " name="username"
                                        value="{{old('username',getLdapValue('LDAP_DEFAULT_USERNAME'))}}"
                                        id="LDAPUSERNAME">
                                    @error('username')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="LDAPFILTER">{{__('configure.LDAPFILTER')}}</label>
                                    <input {{ auth()->user()->hasPermission('LDAP.update') ? '' : 'readonly' }} type="text" class="form-control " name="filter"
                                        value="{{old('filter',getLdapValue('LDAP_USER_FLITER'))}}"
                                        id="LDAPFILTER">
                                        <small class="text-muted">ex: (cn=FS Training),(uid=training)</small>
                                    @error('filter')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="LDAPVSERSION">{{__('configure.LDAPVSERSION')}}</label>
                                    <input {{ auth()->user()->hasPermission('LDAP.update') ? '' : 'readonly' }} type="text" class="form-control " name="version"
                                        value="{{old('version',getLdapValue('LDAP_DEFAULT_VSERSION'))}}"
                                        id="LDAPVSERSION">
                                    @error('version')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="LDAP_Password">{{__('configure.LDAP_Password')}}</label>
                                    <input {{ auth()->user()->hasPermission('LDAP.update') ? '' : 'readonly' }} type="text" class="form-control " name="password"
                                        value="{{old('password',getLdapValue('LDAP_DEFAULT_PASSWORD'))}}"
                                        id="LDAP_Password">
                                    @error('password')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="LDAPTIMEOUT">{{__('configure.LDAPTIMEOUT')}}</label>
                                    <input {{ auth()->user()->hasPermission('LDAP.update') ? '' : 'readonly' }} type="text" class="form-control " name="timeout"
                                        value="{{old('timeout',getLdapValue('LDAP_DEFAULT_TIMEOUT'))}}"
                                        id="LDAPTIMEOUT">
                                    @error('timeout')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="LDAP_name">{{__('configure.LDAPFullName')}}</label>
                                    <input {{ auth()->user()->hasPermission('LDAP.update') ? '' : 'readonly' }} type="text" class="form-control " name="LDAP_name"
                                        value="{{old('LDAP_name',getLdapValue('LDAP_name'))}}"
                                        id="LDAP_name">
                                    @error('LDAP_name')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="LDAP_email">{{__('configure.LDAPEmail')}}</label>
                                    <input {{ auth()->user()->hasPermission('LDAP.update') ? '' : 'readonly' }} type="text" class="form-control " name="LDAP_email"
                                        value="{{old('LDAP_email',getLdapValue('LDAP_email'))}}"
                                        id="LDAP_email">
                                    @error('LDAP_email')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="LDAP_username">{{__('configure.LDAP_Username')}}</label>
                                    <input {{ auth()->user()->hasPermission('LDAP.update') ? '' : 'readonly' }} type="text" class="form-control " name="LDAP_username"
                                        value="{{old('LDAP_username',getLdapValue('LDAP_username'))}}"
                                        id="LDAP_username">
                                    @error('LDAP_username')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="LDAP_Dapartment">{{__('configure.LDAP_Dapartment')}}</label>
                                    <input {{ auth()->user()->hasPermission('LDAP.update') ? '' : 'readonly' }} type="text" class="form-control " name="LDAP_Dapartment"
                                        value="{{old('LDAP_Dapartment',getLdapValue('LDAP_Dapartment'))}}"
                                        id="LDAP_Dapartment">
                                    @error('LDAP_Dapartment')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="LDAP_Password">{{__('configure.LDAP_Password')}}</label>
                                    <input {{ auth()->user()->hasPermission('LDAP.update') ? '' : 'readonly' }} type="text" class="form-control " name="LDAP_Password"
                                        value="{{old('LDAP_Password',getLdapValue('LDAP_Password'))}}"
                                        id="LDAP_Password">
                                    @error('LDAP_Password')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>




                            <div class="col-xl-4 col-md-6 col-12">
                                <label class="form-label" for="LDAPFOLLOW">{{__('configure.LDAPFOLLOW')}}</label>
                                <div class="demo-inline-spacing">
                                    <div class="form-check form-check-inline">
                                        <input {{ auth()->user()->hasPermission('LDAP.update') ? '' : 'disabled' }} class="form-check-input" type="radio" name="follow" id="inlineRadio1"
                                            value="true" {{option_radio('true',getLdapValue('LDAP_DEFAULT_Follow'))}} />
                                        <label class="form-check-label" for="inlineRadio1">True</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input {{ auth()->user()->hasPermission('LDAP.update') ? '' : 'disabled' }} class="form-check-input" type="radio" name="follow" id="inlineRadio2"
                                            value="false"
                                            {{option_radio('false',getLdapValue('LDAP_DEFAULT_Follow'))}} />
                                        <label class="form-check-label" for="inlineRadio2">False</label>
                                    </div>


                                </div>
                                @error('follow')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-xl-4 col-md-6 col-12">
                                <label class="form-label" for="LDAPFOLLOW">{{__('configure.LDAPSSL')}}</label>
                                <div class="demo-inline-spacing">
                                    <div class="form-check form-check-inline">
                                        <input {{ auth()->user()->hasPermission('LDAP.update') ? '' : 'disabled' }} class="form-check-input" type="radio" name="ssl" id="inlineRadio1"
                                            value="true" {{option_radio('true',getLdapValue('LDAP_DEFAULT_SSL'))}} />
                                        <label class="form-check-label" for="inlineRadio1">True</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input {{ auth()->user()->hasPermission('LDAP.update') ? '' : 'disabled' }} class="form-check-input" type="radio" name="ssl" id="inlineRadio2"
                                            value="false" {{option_radio('false',getLdapValue('LDAP_DEFAULT_SSL'))}} />
                                        <label class="form-check-label" for="inlineRadio2">False</label>
                                    </div>


                                </div>
                                @error('ssl')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-xl-4 col-md-6 col-12">
                                <label class="form-label" for="LDAPFOLLOW">{{__('configure.LDAPTLS')}}</label>
                                <div class="demo-inline-spacing">
                                    <div class="form-check form-check-inline">
                                        <input {{ auth()->user()->hasPermission('LDAP.update') ? '' : 'disabled' }} class="form-check-input" type="radio" name="tls" id="inlineRadio1"
                                            value="true" {{option_radio('true',getLdapValue('LDAP_DEFAULT_TLS'))}} />
                                        <label class="form-check-label" for="inlineRadio1">True</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input {{ auth()->user()->hasPermission('LDAP.update') ? '' : 'disabled' }} class="form-check-input" type="radio" name="tls" id="inlineRadio2"
                                            value="false" {{option_radio('false',getLdapValue('LDAP_DEFAULT_TLS'))}} />
                                        <label class="form-check-label" for="inlineRadio2">False</label>
                                    </div>


                                </div>
                                @error('tls')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            @if (auth()->user()->hasPermission('LDAP.update'))                                
                            <div class="col-xl-12 mt-2 col-md-6 col-12">
                                <button class="btn btn-primary" type="submit">{{__('locale.Save')}}</button>
                            </div>
                            @endif                            

                        </div>
                        @if (auth()->user()->hasPermission('LDAP.update'))
                    </form>
                        @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Basic Inputs end -->
@endsection
@section('vendor-script')
<!-- vendor files -->

@endsection
@section('page-script')
<script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
<script src="{{ asset('ajax-files/compliance/define-test.js') }}"></script>
<script>
    function testConnection(){

        $.ajax({
          url: "{{ route('admin.configure.extras.LDAP-test-connection') }}",
          type:"GET",
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              success: function (data) {
                  if(data['valid']==true){
                      makeAlert('success',  data['message'], 'Connection');
                  }else{
                    makeAlert('error',  data['message']);
                  }

              },
              error: function() {
                  //
              }
        });
    }

</script>
@endsection
