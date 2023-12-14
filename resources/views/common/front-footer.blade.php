@php
    $generalSetting = get_general_settings();
    $gs_fblink       = '#';
    $gs_instalink    = '#';
    $gs_copyinfo    = '';
    $gs_ifbklink    = '';
    if(!empty($generalSetting)){
      if(isset($generalSetting['gs_fblink'])){
          $gs_fblink       = $generalSetting['gs_fblink'];
      }
      if(isset($generalSetting['gs_instalink'])){
          $gs_instalink    = $generalSetting['gs_instalink'];
      }
      if(isset($generalSetting['gs_copyinfo'])){
          $gs_copyinfo    = $generalSetting['gs_copyinfo'];
      }
      if(isset($generalSetting['gs_ifbklink'])){
          $gs_ifbklink    = $generalSetting['gs_ifbklink'];
      }
    }
@endphp 
<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="comb">
          <div class="col-auto social-icons text-center">
            <a href="{{$gs_fblink}}" class="fb"><svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="50" height="50" rx="25" fill="#282828"/><path d="M31.4583 14H28.3333C26.952 14 25.6272 14.5487 24.6505 15.5255C23.6737 16.5022 23.125 17.827 23.125 19.2083V22.3333H20V26.5H23.125V34.8333H27.2917V26.5H30.4167L31.4583 22.3333H27.2917V19.2083C27.2917 18.9321 27.4014 18.6671 27.5968 18.4718C27.7921 18.2764 28.0571 18.1667 28.3333 18.1667H31.4583V14Z" fill="#fff"/></svg></a>
            <a href="{{$gs_instalink}}" class="insta">
              <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="0.00012207" width="50" height="50" rx="25" fill="#282828"/><path d="M29.6252 13H19.2086C15.7798 13 13.0002 15.7796 13.0002 19.2083V29.625C13.0002 33.0538 15.7798 35.8333 19.2086 35.8333H29.6252C33.054 35.8333 35.8336 33.0538 35.8336 29.625V19.2083C35.8336 15.7796 33.054 13 29.6252 13Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M29.0437 26.7514C29.5443 25.7867 29.7279 24.6889 29.5685 23.6139C29.4059 22.5174 28.8949 21.5022 28.1111 20.7184C27.3272 19.9345 26.3121 19.4236 25.2155 19.261C24.1406 19.1016 23.0427 19.2852 22.0781 19.7857C21.1135 20.2862 20.3312 21.0782 19.8426 22.0489C19.3541 23.0196 19.184 24.1196 19.3566 25.1926C19.5293 26.2655 20.0359 27.2567 20.8043 28.0251C21.5727 28.7936 22.5639 29.3001 23.6369 29.4728C24.7098 29.6454 25.8099 29.4754 26.7806 28.9868C27.7513 28.4982 28.5432 27.716 29.0437 26.7514Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M30.1461 18.6875H30.1594" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
          </div>
          <div class="navigation">

            <ul class="navbar justify-content-center">
              <li class="nav-item">
                <a class="nav-link home" aria-current="page" href="{{route('home')}}">
                  HOME</a>
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
                <a class="nav-link" href="{{url('contact-us')}}">CONTACT US</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="copyright">
    <div class="container element">
      <div class="row element">
        <div class="col-12 element m-auto">
          <p class="copy-pera element"><span>Shun’Diin Tours</span> {{$gs_copyinfo??''}}</p>
        </div>
      </div>
    </div>
  </section>
</footer>

<a href="{{$gs_ifbklink??''}}" class="fh-button-flat-orange fh-fixed--bottom fh-icon--calendar-check fh-hide--mobile" style="left:20px !important; right:inherit !important">Book A Tour</a>