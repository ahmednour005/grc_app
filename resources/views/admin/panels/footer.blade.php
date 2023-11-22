<!-- BEGIN: Footer-->
<footer class="footer footer-light {{($configData['footerType'] === 'footer-hidden') ? 'd-none':''}} {{$configData['footerType']}}">
  <p class="clearfix mb-0">
    <span class="float-md-start d-block d-md-inline-block mt-25">{{ __('locale.COPYRIGHT') }} &copy;
      <script>document.write(new Date().getFullYear())</script><a class="ms-25" href="{{ getSystemSetting('APP_AUTHOR_WEBSITE', 'https://www.pksaudi.com/') }}" target="_blank">
        {{ session()->get('locale') == 'ar' ? getSystemSetting('APP_AUTHOR_ABBR_AR', 'Cyber Mode') : getSystemSetting('APP_AUTHOR_ABBR_EN', 'Cyber Mode') }}
        </a>,
      <span class="d-none d-sm-inline-block">{{ __('locale.All rights Reserved') }}</span>
    </span>
    {{-- <span class="float-md-end d-none d-md-block">Hand-crafted & Made with<i data-feather="heart"></i></span> --}}
  </p>
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
<!-- END: Footer-->
