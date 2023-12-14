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
    $gs_addressinfo    = '';
    $gs_gmaplink    = '';
    if(!empty($generalSetting)){
      if(isset($generalSetting['gs_phone'])){
          $gs_phone       = $generalSetting['gs_phone'];
      }
      if(isset($generalSetting['gs_email'])){
          $gs_email       = $generalSetting['gs_email'];
      }
      if(isset($generalSetting['gs_addressinfo'])){
            $gs_addressinfo    = $generalSetting['gs_addressinfo'];
      }
      if(isset($generalSetting['gs_gmaplink'])){
          $gs_gmaplink    = $generalSetting['gs_gmaplink'];
      }
    }
    // dd($moduleData['inputs']);
@endphp 
@if ($moduleStatus == true && $moduleData != null)
<section class="contact">
    <div class="container">
      <div class="row">
        <h1>{{$moduleData['cfhead']}}</h1>
        <p>{{isset($moduleData['cfdesc']) ? $moduleData['cfdesc'] : ''}}</p>
        <div class="col-sm-12 col-md-12 col-lg-4 col-12 first-col">
          <h3>Get In Touch:</h3>
          <iframe src="{{$moduleData['cfaddlink']}}" class="rounded"></iframe>
          <ul class="p-0">
            <li class="pt-3" style="margin-right: 20px;"><a href="tel:{{$gs_phone}}"> <img src="{{asset('frontend-assets/images/iconn-1.png')}}" alt="Phone"
                  class="img-fluid me-2"> {{$gs_phone}}</a></li>
            <li class="pt-3" style="margin-right: 20px;"><a href="mailto:{{$gs_email}}"> <img src="{{asset('frontend-assets/images/iconn-2.png')}}" alt="Email"
                  class="img-fluid me-2"> {{$gs_email}}</a></li>
            <li class="pt-3" style="margin-right: 20px;"><a href="{{$gs_gmaplink??''}}"> <img src="{{asset('frontend-assets/images/iconn-3.png')}}" alt="Address"
                  class="img-fluid me-2"> {{$gs_addressinfo??''}}</a></li>
          </ul>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-8 col-12"> 
          <form class="formm" id="contact-form-control" metho d="POST" action="{{route('post-type.create-contacts')}}">
            @csrf
            <div id="success-msg" class="alert alert-success" style="display:none;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>
                              <div id="error-msg" class="alert alert-danger" style="display:none;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>
            <div class="row">

            @foreach ($moduleData['inputs'] as $input)
                
                @if($input['fieldtype'] !== 'textarea')
                  <div class="col-6 mb-2">
                      <label for="{{$input['fieldname']}}">{{$input['fieldtitle']}} {{isset($input['fieldrequired']) && $input['fieldrequired'][0] == 'on' ? '*' : ''}}</label>
                      <input type="{{$input['fieldtype']}}" name="{{$input['fieldname']}}" id="{{$input['fieldname']}}" class="form-control" placeholder="{{$input['fieldplaceholder']}}" {{isset($input['fieldrequired']) && $input['fieldrequired'][0] == 'on' ? 'required' : ''}}>
                  </div>
                @else
                  <div class="col-12">
                      <label for="{{$input['fieldname']}}">{{$input['fieldtitle']}} {{isset($input['fieldrequired']) && $input['fieldrequired'][0] == 'on' ? '*' : ''}}</label>
                      <textarea type="{{$input['fieldtype']}}" name="{{$input['fieldname']}}" id="{{$input['fieldname']}}" class="form-control" placeholder="{{$input['fieldplaceholder']}}" rows="3" cols="3" {{isset($input['fieldrequired']) && $input['fieldrequired'][0] == 'on' ? 'required' : ''}}></textarea>
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