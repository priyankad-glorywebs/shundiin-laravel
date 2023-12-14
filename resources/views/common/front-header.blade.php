@php
    $generalSetting = get_general_settings();
    $gs_fblink       = '#';
    $gs_instalink    = '#';
    $gs_phone    = '';
    $gs_email    = '';
    $gs_addressinfo    = '';
    $gs_gmaplink    = '';
    $gs_ifbklink    = '';
    if(!empty($generalSetting)){
        if(isset($generalSetting['gs_fblink'])){
            $gs_fblink       = $generalSetting['gs_fblink'];
        }
        if(isset($generalSetting['gs_instalink'])){
            $gs_instalink    = $generalSetting['gs_instalink'];
        }
        if(isset($generalSetting['gs_phone'])){
            $gs_phone    = $generalSetting['gs_phone'];
        }
        if(isset($generalSetting['gs_email'])){
            $gs_email    = $generalSetting['gs_email'];
        }
        if(isset($generalSetting['gs_addressinfo'])){
            $gs_addressinfo    = $generalSetting['gs_addressinfo'];
        }
        if(isset($generalSetting['gs_gmaplink'])){
            $gs_gmaplink    = $generalSetting['gs_gmaplink'];
        }
        if(isset($generalSetting['gs_ifbklink'])){
            $gs_ifbklink    = $generalSetting['gs_ifbklink'];
        }
    }
@endphp 
<!-- ===== TOP-BAR START ===== -->
<section class="topbar-section">
  <div class="container">
    <div class="row d-lg-flex d-none align-items-center">
      <div class="col-12 col-lg-2 text-start">
        <ul class="social-links">
          <li><a href="{{$gs_fblink}}"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <rect width="20" height="20" rx="10"/> <path d="M12.5833 6H11.3333C10.7808 6 10.2509 6.21949 9.86019 6.61019C9.46949 7.00089 9.25 7.5308 9.25 8.08333V9.33333H8V11H9.25V14.3333H10.9167V11H12.1667L12.5833 9.33333H10.9167V8.08333C10.9167 7.97282 10.9606 7.86684 11.0387 7.7887C11.1168 7.71056 11.2228 7.66667 11.3333 7.66667H12.5833V6Z" fill="white"/> </svg></a></li>
          <li><a href="{{$gs_instalink}}"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <rect x="9.15527e-05" width="20" height="20" rx="10"/> <path d="M12.25 5.6H8.0833C6.71179 5.6 5.59997 6.71183 5.59997 8.08333V12.25C5.59997 13.6215 6.71179 14.7333 8.0833 14.7333H12.25C13.6215 14.7333 14.7333 13.6215 14.7333 12.25V8.08333C14.7333 6.71183 13.6215 5.6 12.25 5.6Z" stroke="white" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/> <path d="M12.0174 11.1005C12.2176 10.7147 12.291 10.2755 12.2273 9.84555C12.1622 9.40694 11.9578 9.00087 11.6443 8.68734C11.3308 8.3738 10.9247 8.16942 10.4861 8.10438C10.0561 8.04062 9.61695 8.11406 9.2311 8.31427C8.84526 8.51448 8.53237 8.83125 8.33693 9.21954C8.1415 9.60782 8.07347 10.0478 8.14253 10.477C8.21159 10.9062 8.41422 11.3027 8.7216 11.61C9.02897 11.9174 9.42544 12.12 9.85462 12.1891C10.2838 12.2582 10.7238 12.1901 11.1121 11.9947C11.5004 11.7993 11.8172 11.4864 12.0174 11.1005Z" stroke="white" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/> <path d="M12.4583 7.87499H12.4636" stroke="white" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/> </svg></a></li>
        </ul>          
      </div>
      <div class="col-12 col-lg-10 text-end">
        <ul class="contact-links">
          <li><a href="{{$gs_gmaplink??''}}" target="_blank">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="16" height="16" rx="8" fill="url(#paint0_linear_8_411)"/><path d="M8.00002 8.83807C7.71233 8.83807 7.43111 8.75429 7.19191 8.59731C6.95272 8.44034 6.76628 8.21723 6.65619 7.95619C6.5461 7.69515 6.5173 7.40791 6.57342 7.1308C6.62954 6.85368 6.76808 6.59914 6.9715 6.39935C7.17492 6.19956 7.43409 6.0635 7.71625 6.00838C7.9984 5.95326 8.29086 5.98155 8.55665 6.08967C8.82243 6.1978 9.0496 6.3809 9.20943 6.61583C9.36925 6.85075 9.45456 7.12695 9.45456 7.4095C9.4541 7.78824 9.3007 8.15134 9.02802 8.41915C8.75534 8.68696 8.38564 8.83762 8.00002 8.83807ZM8.00002 6.55236C7.82741 6.55236 7.65867 6.60263 7.51516 6.69681C7.37164 6.79099 7.25978 6.92486 7.19372 7.08148C7.12767 7.23811 7.11038 7.41045 7.14406 7.57672C7.17773 7.74299 7.26085 7.89572 7.38291 8.01559C7.50496 8.13546 7.66046 8.2171 7.82976 8.25017C7.99905 8.28324 8.17452 8.26627 8.33399 8.2014C8.49346 8.13652 8.62977 8.02666 8.72566 7.8857C8.82156 7.74475 8.87274 7.57903 8.87274 7.4095C8.87251 7.18224 8.78049 6.96435 8.61687 6.80366C8.45325 6.64296 8.23141 6.55258 8.00002 6.55236Z" fill="white"/><path d="M7.99999 12.2667L5.54588 9.4241C5.51178 9.38142 5.47803 9.33846 5.44465 9.29524C5.02544 8.75289 4.79898 8.09045 4.79999 7.40953C4.79999 6.57599 5.13713 5.77659 5.73725 5.18719C6.33736 4.59779 7.1513 4.26667 7.99999 4.26667C8.84868 4.26667 9.66261 4.59779 10.2627 5.18719C10.8628 5.77659 11.2 6.57599 11.2 7.40953C11.201 8.09014 10.9746 8.75228 10.5556 9.29438L10.5553 9.29524C10.5553 9.29524 10.4681 9.40781 10.455 9.42296L7.99999 12.2667ZM5.90894 8.95096C5.90952 8.95096 5.97701 9.03896 5.99243 9.05781L7.99999 11.3832L10.0102 9.05467C10.023 9.03896 10.091 8.95038 10.0913 8.9501C10.4338 8.50699 10.6188 7.96582 10.6182 7.40953C10.6182 6.72754 10.3423 6.07349 9.85132 5.59125C9.36032 5.10902 8.69437 4.8381 7.99999 4.8381C7.3056 4.8381 6.63966 5.10902 6.14866 5.59125C5.65765 6.07349 5.38181 6.72754 5.38181 7.40953C5.3812 7.96617 5.56618 8.50764 5.90894 8.95096Z" fill="white"/><defs><linearGradient id="paint0_linear_8_411" x1="8" y1="0" x2="8" y2="16" gradientUnits="userSpaceOnUse"><stop stop-color="#FAA433"/><stop offset="1" stop-color="#AB4223"/></linearGradient></defs></svg>
            {{$gs_addressinfo??''}}</a></li>
          <li><a href="mailto:{{$gs_email??''}}">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="16" height="16" rx="8" fill="url(#paint0_linear_8_408)"/><path d="M8.26666 12.2667C7.72 12.2667 7.20333 12.1616 6.71666 11.9515C6.23 11.7413 5.80493 11.4547 5.44146 11.0915C5.07826 10.7283 4.7916 10.3033 4.58146 9.81667C4.37133 9.33 4.2664 8.81334 4.26666 8.26667C4.26666 7.71334 4.37173 7.19494 4.58186 6.71147C4.792 6.228 5.07866 5.8048 5.44186 5.44187C5.80506 5.0784 6.22986 4.79174 6.71626 4.58187C7.20266 4.372 7.71946 4.26694 8.26666 4.26667C8.82 4.26667 9.3384 4.37174 9.82186 4.58187C10.3053 4.792 10.7285 5.07867 11.0915 5.44187C11.4549 5.80507 11.7416 6.2284 11.9515 6.71187C12.1613 7.19534 12.2664 7.7136 12.2667 8.26667V8.84667C12.2667 9.24 12.1317 9.57507 11.8619 9.85187C11.592 10.1287 11.2603 10.2669 10.8667 10.2667C10.6267 10.2667 10.4033 10.2133 10.1967 10.1067C9.99 10 9.82 9.86 9.68666 9.68667C9.50666 9.86667 9.29493 10.0084 9.05146 10.1119C8.808 10.2153 8.5464 10.2669 8.26666 10.2667C7.71333 10.2667 7.2416 10.0716 6.85146 9.68147C6.46133 9.29134 6.2664 8.81974 6.26666 8.26667C6.26666 7.71334 6.46173 7.2416 6.85186 6.85147C7.242 6.46134 7.7136 6.2664 8.26666 6.26667C8.82 6.26667 9.29173 6.46174 9.68186 6.85187C10.072 7.242 10.2669 7.7136 10.2667 8.26667V8.84667C10.2667 9.04 10.3267 9.1916 10.4467 9.30147C10.5667 9.41134 10.7067 9.4664 10.8667 9.46667C11.0267 9.46667 11.1667 9.4116 11.2867 9.30147C11.4067 9.19134 11.4667 9.03974 11.4667 8.84667V8.26667C11.4667 7.39334 11.1516 6.6416 10.5215 6.01147C9.89133 5.38134 9.13973 5.0664 8.26666 5.06667C7.39333 5.06667 6.6416 5.38174 6.01146 6.01187C5.38133 6.642 5.0664 7.3936 5.06666 8.26667C5.06666 9.14 5.38173 9.89174 6.01186 10.5219C6.642 11.152 7.3936 11.4669 8.26666 11.4667H10.2667V12.2667H8.26666ZM8.26666 9.46667C8.6 9.46667 8.88333 9.35 9.11666 9.11667C9.35 8.88334 9.46666 8.6 9.46666 8.26667C9.46666 7.93334 9.35 7.65 9.11666 7.41667C8.88333 7.18334 8.6 7.06667 8.26666 7.06667C7.93333 7.06667 7.65 7.18334 7.41666 7.41667C7.18333 7.65 7.06666 7.93334 7.06666 8.26667C7.06666 8.6 7.18333 8.88334 7.41666 9.11667C7.65 9.35 7.93333 9.46667 8.26666 9.46667Z" fill="white"/><defs><linearGradient id="paint0_linear_8_408" x1="8" y1="0" x2="8" y2="16" gradientUnits="userSpaceOnUse"><stop stop-color="#FAA433"/><stop offset="1" stop-color="#AB4223"/></linearGradient></defs></svg>
            {{$gs_email??''}}</a></li>
          <li class="me-0"><a href="tel:{{$gs_phone??''}}">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="16" height="16" rx="8" fill="url(#paint0_linear_8_395)"/><path d="M11.344 12.2667H11.2917C5.24775 11.919 4.38961 6.81744 4.26965 5.26052C4.25999 5.13946 4.27429 5.01769 4.31175 4.90218C4.34921 4.78667 4.40909 4.67969 4.48795 4.58736C4.56681 4.49504 4.6631 4.41919 4.77132 4.36416C4.87953 4.30913 4.99754 4.276 5.11857 4.26667H6.81333C6.93654 4.26655 7.05694 4.30344 7.15894 4.37257C7.26094 4.44169 7.33984 4.53986 7.38543 4.65436L7.85295 5.80513C7.89796 5.91699 7.90913 6.03962 7.88507 6.15778C7.86101 6.27593 7.80278 6.38442 7.71761 6.46975L7.06247 7.13129C7.16481 7.71305 7.44331 8.24934 7.8603 8.66758C8.27729 9.08582 8.81264 9.36584 9.39392 9.46975L10.0614 8.80821C10.1479 8.72395 10.2574 8.66706 10.3761 8.64462C10.4948 8.62219 10.6175 8.63521 10.7288 8.68206L11.8884 9.14667C12.0011 9.19371 12.0973 9.27326 12.1647 9.37518C12.2321 9.47711 12.2676 9.59679 12.2667 9.71898V11.3436C12.2667 11.5884 12.1695 11.8232 11.9964 11.9963C11.8234 12.1694 11.5887 12.2667 11.344 12.2667ZM5.19239 4.88206C5.11082 4.88206 5.03258 4.91447 4.9749 4.97218C4.91722 5.02988 4.88481 5.10814 4.88481 5.18975V5.21436C5.0263 7.0359 5.93366 11.3436 11.3255 11.6513C11.3659 11.6538 11.4064 11.6483 11.4447 11.6351C11.483 11.6219 11.5183 11.6013 11.5486 11.5744C11.5789 11.5475 11.6035 11.5149 11.6212 11.4785C11.6389 11.4421 11.6492 11.4025 11.6516 11.3621V9.71898L10.492 9.25436L9.60923 10.1313L9.46159 10.1128C6.78565 9.77744 6.42271 7.10052 6.42271 7.07282L6.40425 6.92513L7.27778 6.04206L6.81641 4.88206H5.19239Z" fill="white"/><defs><linearGradient id="paint0_linear_8_395" x1="8" y1="0" x2="8" y2="16" gradientUnits="userSpaceOnUse"><stop stop-color="#FAA433"/><stop offset="1" stop-color="#AB4223"/></linearGradient></defs></svg>
            {{$gs_phone}}</a></li>
        </ul>
      </div>
    </div>
  </div>
</section>


<!-- ===== NAVBAR START ===== -->
<section class="bottom-navbar-section bg-white">
  <div class="container">
    <nav class="navbar navbar-expand-lg">
      <a class="navbar-brand" href="{{url('/')}}"><img src="{{asset('frontend-assets/images/header-logo.png')}}" alt="Header Logo" class="img-fluid"></a>
      <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
          aria-label="Toggle navigation">
          <div class="hamburger-menu"> <span></span> <span></span> <span></span> <span></span> </div>
          <!--<span class="navbar-toggler-icon"></span>-->
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link home" aria-current="page" href="{{route('home')}}">HOME</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('tours')}}">TOUR</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('about-us')}}">ABOUT US</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('gallery')}}">GALLERY</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{('blog')}}">BLOG</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('contact-us')}}">CONTACT US</a>
            </li>
          </ul>
          <a href="{{$gs_ifbklink??''}}" class="btn btn-primary">BOOK ONLINE</a>
      </div>
    </nav>
  </div>
</section>