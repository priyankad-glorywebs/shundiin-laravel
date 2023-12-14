@php
    $contentData    = handleShortcodes($data['shortcode']);
    $moduleStatus   = $contentData['status'];
    $moduleData     = $contentData['data'];
    if($moduleStatus == true){
        $moduleData     = json_decode($moduleData[0]->content, true);    
    }
    $generalSetting = get_general_settings();
    $gs_phone       = '';
    $gs_email       = '';
    $gs_fblink       = '';
    $gs_instalink       = '';
    $gs_addressinfo    = '';
    $gs_gmaplink    = '';
    if(!empty($generalSetting)){
        if(isset($generalSetting['gs_phone'])){
            $gs_phone       = $generalSetting['gs_phone'];
        }
        if(isset($generalSetting['gs_email'])){
            $gs_email       = $generalSetting['gs_email'];
        }
        if(isset($generalSetting['gs_fblink'])){
            $gs_fblink       = $generalSetting['gs_fblink'];
        }
        if(isset($generalSetting['gs_instalink'])){
            $gs_instalink       = $generalSetting['gs_instalink'];
        }
        if(isset($generalSetting['gs_addressinfo'])){
            $gs_addressinfo    = $generalSetting['gs_addressinfo'];
        }
        if(isset($generalSetting['gs_gmaplink'])){
            $gs_gmaplink    = $generalSetting['gs_gmaplink'];
        }
    }
    // dd($moduleData);
@endphp 
@if ($moduleStatus == true && $moduleData != null)
<section class="contact-section">
    <div class="container">
      <div class="row">
        <h1>{{$moduleData['cfhead']}}</h1>
        <p>{{isset($moduleData['cfdesc']) ? $moduleData['cfdesc'] : ''}}</p>
        <div class="col-lg-4 col-12 first-col">
          <iframe
            src="{{$moduleData['cfaddlink']}}"
            class="rounded w-75"></iframe>
            <div class="first-links">
          <ul class="p-0">
            <li class="pt-3" style="margin-right: 20px;"><a href="tel:{{$gs_phone}}"> <img src="{{asset('frontend-assets/images/iconn-1.png')}}" alt="Phone"
                  class="img-fluid me-2">{{$gs_phone}}</a></li>
                  <li class="pt-3" style="margin-right: 20px;"><a href="mailto:{{$gs_email}}"> <img src="{{asset('frontend-assets/images/iconn-2.png')}}" alt="Email"
                    class="img-fluid me-2"> {{$gs_email}}</a></li>
                  <li class="pt-3" style="margin-right: 20px;"><a href="{{$gs_gmaplink??''}}"> <img src="{{asset('frontend-assets/images/iconn-3.png')}}" alt="Address"
                      class="img-fluid me-2"> {{$gs_addressinfo??''}}</a></li>
          </ul>
        </div>
          <div class="contact-sociallinks element">
            <h2 class="contact-heading element">Follow Us On:</h2>
            <ul class="social-links element">
                <li class="mx-1"><a href="{{$gs_fblink}}" target="_blank" class="fb">
                  <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="40" height="40" rx="20" fill="#343434"/><path d="M25.1667 11.2002H22.6667C21.5616 11.2002 20.5018 11.6392 19.7204 12.4206C18.939 13.202 18.5 14.2618 18.5 15.3669V17.8669H16V21.2002H18.5V27.8668H21.8333V21.2002H24.3333L25.1667 17.8669H21.8333V15.3669C21.8333 15.1458 21.9211 14.9339 22.0774 14.7776C22.2337 14.6213 22.4456 14.5335 22.6667 14.5335H25.1667V11.2002Z" fill="white"/></svg>
                </a></li>
                <li class="mx-1"><a href="{{$gs_instalink}}" target="_blank" class="insta">
                  <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="40" height="40" rx="20" fill="#343434"/><path d="M23.7002 10.1992H15.3669C12.5134 10.1992 10.2002 12.5124 10.2002 15.3659V23.6992C10.2002 26.5527 12.5134 28.8659 15.3669 28.8659H23.7002C26.5537 28.8659 28.8668 26.5527 28.8668 23.6992V15.3659C28.8668 12.5124 26.5537 10.1992 23.7002 10.1992Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M23.4121 21.4922C23.8319 20.6832 23.9859 19.7624 23.8522 18.8608C23.7158 17.9411 23.2873 17.0897 22.6299 16.4323C21.9725 15.7749 21.121 15.3463 20.2014 15.21C19.2998 15.0763 18.379 15.2303 17.57 15.6501C16.7609 16.0698 16.1049 16.7341 15.6951 17.5482C15.2853 18.3623 15.1427 19.285 15.2875 20.1849C15.4323 21.0847 15.8571 21.916 16.5016 22.5605C17.1461 23.205 17.9774 23.6299 18.8773 23.7747C19.7772 23.9195 20.6998 23.7769 21.514 23.3671C22.3281 22.9573 22.9923 22.3013 23.4121 21.4922Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M24.1172 14.9492H24.1278" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a></li>
            </ul>
        </div>
        </div>
        <div class="col-lg-8 col-12 border rounded second-col text-start">
          <form class="formm" id="contact-form-control" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="success-msg" class="alert alert-success" style="display:none;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>
                              <div id="error-msg" class="alert alert-danger" style="display:none;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>
            <div class="row">
              @foreach ($moduleData['inputs'] as $input)
                
                @if($input['fieldtype'] !== 'textarea')
                  <div class="col-6 mb-2">
                      <label for="{{$input['fieldname']}}">{{$input['fieldtitle']}} {{isset($input['fieldrequired']) && $input['fieldrequired'][0] == 'on' ? '*' : ''}}</label>
                      <input type="{{$input['fieldtype']}}" name="{{$input['fieldname']}}" id="{{$input['fieldname']}}" class="form-control" placeholder="{{$input['fieldplaceholder']}}" {{isset($input['fieldrequired']) && $input['fieldrequired'][0] == 'on' ? 'required' : ''}}>
                      <span class="text-danger error-text {{$input['fieldname']}}_error"></span>
                  </div>
                @else
                  <div class="col-12">  
                      <label for="{{$input['fieldname']}}">{{$input['fieldtitle']}} {{isset($input['fieldrequired']) && $input['fieldrequired'][0] == 'on' ? '*' : ''}}</label>
                      <textarea type="{{$input['fieldtype']}}" name="{{$input['fieldname']}}" id="{{$input['fieldname']}}" class="form-control" placeholder="{{$input['fieldplaceholder']}}" rows="3" cols="3" {{isset($input['fieldrequired']) && $input['fieldrequired'][0] == 'on' ? 'required' : ''}}></textarea>
                      <span class="text-danger error-text {{$input['fieldname']}}_error"></span>
                  </div>
                @endif

              @endforeach
              
              <div class="col-12 text-end">
                <div class="grd-btn position-relative d-inline-block">
                  <button type="submit" class="btn btn-outline-primary my-3">{{$moduleData['cfbtnlbl']?$moduleData['cfbtnlbl']:'Send Message'}}</button>
                </div>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
@endif